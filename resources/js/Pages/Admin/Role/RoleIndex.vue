<template>

   <Head title="Role" />

   <FlashMessages />

   <div class="flex flex-col">

	  <div class="flex justify-between items-center">
		 <Title>Role</Title>
	  </div>
	  <!--Filter-->
	  <div class="flex py-5  items-center space-x-10">
		 <!--Search-->
		 <div class="w-48">

			<Label>Search</Label>

			<div class="mt-1 relative flex items-center">

			   <Input v-model="form.search"
					  placeholder="Search.."
					  :icon="true">
				  <SearchIcon class="w-5" />
			   </Input>

			</div>

		 </div>

		 <div class="flex w-48 space-x-5">
			<!--Limit-->
			<div class="flex flex-col flex-1">
			   <Label class="flex space-x-3">
				  <FilterIcon class="w-4 text-indigo-600" />
				  <span>Items Per Page</span>
			   </Label>
			   <Select v-model="form.limit" :options="limitFilter" />
			</div>
		 </div>
	  </div>

	  <!--Preview Filter-->
	  <div class="py-4 flex space-x-2">

		 <Filter :form="form.order" :filter-name-second="form.sort" filter-name="sort" @removeFilter="removeFilter" />

		 <Filter :form="form.limit" filter-name="limit" @removeFilter="removeFilter" />

	  </div>
	  <!--Table role-->
	  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
		 <div class="py-2 align-middle inline-block  sm:px-6 lg:px-8 w-full">
			<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg w-full">
			   <table class="divide-y divide-gray-200 w-full">
				  <thead class="bg-gray-50">
				  <tr>
					 <Th @click="onSort('name')">Name</Th>
					 <Th></Th>
				  </tr>
				  </thead>
				  <tbody class="bg-white divide-y divide-gray-200">
				  <tr v-for="role in roles.data" :key="role.id">
					 <Td>
						{{ role.name }}
					 </Td>
					 <Td class="flex space-x-4">
						<Link :href="route('role.edit',role.name)" class="">
						   <PencilIcon class="w-5" />
						</Link>
						<button @click="selectedModelToAction(role,'delete')">
						   <XIcon class="w-5" />
						</button>
					 </Td>
				  </tr>
				  </tbody>
			   </table>

			   <Pagination :links="roles.links" />

			</div>
		 </div>
	  </div>

   </div>

   <DeleteModal @onClose="onClose" :model="selectedModel" modelName="user" :open="confirm.delete" />

</template>


<script>
import Admin from "@/Layouts/Admin"

export default {
   name: "Dashboard",
   layout: Admin
}
</script>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";
import {Head} from "@inertiajs/inertia-vue3";
import Title from "@/Shared/Title";
import Th from "@/Shared/Table/Th";
import Td from "@/Shared/Table/Td";
import Pagination from "@/Shared/Table/Pagination";
import {SearchIcon} from '@heroicons/vue/solid'
import {reactive} from "vue";
import Input from "@/Shared/Form/Input";
import Filter from "@/Shared/Table/Filter";
import Select from "@/Shared/Form/Select";
import DeleteModal from "@/Shared/Overlays/DeleteModal";
import Button from "@/Shared/Button";
import FlashMessages from "@/Shared/Overlays/FlashMessages";
import {FilterIcon, XIcon, PencilIcon} from "@heroicons/vue/outline"
import useDelete from "@/Composables/useDelete";
import useFilter from "@/Composables/useFilter";

const {onClose, confirm, selectedModel, selectedModelToAction} = useDelete()


const props = defineProps({
   roles: Object,
   filters: Object
})


const form = reactive({
   search: props.filters.search,
   sort: props.filters.sort,
   order: props.filters.order,
})


const {onSort, removeFilter, limitFilter} = useFilter(form, "role");


</script>

<style scoped>

</style>