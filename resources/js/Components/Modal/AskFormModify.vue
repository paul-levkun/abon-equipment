<script setup>
import PrimaryButton from "./../PrimaryButton";
import SecondaryButton from "./../SecondaryButton";
import BaseModal from "./../../Layouts/BaseModal.vue";
</script>

<template>
  <base-modal>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Збереження змін</h2>
    <p class="mt text-gray-600 dark:text-gray-400 text-md">В формі відбулись зміни</p>
    <p class="mb-3 text-gray-600 dark:text-gray-400 text-md">Виконати збереження?</p>
    <PrimaryButton @click="$emit('submitForm')">Зберегти</PrimaryButton>
    <SecondaryButton @click="$emit('hideDialog')" class="ml-1">Ні</SecondaryButton>
  </base-modal>
</template>

<script>
export default {
  emits: ["submitForm", "hideDialog"],
};
</script>

<style scoped></style>
