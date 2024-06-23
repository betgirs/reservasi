<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import NavLink from '@/Components/NavLink.vue';

const awesome = ref(true)
</script>

<template>
  <div>
    <h1 class="text-4xl font-bold">ssss</h1>
    <h1 class="text-4xl font-bold">Here might be a page title</h1>
    <h1 v-if="awesome" class="text-4xl font-bold">Vue is awesome!</h1>
    <h1 v-else class="text-4xl font-bold">Oh no 😢</h1>
    <Button class="fancy-btn">
      <slot></slot>
    </Button>
  </div>
        <h1>Hello, {{ title }}</h1>
            <div>
            <Link>Log in</Link>
            <Link href="/">Home</Link> 
            </div>

        <div>
            <Link>Log in</Link>
            <Link href="/">Home</Link>        
        </div>
        <button  @click="awesome = !awesome">Toggle</button>


        <Link href="/Admin/Meja/create" :class="{'active':$page.url === '/coba'}">yujhuu</Link>
        <Link href="/endpoint" :headers="{ foo: bar }">Save</Link>
            




</template>

<style>
.fancy-btn {
  color: #fff;
  background: linear-gradient(315deg, #42d392 25%, #647eff);
  border: none;
  padding: 5px 10px;
  margin: 5px;
  border-radius: 8px;
  cursor: pointer;
}
.active{
    color: red;
}
</style>