<template>
    <div class="mb-2 mt-2 flex justify-center">
      <select
        id="select"
        v-model="selectedOption"
        class=" block border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md"
      >
        <option v-for="option in options" :key="option.value" :value="option.value">
          {{ option.label }}
        </option>
      </select>
    </div>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    options: {
      type: Array,
      required: true
    },
    modelValue: {
      type: String,
      default: ''
    }
  });
  
  const emits = defineEmits(['update:modelValue']);
  
  const selectedOption = ref(props.modelValue);
  
  watch(selectedOption, (newValue) => {
    emits('update:modelValue', newValue);
  });
  </script>
  
  <style scoped>

  </style>
  