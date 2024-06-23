<script setup>
import { Head, Link,usePage, useForm} from '@inertiajs/vue3'
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';

const {props} = usePage();
const form = ref({
    nama_menu:props.menu.nama_menu,
    harga:props.menu.harga
})

const updateMenu = ()=>{
    Inertia.put(`/update/menu/${props.menu.id_menu}`, form.value);
}

</script>

<template>
<AdminSidebarLayout>
    <Head title="Buat Menu" />
    <template #header>Menu</template>
    <template #content>
        <Head title="Edit Menu" />
        
        <div class="container mx-auto mt-6 max-w-lg bg-gray-200 px-4 py-2 rounded-md ">
        <h3 class="text-2xl font-bold m-4 text-center">Form Edit Menu</h3>
       
            <form @submit.prevent="updateMenu">
                <div class="mt-4 mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama:</label>
                    <input v-model="form.nama_menu" type="text" required class="form-input w-full border border-black rounded-md mb-4" />
                    <label class="block text-gray-700 font-medium mb-2">Harga:</label>
                    <input v-model="form.harga" type="number" required class="form-input w-full border border-black rounded-md" />
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