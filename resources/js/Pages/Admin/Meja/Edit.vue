<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import formMeja from '@/Layouts/formMeja.vue'
import { Inertia } from '@inertiajs/inertia';

const {props}= usePage();
const form = ref({
    jumlah_orang: props.meja.jumlah_orang,

})
const updateMeja=()=>{
    Inertia.put(`/update/meja/${props.meja.id_meja}`, form.value);
};
</script>

<template>
<AdminSidebarLayout>
   
    <template #header>Meja</template>
    <template #content>
        <Head title="Edit Meja" />
        <div class="container mx-auto mt-6 max-w-lg bg-gray-200 px-4 py-2 rounded-md ">
        <h3 class="text-2xl font-bold m-4 text-center">Form Edit Meja</h3>
       
            <form @submit.prevent="updateMeja">
            <div class="mt-4 mb-4">
                <label class="block text-gray-700 font-medium mb-2">Kapasitas:</label>
                <input v-model="form.jumlah_orang" required type="number" class="form-input w-full border border-black rounded-md" />
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