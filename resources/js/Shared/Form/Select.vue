<template>
   <select :value="modelValue" @change="$emit('update:modelValue', $event.target.value,$emit('clearError'))"
		   :class="hasError?'border-red-500':'border-gray-300'"
		   class="mt-1 block w-full pl-3 pr-10 py-2 text-base  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
	  <option v-for="option in options" :key="option">{{ option }}</option>
   </select>
</template>

<script setup>
const props = defineProps({
   modelValue: String,
   options: Array,
   hasError: String
})

const emit = defineEmits(["update:modelValue", "clearError"])
</script>

<style scoped>

</style>