<template>
   <Head title="Add User" />

   <FlashMessages />

   <form class="flex flex-col">

	  <div class="flex justify-between items-center">
		 <Title>Add User</Title>
		 <ResponsiveNavLink as="button" :disabled="form.processing" @click="onSubmit">Save</ResponsiveNavLink>
	  </div>

	  <Accordion>
		 <AccordionItem open="section-1" selected-name="section-1" title="General">
			<div class="w-1/3 mb-4">
			   <Label required>Name</Label>
			   <Input @clearError="form.clearErrors('name')"
					  :hasError="form.errors.name"
					  v-model="form.name" />
			   <InputError :message="form.errors.name" />
			</div>
			<div class="w-1/3 mb-4">
			   <Label required>Email</Label>
			   <Input @clearError="form.clearErrors('email')"
					  :hasError="form.errors.email"
					  v-model="form.email" />
			   <InputError :message="form.errors.email" />
			</div>
		 </AccordionItem>

		 <AccordionItem selected-name="section-2" title="Password">
			<div class="w-1/3 mb-4">
			   <Label required>Password</Label>
			   <Input @clearError="form.clearErrors('password')"
					  :hasError="form.errors.password"
					  v-model="form.password" />
			   <InputError :message="form.errors.password" />
			</div>

			<div class="w-1/3 mb-4">
			   <Label required>Confirm Password</Label>
			   <Input v-model="form.password_confirmation"></Input>
			</div>
		 </AccordionItem>

		 <AccordionItem selected-name="section-3" title="Status and Role">
			<div class="w-1/3 mb-4">
			   <Label required>Role</Label>
			   <Select @clearError="form.clearErrors('role')"
					   :hasError="form.errors.role"
					   v-model="form.role" :options="['Admin','User']" />
			   <InputError :message="form.errors.role" />
			</div>

			<div class="w-1/3 mb-4">
			   <Label required>Status</Label>
			   <Switch v-model="form.status"
					   :class="[form.status ? 'bg-indigo-600' : 'bg-gray-200', 'mt-2 relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']">
				  <span class="sr-only">Use setting</span>
				  <span aria-hidden="true"
						:class="[form.status ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200']" />
			   </Switch>
			</div>
		 </AccordionItem>
	  </Accordion>

   </form>

</template>

<script>
import Admin from "@/Layouts/Admin"

export default {
   name: "Dashboard",
   layout: Admin
}
</script>

<script setup>
import {Head, useForm} from "@inertiajs/inertia-vue3";
import ResponsiveNavLink from "@/Shared/ResponsiveNavLink";
import Title from "@/Shared/Title";
import AccordionItem from "@/Shared/Elements/AccordionItem";
import Accordion from "@/Shared/Elements/Accordion";
import Input from "@/Shared/Input";
import Label from "@/Shared/Label";
import InputError from "@/Shared/InputError";
import Select from "@/Shared/Form/Select";
import {Switch} from '@headlessui/vue'
import FlashMessages from "@/Shared/Overlays/FlashMessages";


const form = useForm("CreateUser", {
   name: null,
   email: null,
   password: null,
   password_confirmation: null,
   role: null,
   status: false,
})

const onSubmit = () => {
   form.post(route('user.store'), {
	  onSuccess: () => form.reset(),
   })
}

</script>


<style scoped>

</style>
