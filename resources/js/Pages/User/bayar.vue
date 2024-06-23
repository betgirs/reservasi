<script setup>
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


import btnCom from '@/Components/btnCom.vue';

const props = defineProps({
    reservasi: Object,
    errors: Object,
})

const form = ref({
    'id_reservasi': props.reservasi.id_reservasi,
    'tanggal_pembayaran': '',
    'total_pembayaran': '',
})

const fileError = ref('');

const validFileTypes = ['image/jpg', 'image/jpeg', 'image/png'];
const maxSize = 2 * 1024 * 1024;

const bukti_pembayaran = ref(null);

const bayar = (id_reservasi) => {
    const file = bukti_pembayaran.value.files[0];

    if (file){
        if(!validFileTypes.includes(file.type)){
            fileError.value = 'File harus berbentuk jpg atau png';
            return;
        }
        if(file.size>maxSize){
            fileError.value = 'File terlalu besar. Batas ukuran adalah 2 MB';
            return; 
        }
    }
    fileError.value='';


    const formData = new FormData();
    formData.append('id_reservasi', form.value.id_reservasi);
    formData.append('tanggal_pembayaran', form.value.tanggal_pembayaran);
    formData.append('total_pembayaran', form.value.total_pembayaran);
    formData.append('bukti_pembayaran', bukti_pembayaran.value.files[0]);

    Inertia.post(`/pembayaran/${id_reservasi}`, formData);
}

const kembali = (id_reservasi) => {
    Inertia.get(`/orders/create/${id_reservasi}`)
}


</script>

<template>
    <AuthenticatedLayout>
          <Head title="Pembayaran" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran</h2>
        </template>

        <template #main>
            <div class="container mx-auto max-w-xl mt-6 bg-gray-200 px-4 py-2 rounded-md border border-black shadow-md shadow-gray-400">
                <div class="text-center">
                    <h3 class="text-2xl font-bold m-4">Pembayaran</h3>
                    <p class="mb-4">Kirim ke No.rek berikut: 1234567890 (BCA)</p>
                </div>
                <form @submit.prevent="bayar(props.reservasi.id_reservasi)" class="flex flex-col">
                    <label>Tanggal Pembayaran</label>
                    <input v-model="form.tanggal_pembayaran" type="date" required class="border border-black rounded-md mb-4"></input>
                    <label>Total Pembayaran</label>
                    <input v-model="form.total_pembayaran" type="number" required class="border border-black rounded-md mb-4"></input>
                    <label>Bukti Pembayaran</label>
                    <input ref="bukti_pembayaran" type="file" required class="border border-black rounded-md mb-4"></input>
                    <div v-if="fileError" class="text-red-500 mb-4">{{fileError}}</div>
                    <div v-if="props.reservasi.pembayaran && props.reservasi.pembayaran.bukti_pembayaran" class="mb-4">
                        <label>Preview Bukti Pembayaran</label>
                        <a :href="props.reservasi.pembayaran.bukti_pembayaran" target="_blank">Lihat Bukti Pembayaran</a>
                    </div>
                    <div class="flex flex-row-reverse py-4">
                        <btnCom @click="bayar">Kirim</btnCom>
                        <btnCom @click="kembali(props.reservasi.id_reservasi)">Kembali</btnCom>
                    </div>
                </form>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style>

</style>
