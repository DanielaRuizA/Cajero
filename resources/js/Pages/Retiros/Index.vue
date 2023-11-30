<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout
    },
    props: {
        user: Object,
        errors: Object,
    },
    data() {
        return {
            form: useForm({
                cantidad_retirar: '',
            }),
        }
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('retiros.store'), this.form);
        },
    },
}

</script>

<template>
    <AppLayout title="Dashboard">
        <h1>Retiros</h1>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-6 border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Saldo</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ user.saldo }}</dd>
                    </div>
                </dl>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <label class="text-sm font-medium leading-6 text-gray-900">¿Cuánto desea retirar?</label>
                    <input v-model="form.cantidad_retirar"
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-gray-900 font-bold py-2 px-4 rounded-md">Retirar</button>
                    <div v-if="errors.cantidad_retirar" class="text-red-600">
                        {{ errors.cantidad_retirar }}
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
