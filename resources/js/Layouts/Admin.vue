<template>


   <div class="min-h-screen flex">
	  <TransitionRoot as="template" :show="mobileMenuOpen">
		 <Dialog as="div" class="fixed inset-0 flex z-40 lg:hidden" @close="mobileMenuOpen = false">
			<TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
							 enter-to="opacity-100" leave="transition-opacity ease-linear duration-300"
							 leave-from="opacity-100" leave-to="opacity-0">
			   <DialogOverlay class="fixed inset-0 bg-blue-gray-600 bg-opacity-75" />
			</TransitionChild>
			<TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
							 enter-from="-translate-x-full" enter-to="translate-x-0"
							 leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
							 leave-to="-translate-x-full">
			   <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white focus:outline-none">
				  <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0"
								   enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100"
								   leave-to="opacity-0">
					 <div class="absolute top-0 right-0 -mr-12 pt-4">
						<button type="button"
								class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
								@click="mobileMenuOpen = false">
						   <span class="sr-only">Close sidebar</span>
						   <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
						</button>
					 </div>
				  </TransitionChild>
				  <div class="pt-5 pb-4">
					 <div class="flex-shrink-0 flex items-center px-4">
						<img class="h-8 w-auto"
							 src="https://tailwindui.com/img/logos/workflow-mark.svg?color=blue&shade=600"
							 alt="Workflow" />
					 </div>
					 <nav aria-label="Sidebar" class="mt-5">
						<div class="px-2 space-y-1">
						   <a v-for="item in navigation" :key="item.name" :href="item.href"
							  class="group p-2 rounded-md flex items-center text-base font-medium text-blue-gray-600 hover:bg-blue-gray-50 hover:text-blue-gray-900">
							  <component :is="item.icon"
										 class="mr-4 h-6 w-6 text-blue-gray-400 group-hover:text-blue-gray-500"
										 aria-hidden="true" />
							  {{ item.name }}
						   </a>
						</div>
					 </nav>
				  </div>
				  <div class="flex-shrink-0 flex border-t border-blue-gray-200 p-4">
					 <a href="#" class="flex-shrink-0 group block">
						<div class="flex items-center">
						   <div>
							  <img class="inline-block h-10 w-10 rounded-full"
								   src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2.5&w=256&h=256&q=80"
								   alt="" />
						   </div>
						   <div class="ml-3">
							  <p class="text-base font-medium text-blue-gray-700 group-hover:text-blue-gray-900">
								 Lisa Marie
							  </p>
							  <p class="text-sm font-medium text-blue-gray-500 group-hover:text-blue-gray-700">
								 Account Settings
							  </p>
						   </div>
						</div>
					 </a>
				  </div>
			   </div>
			</TransitionChild>
			<div class="flex-shrink-0 w-14" aria-hidden="true">
			   <!-- Force sidebar to shrink to fit close icon -->
			</div>
		 </Dialog>
	  </TransitionRoot>

	  <!-- Static sidebar for desktop -->
	  <div class="hidden lg:flex lg:flex-shrink-0">
		 <div class="flex flex-col w-20">
			<div class="flex-1 flex flex-col min-h-0 overflow-y-auto bg-blue-600">
			   <div class="flex-1">
				  <div class="bg-blue-700 py-4 flex items-center justify-center">
					 <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=white"
						  alt="Workflow" />
				  </div>
				  <nav aria-label="Sidebar" class="py-6 flex flex-col items-center space-y-3">
					 <Link @click="onSelectedSubMenu(item.submenu)" v-for="item in navigation"
						   :key="item.name" :href="item.href"
						   :class="{'bg-blue-700':usePage().url.value.split('#').pop()===item.href.replace('#','')}"
						   class="flex items-center p-4 rounded-lg text-blue-200 hover:bg-blue-700">
						<component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
						<span class="sr-only">{{ item.name }}</span>
					 </Link>
				  </nav>
			   </div>
			   <div class="flex-shrink-0 flex pb-5">
				  <a href="#" class="flex-shrink-0 w-full">
					 <img class="block mx-auto h-10 w-10 rounded-full"
						  src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2.5&w=256&h=256&q=80"
						  alt="" />
					 <div class="sr-only">
						<p>
						   Lisa Marie
						</p>
						<p>
						   Account settings
						</p>
					 </div>
				  </a>
			   </div>
			</div>
		 </div>
	  </div>

	  <div class="flex-1 min-w-0 flex flex-col overflow-hidden">
		 <!-- Mobile top navigation -->
		 <div class="lg:hidden">
			<div class="bg-blue-600 py-2 px-4 flex items-center justify-between sm:px-6">
			   <div>
				  <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark.svg?color=white"
					   alt="Workflow" />
			   </div>
			   <div>
				  <button type="button"
						  class="-mr-3 h-12 w-12 inline-flex items-center justify-center bg-blue-600 rounded-md text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
						  @click="mobileMenuOpen = true">
					 <span class="sr-only">Open sidebar</span>
					 <MenuIcon class="h-6 w-6" aria-hidden="true" />
				  </button>
			   </div>
			</div>
		 </div>

		 <main class="flex-1 flex overflow-hidden">
			<div class="flex-1 flex flex-col overflow-y-auto xl:overflow-hidden">
			   <!-- Breadcrumb -->
			   <nav aria-label="Breadcrumb" class="bg-white border-b border-blue-gray-200 xl:hidden">
				  <div class="max-w-3xl mx-auto py-3 px-4 flex items-start sm:px-6 lg:px-8">
					 <a href="#"
						class="-ml-1 inline-flex items-center space-x-3 text-sm font-medium text-blue-gray-900">
						<ChevronLeftIcon class="h-5 w-5 text-blue-gray-400" aria-hidden="true" />
						<span>Settings</span>
					 </a>
				  </div>
			   </nav>

			   <div class="flex-1 flex xl:overflow-hidden">
				  <!-- Secondary sidebar -->
				  <nav aria-label="Sections"
					   class="hidden flex-shrink-0 w-96 bg-white border-r border-blue-gray-200 xl:flex xl:flex-col">
					 <div class="flex-shrink-0 h-16 px-6 border-b border-blue-gray-200 flex items-center">
						<p class="text-lg font-medium text-blue-gray-900">Settings</p>
					 </div>
					 <div class="flex-1 min-h-0 overflow-y-auto">
						<Link v-for="item in subMenu" :key="item.name" :href="item.href"
							  :class="[item.current ? 'bg-blue-50 bg-opacity-50' : 'hover:bg-blue-50 hover:bg-opacity-50', 'flex p-6 border-b border-blue-gray-200']"
							  :aria-current="item.current ? 'page' : undefined">
						   <component :is="item.icon" class="flex-shrink-0 -mt-0.5 h-6 w-6 text-blue-gray-400"
									  aria-hidden="true" />
						   <div class="ml-3 text-sm">
							  <p class="font-medium text-blue-gray-900">{{ item.name }}</p>
							  <p class="mt-1 text-blue-gray-500">{{ item.description }}</p>
						   </div>
						</Link>
					 </div>
				  </nav>

				  <!-- Main content -->
				  <div class="px-5 py-10 flex-1">
					 <slot />
				  </div>

			   </div>
			</div>
		 </main>
	  </div>
   </div>
</template>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {ref} from 'vue'
import {Dialog, DialogOverlay, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {
   BellIcon,
   BookmarkAltIcon,
   CashIcon,
   CogIcon,
   FireIcon,
   HomeIcon,
   InboxIcon,
   KeyIcon,
   MenuIcon,
   PhotographIcon,
   SearchCircleIcon,
   UserIcon,
   ViewGridAddIcon,
   XIcon,
} from '@heroicons/vue/outline'
import {ChevronLeftIcon} from '@heroicons/vue/solid'
import {usePage} from "@inertiajs/inertia-vue3";

const setting = [
   {
	  name: 'User',
	  href: route('user.index'),
	  icon: UserIcon,
	  current: true,
   },
]


const navigation = [
   {name: 'Profile', href: '#profile', icon: CogIcon, submenu: setting},

]


const mobileMenuOpen = ref(false)

const subMenu = ref(setting)

const onSelectedSubMenu = (submenu) => subMenu.value = submenu
</script>