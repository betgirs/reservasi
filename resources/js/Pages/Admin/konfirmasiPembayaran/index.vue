<script setup>
import {Head, Link } from '@inertiajs/vue3'
import { ref, defineProps  } from 'vue'
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import btnCom from '@/Components/btnCom.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SelectComp from '@/Components/SelectComp.vue';
import tableCom from '@/Components/tableCom.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  pembayaran : Array,
})

const updateStatus = (pembayaran)=>{
  alert('Status berhasil diubah');
  Inertia.post(`/pembayaran/${pembayaran.id_pembayaran}/status`,
  {status: pembayaran.status}
  )
};

const detail = (id_reservasi) =>{
Inertia.get(`/pembayaran/detail/${id_reservasi}`);
};

const formatHarga = (harga)=> {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(harga);
}

</script>

<template>
<AdminSidebarLayout>
 

    <template #header>Konfirmasi Pembayaran</template>
    <template #content>
      <Head title=" Konfirmasi Pembayaran" />
      <div class="flex-container">
        <div class="header-section">
          <h1>Show</h1>
        </div>
        <table >
          <thead>
            <tr>
              <th>No</th>
              <th >id Reservasi</th>
              <th >Tanggal</th>
              <th >Total</th>
              <th >Bukti</th>
              <th >Status</th>
              <th >Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(pembayaran, index) in pembayaran" :key="pembayaran.id_pembayaran" class="odd:bg-white even:bg-gray-300">
              <td > {{ index+1 }} </td>
              <td> {{ pembayaran.reservasi.id_reservasi }} </td>
              <td> {{ pembayaran.tanggal_pembayaran }}</td>
              <td>{{ formatHarga(pembayaran.total_pembayaran) }} </td>
              <td>
              <a :href="pembayaran.bukti_pembayaran" target="_blank" class="hover:text-blue-700">
               {{ pembayaran.bukti_pembayaran }}
              </a>
            </td>
              <td>
                <SelectComp v-model="pembayaran.status"
                            :options="[{value:'pending', label:'pending'},
                                {value:'confirmed', label:'confirmed'},
                                { value: 'cancelled', label: 'cancelled'}
                            ]"
                             @change="updateStatus(pembayaran)"
                >

                </SelectComp>
                <p>    <strong v-if="pembayaran.status === 'confirmed'" class="text-emerald-400">{{ pembayaran.status }}</strong> 
                        <strong v-else-if="pembayaran.status === 'pending'" class="text-yellow-500">{{pembayaran.status }}</strong>
                        <strong v-else-if="pembayaran.status === 'cancelled'" class="text-red">{{ pembayaran.status }}</strong>
                        <strong v-else-if="pembayaran.status === 'finished'" class="text-cyan-600">{{pembayaran.status }}</strong>
                    </p>
              </td>
              <td> 
                    <btnCom @click="detail(pembayaran.id_reservasi)" >Detail</btnCom>
                    
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