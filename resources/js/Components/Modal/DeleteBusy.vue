<script setup>
import SecondaryButton from "./../SecondaryButton";
import BaseModal from "./../../Layouts/BaseModal.vue";
</script>

<template>
	<base-modal>
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">Видалення</h2>
		<div class="mt-2 mb-3">
			<p>Є посилання інших довідників на поточний запис</p>
			<p>Видалення неможливе</p>
		</div>
		<SecondaryButton @click="$emit('hideDialog')" class="ml-1">Закрити</SecondaryButton>
	</base-modal>
</template>

<script>
export default {
	emits: ['hideDialog'],
}
</script>

<style scoped>
</style>