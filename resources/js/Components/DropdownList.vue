<script setup>
</script>

<template>
	<select v-model="modelValue" @change="$emit('update:modelValue', $event.target.value)"
			class="rounded-md focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :class="isInvalid">
		<option v-for="(item, index) in refArr" :disabled="optDis(item.id, index)" :value="item.id">{{ item.name }}</option>
	</select>
</template>

<script>
export default {
	props: ["refArr", "modelValue", "invalid"],
	// props: {
	// 	modelValue: {
  //     type: Number,
  //     required: true,
  //   },
	// 	refArr: {
  //     type: Array,
  //     required: true,
  //   },
	// 	invalid: {
  //     type: Boolean,
  //     required: false,
  //     default: false,
  //   },
	// },

 	emits: ['update:modelValue'],
	data() {
		return {
		}
	},

	methods: {
		optDis(value, index) {
			// return index === 0
      // console.log("option value:", value)
      return value === ""
		},
	},

	computed: {
		isInvalid() {
			return this.invalid ? "border-red-300 focus:border-red-500" : "border-gray-300 focus:border-indigo-300"
		},
  },

}
</script>

<style scoped>
select {
  /* -webkit-appearance: none;
     -moz-appearance: none;
          appearance: none;
  background-color: #fff;
  border-color: #6b7280;
  border-width: 1px;
  border-radius: 0px; */
  padding-top: 0.5rem;
  padding-right: 0.75rem;
  padding-bottom: 0.5rem;
  padding-left: 0.75rem;
  /* font-size: 1rem; */
  line-height: 1.5rem;
  /* --tw-shadow: 0 0 #0000; */
}
</style>