<template>
     <table class="container mx-auto max-w-xl mt-6 px-4 py-2 shadow-md shadow-gray-400">
                <slot/>
    </table>  
</template>
<script setup>
</script>
<style>
table {
  border-collapse: collapse;
}
thead{
    border-bottom-width: 1px;
    border: color rgb(128, 128, 128) -300px;
    background: rgb(205, 205, 205) -300px;
}
tfoot{
  background: rgb(205, 205, 205) -300px;
}

th, td {
  border: 1px solid black; 
  text-align: center;
}
</style>