<template>
   <div>
	  <div aria-live="assertive"
		   class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-50">
		 <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
			<!-- Notification panel, dynamically insert this into the live region when it needs to be displayed -->
			<transition enter-active-class="transform ease-out duration-300 transition"
						enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
						enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
						leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
						leave-to-class="opacity-0">
			   <div v-if="$page.props.flash.success && show"
					class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
				  <div class="p-4">
					 <div class="flex items-start">
						<div class="flex-shrink-0">
						   <CheckCircleIcon class="h-6 w-6 text-green-400" aria-hidden="true" />
						</div>
						<div class="ml-3 w-0 flex-1 pt-0.5">
						   <p class="text-sm font-medium text-gray-900">
							  {{ $page.props.flash.success }}
						   </p>
						   <p class="mt-1 text-sm text-gray-500 hidden">
							  Anyone with a link can now view this file.
						   </p>
						</div>
						<div class="ml-4 flex-shrink-0 flex">
						   <button @click="show = false"
								   class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
							  <span class="sr-only">Close</span>
							  <XIcon class="h-5 w-5" aria-hidden="true" />
						   </button>
						</div>
					 </div>
				  </div>
			   </div>
			</transition>
		 </div>
	  </div>
	  <div v-if="($page.props.flash.error || Object.keys($page.props.errors).length > 0) && show"
		   class="flex items-center justify-between mb-8 max-w-3xl bg-red-500 rounded">
		 <div class="flex items-center">
			<svg class="flex-shrink-0 ml-4 mr-2 w-4 h-4 fill-white" xmlns="http://www.w3.org/2000/svg"
				 viewBox="0 0 20 20">
			   <path
				   d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm1.41-1.41A8 8 0 1 0 15.66 4.34 8 8 0 0 0 4.34 15.66zm9.9-8.49L11.41 10l2.83 2.83-1.41 1.41L10 11.41l-2.83 2.83-1.41-1.41L8.59 10 5.76 7.17l1.41-1.41L10 8.59l2.83-2.83 1.41 1.41z" />
			</svg>
			<div v-if="$page.props.flash.error" class="py-4 text-white text-sm font-medium">{{
				  $page.props.flash.error
																							}}
			</div>
			<div v-else class="py-4 text-white text-sm font-medium">
			   <span v-if="Object.keys($page.props.errors).length === 1">There is one form error.</span>
			   <span v-else>There are {{ Object.keys($page.props.errors).length }} form errors.</span>
			</div>
		 </div>
		 <button type="button" class="group mr-2 p-2" @click="show = false">
			<svg class="block w-2 h-2 fill-red-800 group-hover:fill-white" xmlns="http://www.w3.org/2000/svg"
				 width="235.908" height="235.908" viewBox="278.046 126.846 235.908 235.908">
			   <path
				   d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z" />
			</svg>
		 </button>
	  </div>
   </div>
</template>

<script setup>
import {ref, watch} from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import {CheckCircleIcon} from '@heroicons/vue/outline'
import {XIcon} from '@heroicons/vue/solid'

const show = ref(true);
watch(() => usePage().props.flash, () => {
   show.value = true
}, {deep: true});
</script>