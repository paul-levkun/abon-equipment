<script setup>
import DictFormContent from "./../../../Layouts/DictFormContent.vue";
import InputLabel from "./../../../Components/InputLabel.vue";
import TextInput from "./../../../Components/TextInput.vue";
import List from "./../../../Components/List.vue";
</script>

<template>
  <!-- required  -->
  <DictFormContent @submitForm="submitForm">
    <template #default>
      <div>
        <div class="flex flex-row mt-2">
          <!-- <div class="grid grid-cols-2"> -->
          <div class="w-1/2 pr-1">
            <InputLabel for="name" value="Назва" :invalid="isNameInvalid" />
            <TextInput
              :invalid="isNameInvalid"
              @blur="clearValidity('name')"
              id="name"
              class="mt-1 w-full"
              v-model.trim="name"
              maxlength="255"
              @change="changeVal"
              autofocus
            />
            <List :refArr="nameErrors"></List>
          </div>
        </div>
      </div>
    </template>
  </DictFormContent>
</template>

<script>
export default {
  emits: ["clearValidity"],
  data() {
    return {
      name: "",
      row_id: null,
      // isInvalid: true,
    };
  },
  methods: {
    submitForm() {
      console.log("zzzzzzzz", this.name, this.row_id);
      let data = new FormData();
      data.append("id", "contract_inexpediency_types");
      data.append("name", this.name);
      data.append("row_id", this.row_id);
      data.append("user_id", this.$store.getters["dictModule/userId"]);
      if (this.row_id) data.append("_method", "put");

      this.$store.dispatch("dictModule/storeDict", {
        id: "contract_inexpediency_types",
        oper: this.row_id ? "upd" : "add",
        data: data,
      });
    },
    clearValidity(inputId) {
      this.$emit("clearValidity", inputId);
    },
    changeVal() {
      this.$store.commit("dictModule/setIsFormModified", 1);
    },
  },
  computed: {
    isNameInvalid() {
      return this.$store.getters["dictModule/formErrors"]["name"] !== undefined;
    },
    nameErrors() {
      return this.$store.getters["dictModule/formErrors"]["name"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["name"];
    },
    addSaved() {
      return this.$store.getters["dictModule/addSaved"];
    },
  },
  watch: {
    addSaved(newVal, oldVal) {
      if (newVal) {
        console.log("add SAVED!");
        this.name = "";
      }
    },
  },
  created() {
    console.log("FormFailureType created");
  },
  mounted() {
    if (Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0) {
      console.log("Add record");
      this.row_id = null;
    } else {
      console.log("Update record");
      this.row_id = this.$store.getters["dictModule/formInputs"].id;
      this.name = this.$store.getters["dictModule/formInputs"].name;
    }
  },
};
</script>
<style></style>
