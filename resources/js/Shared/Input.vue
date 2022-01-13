<template>
   <input
	   :type="type"
	   :class="hasError?'border-red-500':'border-gray-300'"
	   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-12 sm:text-sm  rounded-md"
	   :value="modelValue" @input="$emit('update:modelValue', $event.target.value , $emit('clearError'))" ref="input"
	   :placeholder="placeholder" />

   <div v-if="icon" class="absolute inset-y-0 right-0 flex py-1.5 pr-1.5">
	  <kbd
		  class="inline-flex items-center border border-gray-200 rounded px-2 text-sm font-sans font-medium text-gray-400">
		 <slot />
	  </kbd>
   </div>
</template>

<script>
export default {
   props: {
	  modelValue: String,
	  type: {
		 type: String,
		 default: "text"
	  },
	  icon: {
		 type: String,
		 default: false
	  },
	  placeholder: String,
	  hasError: String
   },

   emits: ['update:modelValue',"clearError"],

   methods: {
	  focus() {
		 this.$refs.input.focus()
	  }
   }
}
</script>
