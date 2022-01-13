<template>
   <div v-if="$page.url.includes(filterName)">
	  {{ filterNameSecond ?? filterName }} :
	  <div class="px-3 py-1.5 rounded-md mb-2 bg-gray-200">{{ form }}
		 <span class="cursor-pointer" @click="$emit('removeFilter',filterName)">x</span>
	  </div>
   </div>
</template>

<script setup>
const props = defineProps({
   filterName: String,
   form: String,
   filterNameSecond: {
	  type: String,
	  default: null
   }
})
const emit = defineEmits(["removeFilter"])
</script>

<style scoped>

</style>