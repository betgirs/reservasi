<script setup>
import { ref, defineProps, computed} from 'vue';
import btnCom from '@/Components/btnCom.vue';
import { Inertia } from '@inertiajs/inertia';
import tableCom from '@/Components/tableCom.vue';
import {Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    reservasi: Object,
    menus:Array,
})

const buatPesanan = (status, id_reservasi)=>{
    if(status === 'pending'){
        alert('Opps, reservasi belum dikonfirmasi. Tunggu sebentar yaaaa!');
    }else if(status === 'cancelled'){
        alert('Maaf reservasimu dibatalkan, coba buat reservasi lain yawww!');
    }else if(status === 'finished'){
        alert('reservasi selesai');
    }
    else{
        Inertia.get(`/orders/create/${id_reservasi}`);
    }
}

const subtotal = (pesanan)=>{
    return pesanan.jumlah_pesanan * pesanan.menu.harga
}

const totalPesanan = computed (() =>{
return props.reservasi.pesanans.reduce((total, pesanan) => total + pesanan.jumlah_pesanan,0 );
});

const totalBayar = computed(()=>{
    return props.reservasi.pesanans.reduce((total, biaya)=> total + subtotal(biaya),0)
})

const formatHarga = (harga)=> {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(harga);
}


const bayar = (id_reservasi)=>{
    Inertia.get(`/pembayaran/${id_reservasi}`);
}

</script>

<template>
<Head title="Detail Reservasi" />
    <AuthenticatedLayout>

    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reservasi</h2>
        </template>
        <template #main>
        <h3 class="text-2xl font-bold m-4 text-center">Detail Reservasi</h3>
        <div class=" container mx-auto max-w-sm mt-6  bg-gray-200 px-4 py-2 rounded-md border border-black shadow-md shadow-gray-400 ">
                
                <div class="item flex flex-row justify-between py-2">
                    <div>
                        <p class="text-lg font-bold">Reservasi {{ reservasi.id_reservasi }}</p>
                    </div>
                    <div>
                        <p>Status : 
                        <strong v-if="reservasi.status === 'confirmed'" class="text-emerald-400">{{ reservasi.status }}</strong> 
                        <strong v-else-if="reservasi.status === 'pending'" class="text-yellow-500">{{ reservasi.status }}</strong>
                        <strong v-else-if="reservasi.status === 'cancelled'" class="text-red">{{ reservasi.status }}</strong>
                        <strong v-else-if="reservasi.status === 'finished'" class="text-cyan-600">{{ reservasi.status }}</strong>
                        </p>
                    </div>   
                </div>
                
                <div class="grid grid-cols-2 ">
                        <p>Nama</p><p class="">: {{ reservasi.user.name }}</p>
                        <p >Email</p><p>: {{ reservasi.user.email }}</p>
                        <p >Tanggal Reservasi</p><p>: {{ reservasi.tanggal_reservasi }}</p>
                        <p >Waktu Reservasi</p><p>: {{ reservasi.waktu_reservasi }}</p>
                        <p >Meja</p><p>: {{ reservasi.meja.id_meja }} ({{ reservasi.meja.jumlah_orang }} orang) </p>
                </div>
                <div v-if="reservasi.pembayaran != null" class="max-w-sm px-2 bg-gray-200 rounded-md border-t border-black mt-2 pb-4  ">
                    <h4 class="my-2"><strong>Pembayaran:</strong></h4>
                    <p>Tanggal Pembayaran: {{ reservasi.pembayaran.tanggal_pembayaran }}</p>
                    <p>Total Pembayaran: {{formatHarga(reservasi.pembayaran.total_pembayaran)  }}</p>
                    <p>Status : 
                        <strong v-if="reservasi.pembayaran.status === 'confirmed'" class="text-emerald-400">{{ reservasi.pembayaran.status }}</strong> 
                        <strong v-else-if="reservasi.pembayaran.status === 'pending'" class="text-yellow-500">{{ reservasi.pembayaran.status }}</strong>
                        <strong v-else-if="reservasi.pembayaran.status === 'cancelled'" class="text-red">{{ reservasi.pembayaran.status }}</strong>
                        <strong v-else-if="reservasi.pembayaran.status === 'finished'" class="text-cyan-600">{{ reservasi.pembayaran.status }}</strong>
                    </p>
                  
                </div>
        </div>
        

        <div class=" container mx-auto max-w-xl mt-6 px-4 py-4">
            <h2 class="text-lg font-bold">Daftar Pesanan: </h2>
            <div v-if="reservasi.pesanans.length === 0" class="flex flex-wrap justify-center bg-gray-200 rounded-md border border-black shadow-md shadow-gray-400 mt-4 pb-4">
                <h2 class=" py-4 ">Opsss, kamu belum punya pesanan😥, yuk pesan sekarangg :)</h2>
                <div class="flex gap-4">
                    <Link :href="(route('daftarReservasi'))">
                        <btnCom >Kembali</btnCom>
                    </Link>
                    <btnCom @click="buatPesanan(reservasi.status, reservasi.id_reservasi)">Buat pesanan</btnCom>
                </div>
                
             </div>
           
            <div v-else class="flex flex-col justify-center">
                <tableCom >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Jumlah Pesanan</th>
                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(pesanan, index) in reservasi.pesanans" :key="pesanan.id_pesanan" class="odd:bg-white even:bg-gray-300 border-b border-gray-400">
                            <td>{{ index+1 }}</td>
                            <td>{{ pesanan.menu.nama_menu }}</td>
                            <td>{{ formatHarga(pesanan.menu.harga)}}</td>
                            <td>{{ pesanan.jumlah_pesanan }}</td>
                            <td>{{ formatHarga(subtotal(pesanan)) }}</td>
                        </tr>
                    </tbody>
                    <tfoot >
                        <tr>
                            <td colspan="3" ><strong>Total</strong></td>
                            <td>{{ totalPesanan }}</td>
                            <td>{{ formatHarga(totalBayar) }}</td>
                        </tr>
                    </tfoot>
                </tableCom>
                <div class="flex flex-row justify-end mt-6"> 
                    <Link :href="(route('daftarReservasi'))">
                        <btnCom >Kembali</btnCom>
                    </Link>
                     <btnCom v-if="reservasi.pembayaran === null" @click="bayar(reservasi.id_reservasi)" >Lanjut Pembayaran</btnCom>
                   
                </div> 
             </div> 

        </div>
    </template>
        
</AuthenticatedLayout>
</template>

<style>

</style>