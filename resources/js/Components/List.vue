<script setup>
</script>

<template>
	<ul class="list-disc text-sm ml-6 mt-1 text-red-500">
		<li v-for="val in refArr">{{ val }}</li>
	</ul>
</template>

<script>
export default {
	props: ["refArr"],
	data() {
		return {
		}
	},
	computed: {
    // selected() {
    //   return this.refArr[0]
    // },
  },

	methods: {
	}
}
</script>

<style scoped>
</style>