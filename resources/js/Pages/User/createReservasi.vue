<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import { ref, defineProps} from 'vue'
import btnCom from '@/Components/btnCom.vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
// const { props } = usePage();
// const mejas = ref(props.mejas || []);


const props = defineProps({
    mejas:Array
})

const form = ref({
    tanggal_reservasi:'',
    waktu_reservasi:'',
    id_meja:''
});


function buatReservasi() {
    Inertia.post('/create/reservasi', form.value)
    
}

</script>

<template>
       <Head title="Buat Reservasi" />

  <AuthenticatedLayout>
 
    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reservasi</h2>
        </template>
    <template #main>
        <div class="container mx-auto mt-6 max-w-lg bg-gray-200 px-4 py-1 rounded-md ">
            <h3 class="text-2xl font-bold m-4 text-center">Form Buat Reservasi</h3>
        
                <form @submit.prevent="buatReservasi">
                    <div class="mt-4 mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Tanggal:</label>
                        <input v-model="form.tanggal_reservasi" type="date" required class="form-input w-full border border-black rounded-md mb-4" />
                        <label class="block text-gray-700 font-medium mb-2">Waktu:</label>
                        <input v-model="form.waktu_reservasi" type="time" required class="form-input w-full border border-black rounded-md mb-4" />
                        <label class="block text-gray-700 font-medium mb-2">Meja/Kapasitas</label>
                        <select v-model="form.id_meja" required class="form-input w-full border border-black rounded-md mb-2" >
                            <option v-for="meja in mejas" :key="meja.id_meja" :value="meja.id_meja">
                                Meja{{ meja.id_meja }} - {{ meja.jumlah_orang }} orang
                            </option>
                        </select>
                    </div>

                <div class=" flex justify-end my-2" >
                    <Link :href="route('dashboard')">
                        <btnCom type="button" >Batal</btnCom>
                    </Link>
                    <btnCom type="submit">Simpan</btnCom>
                </div>
                </form>
        
         </div>
        </template>
    </AuthenticatedLayout>

</template>

<style>


</style>