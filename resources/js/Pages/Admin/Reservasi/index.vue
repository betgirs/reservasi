<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SelectComp from '@/Components/SelectComp.vue';
import { Inertia } from '@inertiajs/inertia';
import { router} from '@inertiajs/vue3';


const props = defineProps({
  reservasis : Array,
})

const filter = ref({
    tanggal_reservasi: '',
    waktu_reservasi: ''
});

const useFilter= () =>{
  Inertia.get('/admin/reservasi/filter', filter.value);
}

const updateStatus = (reservasi)=>{
  alert('Status berhasil diubah');
router.post(`/reservasi/${reservasi.id_reservasi}/status`,
  {status: reservasi.status}
  )
};


</script>

<template>
<AdminSidebarLayout>
    <template #header>Daftar Reservasi</template>
    <template #content>
      <Head title="Reservasi" />
     
      <div class="flex-container">
        <div class="header-section flex flex-row-reverse">
          <form @submit.prevent="useFilter" class="mb-2  ">
            <label for="tanggal_reservasi" class="">Tanggal Reservasi:</label>
            <input v-model="filter.tanggal_reservasi" type="date" id="tanggal_reservasi" class="border border-black rounded-md mr-2">
            
            <label for="waktu_reservasi">Waktu Reservasi:</label>
            <input v-model="filter.waktu_reservasi" type="time" id="waktu_reservasi" class="border border-black rounded-md mr-2">
            
            <btnCom type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Filter</btnCom>
        </form>
        </div>
        <table class="table">
          <thead>
            <tr class="bg-gray-300">
              <th >No</th>
              <th >id Reservasi</th>
              <th >Nama Pelanggan</th>
              <th >id Meja</th>
              <th >Tanggal</th>
              <th >Waktu</th>
              <th >status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(reservasi, index) in reservasis" :key="reservasi.id_reservasi" class=" odd:bg-white even:bg-gray-300">
              <td > {{index+1}} </td>
              <td> {{ reservasi.id_reservasi }} </td>
              <td> {{ reservasi.user.name }}</td>
              <td> {{ reservasi.meja.id_meja }}</td>
              <td> {{ reservasi.tanggal_reservasi }}</td>
              <td> {{ reservasi.waktu_reservasi }} </td>
              <td >
                <SelectComp  v-model="reservasi.status" 
                            :options="[
                                {value:'pending', label:'pending'},
                                {value:'confirmed', label:'confirmed'},
                                { value: 'cancelled', label: 'cancelled'},
                                { value: 'finished', label: 'finished'},
                            ]"
                            @change="updateStatus(reservasi)"
                            > 
                </SelectComp>
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