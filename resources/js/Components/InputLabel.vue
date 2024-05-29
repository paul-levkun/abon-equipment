<!-- <script setup>
  defineProps(['value']);
</script> -->

<template>
	<label class="block font-medium text-sm" :class="isInvalid">
		<span v-if="value">{{ value }}</span>
		<span v-else><slot /></span>
	</label>
</template>

<script>
export default {
	props: {// ['value', 'invalid'],
		value: {
      type: String,
      required: false,
    },
		invalid: {
      type: Boolean,
      required: false,
      default: false,
    },
	},
	data() {
    return {
    }
  },
	computed: {
		isInvalid() {
			return this.invalid ? "text-red-600" : "text-gray-700"
		}
	}
}
</script>

<style>
/* .invalid {
  color: red;
} */
</style>
