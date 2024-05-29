<script setup>
// import { onMounted, ref } from 'vue';
// defineProps(['modelValue']);
// defineEmits(['update:modelValue']);
// const input = ref(null);
// onMounted(() => {
//     if (input.value.hasAttribute('autofocus')) {
//         input.value.focus();
//     }
// });
// defineExpose({ focus: () => input.value.focus() });

</script>

<template>
    <!-- <input
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    /> -->
    <!-- <input
        class="rounded-md border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    /> -->
    <input type="text" 
        class="rounded-md focus:ring focus:ring-indigo-200 focus:ring-opacity-50" :class="isInvalid"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
    />

                
</template>

<script>
export default {
	props:  ['modelValue', 'invalid'], //{
		// modelValue: {
    //   type: String,
    //   required: true,
    // },
		// invalid: {
    //   type: Boolean,
    //   required: false,
    //   default: false,
    // },
	// },
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
