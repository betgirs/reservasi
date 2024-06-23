<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import btnCom from '@/Components/btnCom.vue';


const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

function buatReservasi(){
    if (!props.canLogin) {
        Inertia.get(`/login`);
    } else {
        Inertia.get(`/create/reservasi`);
    }
}
// function buatReservasi(){
//     Inertia.get(`/create/reservasi`);
// }

function lihatReservasi(){
    Inertia.get(`/reservasi`);
}
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <template #main>

            <div class="relative min-h-screen bg-cover bg-center  " style="background-image: url('/img/food.png');">
                <div class="absolute inset-0 bg-gray-500 bg-opacity-50 flex flex-col justify-center items-center ">
                    <h1 class=" text-5xl font-bold text-gray-300 hover:text-black font-bold  mb-4">Selamat Datang di Elaska Restaurant:)</h1>
                    <btnCom class=" animate-pulse hover:bg-white hover:text-black text-white font-bold py-2 px-4 rounded" @click="buatReservasi">
                        Buat Reservasi
                    </btnCom>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
