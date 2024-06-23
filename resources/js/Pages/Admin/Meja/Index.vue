<script setup>
import { Head, Link, usePage} from '@inertiajs/vue3'
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import DangerButton from '@/Components/DangerButton.vue';

// const props = defineProps({
//   meja: Object
// });
const { props } = usePage();
const mejas = ref(props.mejas || []);
const flash = ref(props.flash || {});

const jumlah_orang = ref ('');

const editMeja=(id_meja) =>{
  Inertia.get(`/edit/meja/${id_meja}`);
}
const deleteMeja = (id_meja) => {
  if (confirm('Apakah Anda yakin ingin menghapus meja ini?')) {
    Inertia.delete(`/meja/${id_meja}`);
  }
};

</script>

<template>
<AdminSidebarLayout>
 
    <template #header>Daftar Meja</template>
    <template #content>
      <Head title="Meja" />
      <div class="flex-container">
        <div v-if="$page.props.message" class="text-blue-500">
      {{ $page.props.message }}
    </div>
    <div v-if="$page.props.errors" class="text-red-500">
      <ul>
        <li v-for="error in $page.props.errors" :key="error">{{ error }}</li>
      </ul>
    </div>
        <div class="header-section">
          <h1>Show</h1>
          <Link :href="route('formTambahMeja')">
            <btnCom>Tambah</btnCom>
          </Link>
        </div>
        <table class="table">
          <thead>
            <tr class="bg-gray-300">
              <th >No</th>
              <th >id Meja</th>
              <th >Kapasitas</th>
              <th >Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(meja, index) in mejas" :key="meja.id_meja" class="odd:bg-white even:bg-gray-300">
              <td>{{ index+1 }} </td>
              <td> {{ meja.id_meja }} </td>
              <td> {{ meja.jumlah_orang }}</td>
              <td> <DangerButton @click="deleteMeja(meja.id_meja)">Delete</DangerButton>
                    <btnCom @click="editMeja(meja.id_meja)" style="background:deepskyblue">Edit</btnCom>
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