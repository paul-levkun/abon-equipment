<script setup>
import DictLayout from './../Layouts/DictLayout.vue';
</script>

<!-- <template>
    <section>
      <h2>Page not found!</h2>
      <p>This page could not be found - maybe check out all our 
        <button type="button" @click="showStartPage" class="underline text-gray-900 dark:text-white">Start</button> page
      </p>
    </section>
</template> -->

<template>
<DictLayout>
  <template #header>
    <h2 class="font-semibold text-xl text-red-700 leading-tight ">Сторінку не знайдено</h2>
  </template>
  <template #table>
    <!-- <p>This page could not be found - maybe check out all our 
      <button type="button" @click="showStartPage" class="underline text-gray-900 dark:text-white">Start</button> page
    </p> -->
    <div class="py-12">
      <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200 text-lg text-red-700">
            Введену сторінку не знайдено
          </div>
        </div>
        <div class="ml-6 mt-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
          <a href="/" class="underline text-gray-900 dark:text-white">
            На головну
          </a>
        </div>
      </div>
    </div>
  </template>
</DictLayout>
</template>

<script>
  export default {
    name: "NotFound.vue",
    methods: {
      showStartPage() {
        window.location.replace("/");
      }
    }
  }
</script>
  
<style scoped>
</style>