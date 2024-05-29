<script setup>
import PrimaryButton from "./../PrimaryButton";
import SecondaryButton from "./../SecondaryButton";
import BaseModal from "./../../Layouts/BaseModal.vue";
</script>

<template>
	<base-modal>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">Підтвердження видалення</h2>
		<p class="my-3 text-gray-600 dark:text-gray-400 text-md">Видалити запис?</p>
		<PrimaryButton @click="$emit('deleteRec')">Видалити</PrimaryButton>
		<SecondaryButton @click="$emit('hideDialog')" class="ml-1">Ні</SecondaryButton>
	</base-modal>
</template>

<script>
export default {
	emits: ['deleteRec', 'hideDialog'],
}
</script>

<style scoped>
</style>