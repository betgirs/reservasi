<script setup>
import btnCom from '@/Components/btnCom.vue';
import tableCom from '@/Components/tableCom.vue';
import { computed, defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    reservasi:Object,
    menus: Array,
    pesanans: Array,

})

const form = ref({
    'id_menu' : '',
    'id_reservasi' : props.reservasi.id_reservasi,
    'jumlah_pesanan' : '',
})

const buatPesanan = ()=>{
    Inertia.post('/orders', form.value)
}

const subTotal = (pesanan)=>{
    return pesanan.jumlah_pesanan * pesanan.menu.harga
}

const totalPesanan = computed(() =>{
    return props.pesanans.reduce((total, pesanan) => total + pesanan.jumlah_pesanan, 0);
});

const totalBayar = computed(()=>{
    return props.pesanans.reduce((total, pesanan) => total + subTotal(pesanan),0)
});


const formatHarga = (harga)=> {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(harga);
}

const kembali = (id_reservasi) => {
Inertia.delete(`/orders/delete/${id_reservasi}`)
};

const pesan =(id_reservasi) =>{
    if (props.pesanans.length === 0){
        alert('Opps, kamu belum memesan apa-apa nihh. Ayooo pesan sekarang!!!');
    }else{
        Inertia.get(`/pembayaran/${id_reservasi}`)
    }
   
}

const deletePesanan =(pesanan)=>{
    if(confirm('Yakin mau hapus pesanan ini?')){
        Inertia.delete(`/orders/${pesanan.id_pesanan}`)
    };
}




</script>

<template>
      <Head title="Buat Pesanan" />
    <AuthenticatedLayout>
      

    <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pesanan</h2>
        </template>
        <template #main>
        <div class=" container mx-auto max-w-xl mt-6  bg-gray-200 px-4 py-2 rounded-md border border-black shadow-md shadow-gray-400 ">
            <h3 class="text-xl font-bold m-4 text-center">Buat Pesanan</h3>
             <form @submit.prevent="buatPesanan" class=" flex flex-col ">
                <label>Menu</label>
                <select v-model="form.id_menu" required class="w-full border border-black rounded-md mb-4" >
                    <option v-for="menu in menus" :key="menu.id_menu" :value="menu.id_menu">
                       {{ menu.nama_menu }} - {{ formatHarga(menu.harga) }}
                    </option>
                </select>
                <label>Jumlah</label>
                <input v-model="form.jumlah_pesanan" type="number" required min="1" class="w-full border border-black rounded-md mb-4"></input>
                <btnCom type="submit">Tambah</btnCom>
             </form>
        </div>   

        <div class="container mx-auto max-w-xl flex flex-col mt-12">
            <h2 class="text-lg font-bold">Daftar Pesanan: </h2>
           <tableCom >
                <thead>
                    <tr >
                    <th >No</th>
                    <th >Nama Menu</th>
                    <th >Harga</th>
                    <th>Jumlah Pesanan</th>
                    <th >Sub Total</th>
                    <th >Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(pesanan, index) in pesanans" :key="pesanan.id_pesanan" class="odd:bg-white even:bg-gray-300 border-b border-gray-400">
                    <td>{{ index+1 }} </td>
                    <td> {{pesanan.menu.nama_menu}} </td>
                    <td> {{ formatHarga(pesanan.menu.harga)}}</td>
                    <td> {{ pesanan.jumlah_pesanan}}</td>
                    <td> {{ formatHarga(subTotal(pesanan))}}</td>
                    <td> 
                        <Button @click="deletePesanan(pesanan)" > 
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ef4444" class="size-6">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                            </svg>
                        </Button>
                    </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="font-bold">Total </td>
                        <td>{{ totalPesanan }}</td>
                        <td>{{formatHarga(totalBayar)}}</td>
                        <td></td>
                    </tr>
                </tfoot>
        </tableCom>  
        <div class="flex flex-row-reverse mt-4">
            <btnCom @click="pesan(reservasi.id_reservasi)">Pesan</btnCom>
            <btnCom type="reset" @click="kembali(reservasi.id_reservasi)">kembali</btnCom>
            
        </div>
    
    </div>
    </template>
</AuthenticatedLayout>
</template>

<style>

</style>