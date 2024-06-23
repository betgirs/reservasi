<script setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AdminSidebarLayout from '@/Layouts/AdminSidebarLayout.vue';
import NavLink from '@/Components/NavLink.vue';
import SelectComp from '@/Components/SelectComp.vue';

const awesome = ref(true)
const selected = ref('');

</script>

<template>
<AdminSidebarLayout>
    <template #header>Dashboard</template>
    <template #content>
        <div>
    <SelectComp
      v-model="selected"
      :options="[
        {value:'pending', label:'pending'},
        {value:'confirmed', label:'confirmed'},
        { value: 'cancelled', label: 'cancelled'}
      ]"
    />
    <p class="mt-4">Selected option: {{ selected }}</p>
  </div>
        <h1>Here might be a page title</h1>
        <h1 v-if="awesome">Vue is awesome!</h1>
        <h1 v-else>Oh no 😢</h1>
        <Button class="fancy-btn" >
             <slot>
               </slot>
        </Button>
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
</AdminSidebarLayout> 


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