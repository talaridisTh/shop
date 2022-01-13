<template>
   <div class="flex items-center">
	  <div class="ml-4">
		 <div class="text-sm font-medium text-gray-900">{{ base }}</div>
		 <div class="text-sm text-gray-500">{{ second }}</div>
	  </div>
   </div>
</template>

<script setup>
defineProps({
   base: String,
   second: String,
})
</script>

<style scoped>

</style>