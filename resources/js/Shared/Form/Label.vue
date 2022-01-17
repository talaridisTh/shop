<template>
   <label class="block font-medium  text-gray-700">
	  <span v-if="value">{{ value }}</span>
	  <span ref="content" v-else><slot /></span>
   </label>
</template>

<script setup>
import {onMounted, ref} from "vue";

const props = defineProps({
   value: String,
   required: {
	  type: Boolean,
	  default: false
   }
})

const content = ref(null)

onMounted(() => {
   if (props.required) {
	  content.value.innerHTML += "<span  class='text-red-600'> * </span>";
   }
})
</script>
