<template>
  <span class="flex flex-row items-center cursor-pointer font-medium text-gray-500">
  <!-- <input type="checkbox" @change="change"  :id="fieldId" :name="fieldId" class="mr-2" :value="fieldValue"/>   -->
  <!-- <input type="checkbox" class="mr-2" :id="fieldId" :value="fieldValue" v-model="fieldModel"/>   -->
  <input @change="change" type="checkbox" class="mr-2" :id="fieldId" :value="fieldValue" :checked="isChecked"/>  
  <label :for="fieldId">
    {{ label }}
  </label>
  </span>
</template>
<script>
export default {
  props: {
    label: String,
    fieldId: {
      type: String,
      required: true,
    },
    fieldValue: {
      type: Number,
      required: true,
    },
    isChecked: {
      type: Boolean,
      required: true,
    },
    // fieldModel: {
    //   type: Array,
    //   required: true,
    // },
  },
  methods: {
  //   change() {
  //     console.log("!!!", this.label, this.fieldId, this.fieldValue, this.fieldModel, this.del)  
  //   }
    change(event) {
      this.$emit('update:checked', event.target.checked);
    },  
  },
  // mounted() {
  //   console.log("```", this.label, this.fieldId, this.fieldValue, this.fieldModel, this.del)
  // }
};
</script>