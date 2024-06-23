<template>
    <div class="container mx-auto mt-6 max-w-lg bg-gray-200 px-4 py-2 rounded-md ">
        <h3 class="text-2xl font-bold m-4 text-center"><slot name="h1"></slot></h3>
       
            <form @submit.prevent="">
            <div class="mt-4 mb-4">
                <label class="block text-gray-700 font-medium mb-2">Kapasitas:</label>
                <input v-model="kapasitas" type="number" class="form-input w-full border border-black rounded-md" />
            </div>

            <div class=" flex justify-end my-4" >
                <btnCom type="button"  @click="batal">Batal</btnCom>
                <btnCom type="submit">Simpan</btnCom>
            </div>
            </form>
       
    </div>
  
</template>

<script setup>
import btnCom from '@/Components/btnCom.vue';
</script>