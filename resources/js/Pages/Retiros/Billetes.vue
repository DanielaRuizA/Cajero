<script>
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
    components: {
        AppLayout
    },
    props: {
        numeroBilletes: Array,
    },
}

</script>

<template>
    <AppLayout title="Dashboard">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h1>Retiros</h1>
            <div class="mt-4">
                <p>La cantidad de billetes es:</p>
                <ul>
                    <li v-for="billete in numeroBilletes" :key="billete.valor">
                        son {{ billete.cantidad }} billetes de {{ billete.valor }}
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>