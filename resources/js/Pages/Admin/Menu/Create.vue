<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import { Inertia } from '@inertiajs/inertia';

const nama_menu = ref('');
const harga = ref('');

const tambahMenu =()=>{
Inertia.post(route('tambahMenu',{
    nama_menu:nama_menu.value,
    harga:harga.value
})).then(()=>{
    nama_menu.value='';
    harga.value='';
});
};


</script>

<template>
<AdminSidebarLayout>
    
    <template #header>Menu</template>
    <template #content>
        <Head title="Buat Menu" />
        <div class="container mx-auto mt-6 max-w-lg bg-gray-200 px-4 py-2 rounded-md ">
        <h3 class="text-2xl font-bold m-4 text-center">Form Tambah Menu</h3>
       
            <form @submit.prevent="tambahMenu">
            <div class="mt-4 mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nama:</label>
                <input v-model="nama_menu" type="text" required class="form-input w-full border border-black rounded-md mb-4" />
                <label class="block text-gray-700 font-medium mb-2">Harga:</label>
                <input v-model="harga" type="number" required class="form-input w-full border border-black rounded-md" />
            </div>

            <div class=" flex justify-end my-4" >
                <Link :href="route('IndexMenu')">
                    <btnCom>Batal</btnCom>
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