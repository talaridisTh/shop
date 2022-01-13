<template>
   <li class="relative border-b border-gray-200">

	  <button type="button" class="w-full px-2 py-6 text-left bg-gray-50 rounded"
			  @click="selected !== selectedName ? selected = selectedName : selected = null">
				  <span class="flex items-center justify-between">
					<span class="font-semibold text-xl">{{ title }}</span>
					<ChevronDownIcon :class="{'rotate-90':!selected}" class="transform  w-6 duration-500" />
				  </span>
	  </button>

	  <div class="relative overflow-hidden transition-all duration-700" style="" :ref="slug"
		   :style="selected === selectedName ? 'max-height: ' + ($refs[slug]?.scrollHeight+30) + 'px' : 'max-height:0px' ">
		 <div class=" p-6">
			<slot />
		 </div>
	  </div>

   </li>
</template>

<script setup>
import {ChevronDownIcon} from '@heroicons/vue/solid'

import {computed, ref} from "vue";

const props = defineProps({
   title: String,
   selectedName: String,
   open: {
	  type: String,
	  default: null
   }

})

const selected = ref(props.open);

const slug = computed(() =>
	props.title.toLowerCase()
		.replace(/ /g, '-')
		.replace(/[^\w-]+/g, ''))

</script>

<style scoped>

</style>