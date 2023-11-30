<?php

namespace App\Http\Controllers;

use App\Models\Retiro;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetiroController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Retiros/Index', compact('user'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'cantidad_retirar'=> 'required|integer|min:1|max:2000',
        ]);

        $saldo = Auth::user()->saldo;

        $cantidadRetirar = $request->input('cantidad_retirar');

        if ($saldo >= $cantidadRetirar) {
            $estado = 'retiro exitoso';
        } else {
            $estado = 'fondos insuficientes';
        };

        Retiro::create([
            'user_id' => Auth::user()->id,
            'fecha_retiro' => now(),
            'cantidad_retirar' => $cantidadRetirar,
            'estado' =>  $estado,
        ]);

        $usuario = auth()->user();
        $usuario->saldo -= $cantidadRetirar;
        $usuario->save();

        return redirect()->route('retiros.billetes')->with('message', 'Retiro Exitoso');
    }

    public function cantidadBilletes()
    {
        $ultimoRetiro = Retiro::where('user_id', auth()->user()->id)
            ->latest('fecha_retiro')
            ->first();

        if ($ultimoRetiro) {
            $cantidadRetirar = $ultimoRetiro->cantidad_retirar;

            $numeroBilletes = $this->billetes($cantidadRetirar);

            return Inertia::render('Retiros/Billetes', ['numeroBilletes' => $numeroBilletes]);
        }

        return Inertia::render('Retiros/Billetes', ['numeroBilletes' => []]);
    }


    public function billetes($cantidad)
    {
        $valores = [50, 20, 10, 5, 2, 1];

        $numeroBilletes = [];

        foreach ($valores as $valor) {
            if ($cantidad >= $valor) {
                $decimal = $cantidad / $valor ;
                $cantidadBilletes = intval($decimal);
                $valorBilletes = $cantidadBilletes * $valor;
                $cantidad = $cantidad - $valorBilletes;

                if ($cantidadBilletes > 0) {
                    $numeroBilletes[] = [
                        'valor' => $valor,
                        'cantidad' => $cantidadBilletes,
                    ];
                }
            }
        }

        return $numeroBilletes;
    }
}
