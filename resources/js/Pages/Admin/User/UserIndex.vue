<template>

   <Head title="User" />

   <FlashMessages />

   <div class="flex flex-col">

	  <div class="flex justify-between items-center">
		 <Title>User</Title>
		 <ResponsiveNavLink class="flex space-x-3"
							:href="route('user.create')">
			<DocumentAddIcon class="w-4" />
			<span>Add User</span>
		 </ResponsiveNavLink>
	  </div>
	  <!--Filter-->
	  <div class="flex py-5 justify-between items-center space-x-10">
		 <!--Search-->
		 <div class="flex-1">

			<Label>Search</Label>

			<div class="mt-1 relative flex items-center">

			   <Input v-model="form.search"
					  placeholder="Search.."
					  :icon="true">
				  <SearchIcon class="w-5" />
			   </Input>

			</div>

		 </div>

		 <div class="flex flex-2 space-x-5">
			<!--Limit-->
			<div class="flex flex-col flex-1">
			   <Label class="flex space-x-3">
				  <FilterIcon class="w-4 text-indigo-600" />
				  <span>Items Per Page</span>
			   </Label>
			   <Select v-model="form.limit"
					   :options="limitFilter" />
			</div>
			<!--Status-->
			<div class="flex flex-col flex-1">
			   <Label>Status</Label>
			   <Select v-model="form.status"
					   :options="limitStatus" />
			</div>
		 </div>
	  </div>

	  <!--Preview Filter-->
	  <div class="py-4 flex space-x-2">

		 <Filter :form="form.order"
				 :filter-name-second="form.sort"
				 filter-name="sort"
				 @removeFilter="removeFilter" />

		 <Filter :form="form.limit"
				 filter-name="limit"
				 @removeFilter="removeFilter" />

		 <Filter :form="form.status"
				 filter-name="status"
				 @removeFilter="removeFilter" />

	  </div>
	  <!--Table user-->
	  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
		 <div class="py-2 align-middle inline-block  sm:px-6 lg:px-8 w-full">
			<div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg w-full">
			   <table class="divide-y divide-gray-200 w-full">
				  <thead class="bg-gray-50">
				  <tr>
					 <Th @click="onSort('name')">Name</Th>
					 <Th @click="onSort('email')">Email</Th>
					 <Th>Status</Th>
					 <Th>Role</Th>
					 <Th></Th>
				  </tr>
				  </thead>
				  <tbody class="bg-white divide-y divide-gray-200">
				  <tr v-for="user in users.data"
					  :key="user.email">
					 <Td>
						<DoubleLine :base="user.name"
									second="onomateponimo" />
					 </Td>
					 <Td>
						{{ user.email }}
					 </Td>
					 <Td>
						<Badge :active="user.status">
						   {{ user.status }}
						</Badge>
					 </Td>
					 <Td>{{ user.role }}</Td>
					 <Td v-if="user.status === 'trash'">
						<button @click="selectedModelToAction(user,'restore')">
						   <ReplyIcon class="w-5" />
						</button>
					 </Td>
					 <Td v-else
						 class="flex space-x-4">
						<Link :href="user.links.profile"
							  class="">
						   <PencilIcon class="w-5" />
						</Link>
						<button @click="selectedModelToAction(user,'delete')">
						   <XIcon class="w-5" />
						</button>
					 </Td>
				  </tr>
				  </tbody>
			   </table>

			   <Pagination :links="users.links" />

			</div>
		 </div>
	  </div>

   </div>

   <DeleteModal @onClose="onClose"
				:model="selectedModel"
				modelName="user"
				:open="confirm.delete" />
   <RestoreModal @onClose="onClose"
				 :model="selectedModel"
				 modelName="user"
				 :open="confirm.restore" />

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
import Badge from "@/Shared/Table/Badge";
import DoubleLine from "@/Shared/Table/DoubleLine";
import Pagination from "@/Shared/Table/Pagination";
import {SearchIcon} from '@heroicons/vue/solid'
import {watch, reactive, ref} from "vue";
import {pickBy, throttle} from "lodash";
import {Inertia} from "@inertiajs/inertia";
import Input from "@/Shared/Form/Input";
import Filter from "@/Shared/Table/Filter";
import Select from "@/Shared/Form/Select";
import ResponsiveNavLink from "@/Shared/ResponsiveNavLink";
import DeleteModal from "@/Shared/Overlays/DeleteModal";
import Button from "@/Shared/Button";
import FlashMessages from "@/Shared/Overlays/FlashMessages";
import RestoreModal from "@/Shared/Overlays/RestoreModal";
import {DocumentAddIcon} from "@heroicons/vue/outline"
import {FilterIcon, ReplyIcon, XIcon, PencilIcon} from "@heroicons/vue/outline"
import useDelete from "@/Composables/useDelete";

const {onClose, confirm, selectedModel, selectedModelToAction} = useDelete()


const props = defineProps({
   users: Object,
   filters: Object
})

const limitFilter = [10, 20, 50, 100];

const limitStatus = ["Active", "Inactive", "Trash"];


const form = reactive({
   search: props.filters.search,
   limit: props.filters.limit ?? 10,
   status: props.filters.status,
   sort: props.filters.sort,
   order: props.filters.order,
})

watch(() => form, () => {
   throttle(() => {
	  Inertia.get(route('user.index'), pickBy(form), {preserveState: true});
   }, 500)();
}, {deep: true})


const onSort = (name) => {
   form.sort = name;
   form.order = form.order === "asc" ? 'desc' : 'asc';
}

const removeFilter = (filter) => {
   if (filter === "sort") {
	  form.order = null
   }
   form[filter] = null
}

</script>

<style scoped>

</style>