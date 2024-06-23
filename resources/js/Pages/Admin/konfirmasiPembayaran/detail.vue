<script setup>
import { ref, defineProps, computed } from 'vue';
import btnCom from '@/Components/btnCom.vue';
import { Head, Inertia } from '@inertiajs/inertia';
import tableCom from '@/Components/tableCom.vue';
import { Link } from '@inertiajs/vue3';
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';

const props = defineProps({
    reservasi: Object,
    menus: Array,
    errors: Object,
})

const subtotal = (pesanan) => {
    return pesanan.jumlah_pesanan * pesanan.menu.harga
}

const totalPesanan = computed(() => {
    return props.reservasi.pesanans.reduce((total, pesanan) => total + pesanan.jumlah_pesanan, 0);
});

const totalBayar = computed(() => {
    return props.reservasi.pesanans.reduce((total, biaya) => total + subtotal(biaya), 0)
})


function formatHarga(harga) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(harga);
}

</script>

<template>
    
    <AdminSidebarLayout>
        

        <template #header>Konfirmasi Pembayaran</template>
       
        <template #content>
            <Head title="Detail Pembayaran" />
            <h3 class="text-2xl font-bold m-4 text-center">Detail Reservasi</h3>
            <div class="container mx-auto max-w-sm mt-6 bg-gray-200 px-4 py-2 rounded-md border border-black shadow-md shadow-gray-400">
               
                <div class="grid grid-cols-1">
                    <p class="text-lg font-bold">Reservasi {{ reservasi.id_reservasi }}</p>      
                    <p>Nama : {{ reservasi.user.name }}</p>
                    <p>Email : {{ reservasi.user.email }}</p>
                </div>
                <div v-if="reservasi.pembayaran != null" class="max-w-sm px-2 bg-gray-200 rounded-md border-t border-black mt-2 pb-4">
                    <h4 class="my-2"><strong>Pembayaran:</strong></h4>
                    <p>Tanggal Pembayaran: {{ reservasi.pembayaran.tanggal_pembayaran }}</p>
                    <p>Total Pembayaran: {{ formatHarga(reservasi.pembayaran.total_pembayaran) }}</p>          
                </div>
            </div>

            <div class="container mx-auto max-w-xl mt-6 px-4 py-4">
                <h2 class="text-lg font-bold">Daftar Pesanan:</h2>
                <div class="flex flex-col justify-center">
                    <tableCom>
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
                                <td>{{ index + 1 }}</td>
                                <td>{{ pesanan.menu.nama_menu }}</td>
                                <td>{{ formatHarga(pesanan.menu.harga) }}</td>
                                <td>{{ pesanan.jumlah_pesanan }}</td>
                                <td>{{ formatHarga(subtotal(pesanan)) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Total</strong></td>
                                <td>{{ totalPesanan }}</td>
                                <td>{{ formatHarga(totalBayar) }}</td>
                            </tr>
                        </tfoot>
                    </tableCom>
                    <div class="flex flex-row justify-end mt-6">
                        <Link :href="route('daftarPembayaran')">
                            <btnCom>Kembali</btnCom>
                        </Link>
                    </div>
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
</style>
            
