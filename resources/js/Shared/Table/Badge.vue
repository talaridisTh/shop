<template>
    <span
		:class="status[active]"
		class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full "><slot /></span>
</template>

<script setup>

defineProps({
   active: String
})

const status = {
   "active": "text-green-800 bg-green-100",
   "inactive": "text-red-800 bg-red-100",
   "trash": "text-yellow-800 bg-yellow-100"
}

</script>

<style scoped>

</style>