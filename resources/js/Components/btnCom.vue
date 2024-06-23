<script setup>
</script>
<template>
    <button class="btn focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-100">
      <slot>Tambah</slot>
    </button>
</template>

<style>
.btn {
  color: #fff;
  background: #464646;
  border: none;
  padding: 5px 10px;
  margin: 5px;
  border-radius: 0.375rem;
  cursor: pointer;
  
}
</style>