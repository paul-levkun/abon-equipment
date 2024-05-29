<template>
  <span class="flex flex-row items-center cursor-pointer font-medium text-gray-500">
    <input type="checkbox" class="mr-2" :id="fieldId" v-model="model" :value="value"/>  
    <label :for="fieldId">
      {{ label }}
    </label>
  </span>
</template>
<script>
export default {
  props: {
    fieldId: { type: String, required: true, },
    modelValue: { type: [ Array, Boolean ] },     // Мб Array або Boolean
    value: { type: [ Boolean, Object ] },         // Мб Boolean або Object
    label: { type: String }  
  },
  computed: {
    model: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      }
    }
  }
}
</script>