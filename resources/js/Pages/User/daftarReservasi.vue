<script setup>
import btnCom from '@/Components/btnCom.vue';
import { Head, Link, usePage, useForm} from '@inertiajs/vue3'
import { ref, defineProps} from 'vue'
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


const props = defineProps({
    reservasis: Array,
    
})

const detail = (id_reservasi) =>{
Inertia.get(`/reservasi/${id_reservasi}`);
};

function buatReservasi(){
Inertia.get(`/create/reservasi`);
}

</script>

<template>
 <Head title="Daftar Reservasi" />
  <AuthenticatedLayout>
   
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reservasi</h2>
    </template>

    <template #main>
      <div v-if="reservasis.length === 0" class="container max-w-xl  mx-auto bg-gray-200 rounded-md border border-black shadow-md shadow-gray-400 my-32 pb-4">
              
                  <h2 class="text-center py-4 ">Opsss, kamu belum punya reservasi😥, yuk buat reservasi sekarangg :)</h2>
                <div class="flex gap-4 justify-center">
                    <Link :href="(route('dashboard'))">
                        <btnCom >Kembali</btnCom>
                    </Link>
                    <btnCom @click="buatReservasi()">Buat Reservasi</btnCom>
                </div>
             
      </div>
    
      <div v-else class="container mx-auto mt-12 max-w-lg bg-gray-200 px-4 py-4 rounded-md border border-black my-4">
        <h3 class="text-2xl font-bold text-center">Daftar Reservasi</h3>
        <ul>
            <li v-for="reservasi in reservasis" :key="reservasi.id_reservasi">
                <div class="item grid grid-cols-2 gap-x-20 py-2">
                    <div>
                        <span class="text-lg font-bold">{{ reservasi.id_reservasi }}</span>
                        <p class="meta">{{ reservasi.tanggal_reservasi }} | {{ reservasi.waktu_reservasi }}</p>
                    </div>
                    <div>
                      <p class="mb-2">Status : 
                        <strong v-if="reservasi.status === 'confirmed'" class="text-emerald-400">{{ reservasi.status }}</strong> 
                        <strong v-else-if="reservasi.status === 'pending'" class="text-yellow-500">{{ reservasi.status }}</strong>
                        <strong v-else-if="reservasi.status === 'cancelled'" class="text-red">{{ reservasi.status }}</strong>
                        <strong v-else-if="reservasi.status === 'finished'" class="text-cyan-600">{{ reservasi.status }}</strong>
                        </p>
                        <Link @click="detail(reservasi.id_reservasi)" class=" meta no-underline hover:underline">Lihat Pesanan</Link>
                    </div>
                   
                </div>
            </li>  
        </ul>
    </div>

  </template>
  </AuthenticatedLayout>
</template>

<style>
  ul {
    list-style-type: none;
    padding-top: 12px;
  }

  li {
    padding: 5px 20px;
    margin: 10px;
    background: #ffffff;
  }

.meta {
  font-size: 1rem;
  color: #548adc;
  margin-top: 8px;
}
</style>