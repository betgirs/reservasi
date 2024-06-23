<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import { Inertia } from '@inertiajs/inertia';

const jumlah_orang = ref('');
const tambahMeja =()=>{
    Inertia.post('/create/meja',{
        jumlah_orang : jumlah_orang.value,
    }).then(()=>{
        jumlah_orang.value ='';
    });
};

</script>

<template>
<AdminSidebarLayout>
   
    <template #header>Meja</template>
    <template #content>
        <Head title="Buat Meja" />
        <div class="container mx-auto mt-6 max-w-lg bg-gray-200 px-4 py-2 rounded-md ">
        <h3 class="text-2xl font-bold m-4 text-center">Form Tambah Meja</h3>
       
            <form @submit.prevent="tambahMeja">
            <div class="mt-4 mb-4">
                <label class="block text-gray-700 font-medium mb-2">Kapasitas:</label>
                <input v-model="jumlah_orang" type="number" required class="form-input w-full border border-black rounded-md" />
            </div>

            <div class=" flex justify-end my-4" >
                <Link :href="route('IndexMeja')">
                    <btnCom type="button" >Batal</btnCom>
                </Link>
                <btnCom type="submit">Simpan</btnCom>
            </div>
            </form>
       
    </div>
      
    </template>
</AdminSidebarLayout> 


</template>

<style>


</style>