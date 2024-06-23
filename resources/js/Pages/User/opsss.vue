<script setup>
import btnCom from '@/Components/btnCom.vue';
import { Head, Link, usePage, useForm} from '@inertiajs/vue3'
import { ref, defineProps} from 'vue'
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


function buatReservasi(){
Inertia.get(`/login`);
}

</script>

<template>
 <Head title="Daftar Reservasi" />
  <AuthenticatedLayout>
   
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reservasi</h2>
    </template>

    <template #main>
      <div class="container max-w-xl  mx-auto bg-gray-200 rounded-md border border-black shadow-md shadow-gray-400 my-32 pb-4">
              
                  <h2 class="text-center py-4 ">Opsss, kamu belum punya reservasi😥, yuk buat reservasi sekarangg :)</h2>
                <div class="flex gap-4 justify-center">
                    <Link :href="(route('dashboard'))">
                        <btnCom >Kembali</btnCom>
                    </Link>
                    <btnCom @click="buatReservasi()">Buat Reservasi</btnCom>
                </div>
             
      </div>
    

  </template>
  </AuthenticatedLayout>
</template>

<style>
 
</style>