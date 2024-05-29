<template>
	<textarea
		class="rounded-md focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :class="isInvalid"
			:value="modelValue"
			@input="$emit('update:modelValue', $event.target.value)"
	></textarea>
    
</template>

<script>
export default {
  props: {// ['modelValue'],
		modelValue: {
      type: String,
      required: true,
    },
		invalid: {
      type: Boolean,
      required: false,
      default: false,
    },
	},
  emits: ['update:modelValue'],
	data() {
    return {
    }
  },
  computed: {
		isInvalid() {
			return this.invalid ? "border-red-300 focus:border-red-500" : "border-gray-300 focus:border-indigo-300"
		}
	}

}
</script>

<style scoped>
textarea {
  padding-top: 0.5rem;
  padding-right: 0.75rem;
  padding-bottom: 0.5rem;
  padding-left: 0.75rem;
  line-height: 1.5rem;
}
</style>