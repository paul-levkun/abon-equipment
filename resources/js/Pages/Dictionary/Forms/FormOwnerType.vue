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
              @change="changeVal"
              id="name"
              class="mt-1 w-full"
              v-model.trim="name"
              maxlength="255"
              autofocus
            />
            <List :refArr="nameErrors"></List>
          </div>

          <div class="w-1/2 pl-1">
            <InputLabel
              for="short-name"
              value="Скорочена назва"
              :invalid="isShortNameInvalid"
            />
            <TextInput
              :invalid="isShortNameInvalid"
              @blur="clearValidity('short-name')"
              @change="changeVal"
              id="short-name"
              class="mt-1 w-full"
              v-model.trim="shortName"
              maxlength="10"
              autofocus
            />
            <List :refArr="shortNameErrors"></List>
          </div>
        </div>

        <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
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
      shortName: "",
      row_id: null,
      // isInvalid: true,
    };
  },
  methods: {
    submitForm() {
      console.log(this.name, this.shortName, this.row_id);
      let data = new FormData();
      data.append("id", "owner_types");
      data.append("name", this.name);
      data.append("short-name", this.shortName ? this.shortName : "");
      data.append("row_id", this.row_id);
      data.append("user_id", this.$store.getters["dictModule/userId"]);
      if (this.row_id) data.append("_method", "put");

      this.$store.dispatch("dictModule/storeDict", {
        id: "owner_types",
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
    isShortNameInvalid() {
      return this.$store.getters["dictModule/formErrors"]["short-name"] !== undefined;
    },
    nameErrors() {
      return this.$store.getters["dictModule/formErrors"]["name"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["name"];
    },
    shortNameErrors() {
      // console("222222", this.$store.getters['dictModule/formErrors']['short-name'])
      return this.$store.getters["dictModule/formErrors"]["short-name"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["short-name"];
    },
    addSaved() {
      return this.$store.getters["dictModule/addSaved"];
    },
  },
  watch: {
    addSaved(newVal, oldVal) {
      if (newVal) {
        console.log("add SAVED!");
        this.name = this.shortName = "";
        // this.$store.commit("dictModule/setIsFormModified", 0);
      }
    },
  },
  created() {
    console.log("FormOwnerType created");
  },
  mounted() {
    if (Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0) {
      console.log("Add record");
      this.row_id = null;
    } else {
      console.log("Update record");
      console.log(this.$store.getters["dictModule/formInputs"]);
      this.row_id = this.$store.getters["dictModule/formInputs"].id;
      this.name = this.$store.getters["dictModule/formInputs"].name;
      this.shortName = this.$store.getters["dictModule/formInputs"].short_name;
      // console.log("this.shortName", this.shortName)
    }
  },
};
</script>
<style></style>
