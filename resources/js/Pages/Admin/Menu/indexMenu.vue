<script setup>
import {Head,  Link, usePage } from '@inertiajs/vue3'
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import DangerButton from '@/Components/DangerButton.vue';


const {props} = usePage();
const menus = ref(props.menus || []);

const editMenu = (id_menu)=>{
  Inertia.get(`/edit/menu/${id_menu}`)
}
const hapusMenu = (id_menu) => {
  if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
    Inertia.delete(`/menu/${id_menu}`), {
      onSuccess: () => {
        // Handle success action, e.g., show a success message or redirect
      },
      onError: () => {
        // Handle error action, e.g., show an error message
      }
    };
  }
};

</script>

<template>
<AdminSidebarLayout>

    <template #header>Daftar Menu</template>
    <template #content>
      <Head title="Edit Menu" />
      <div class="flex-container">
        <div class="header-section">
          <h1>Show</h1>
          <Link :href="route('formTambahMenu')">
            <btnCom>Tambah</btnCom>
          </Link>
      
        </div>
        <table class="table">
          <thead>
            <tr class="bg-gray-300">
              <th >No</th>
              <th >Nama</th>
              <th >Harga</th>
              <th >Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(menu, index) in menus" :key="menu.id_menu" class="odd:bg-white even:bg-gray-300">
              <td > {{ index+1 }}</td>
              <td> {{ menu.nama_menu}}</td>
              <td> {{ menu.harga }}</td>
              <td> <DangerButton @click="hapusMenu(menu.id_menu)">Delete</DangerButton>
                   <btnCom @click="editMenu(menu.id_menu)" style="background:deepskyblue">Edit</btnCom>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="pagination">
          <Link href="# " class="">Sebelumnya</Link>
         <span class="mx-4">1</span> 
          <Link href="#" class="">Selanjutya</Link>
        </div>
      </div>
    </template>
</AdminSidebarLayout> 


</template>

<style>
.flex-container{
  display: flex;
  flex-direction: column;
  margin: 3rem; 
}
.header-section{
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

th,td{
  border-width: 2px;
  border-color: #000000;
  text-align: center;
  word-wrap: break-word;
  max-width: 150px;

}
.pagination{
  display: flex; 
  justify-content: flex-end;
  margin-top: 12px;
}

</style>