<template>
   <Head title="Edit Role" />

   <FlashMessages />

   <form class="flex flex-col">

	  <div class="flex justify-between items-center">
		 <Title>Edit Role</Title>
		 <!--		 <ResponsiveNavLink as="button" :disabled="form.processing" @click="onSubmit">Save</ResponsiveNavLink>-->
	  </div>

	  <Accordion>
		 <AccordionItem
			 v-for="model in models"
			 :key="model"
			 open="roles"
			 :selected-name="model"
			 :title="model"
		 >

			<div class="flex justify-between">
			   <div v-for="perm in permissionsAction"
					:key="perm"
					class="flex items-center space-x-3">
				  <Label class="text-lg capitalize"
						 :value="perm" />

				  <input type="checkbox"
						 :disabled="role.name ==='admin'"
						 @click="()=>assignPerm(`${perm} ${model}`)"
						 :checked="containPerm(perm,model)"
				  >
			   </div>
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
import {Head} from "@inertiajs/inertia-vue3";
import Title from "@/Shared/Title";
import AccordionItem from "@/Shared/Elements/AccordionItem";
import Accordion from "@/Shared/Elements/Accordion";
import FlashMessages from "@/Shared/Overlays/FlashMessages";
import Label from "@/Shared/Form/Label";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
   "role": Object,
   "models": Array,
   "permissions": Array
})

const permissionsAction = ["create", "read", "update", "delete", "edit"];

const assignPerm = perm => {
   Inertia.put(route('role.perm', props.role), {
	  perm
   })
};

const containPerm = (perm, model) => props.permissions.includes(`${perm} ${model}`) ? 'checked' : false;

</script>


<style scoped>

</style>
