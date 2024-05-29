<script setup>
import DictFormContent from "./../../../Layouts/DictFormContent.vue";
import InputLabel from "./../../../Components/InputLabel.vue";
import TextInput from "./../../../Components/TextInput.vue";
import TextArea from "./../../../Components/TextArea.vue";
import DropdownList from "./../../../Components/DropdownList.vue";
import List from "./../../../Components/List.vue";
</script>

<template>
  <DictFormContent @submitForm="submitForm">
    <template #default>
      <div>
        <!-- <div>
          <InputLabel for="rem" value="СО/ЕМ"/>
          <DropdownList :invalid="isRemInvalid" @blur="clearValidity('rem')"
            id="rem" class="mt-1 w-1/2 pr-1" :refArr="refRem" v-model="rem"
          />
          <List :refArr="remErrors"></List>
        </div> -->

        <div class="flex flex-row mt-2">
          <!-- <div class="grid grid-cols-2"> -->
          <div class="w-1/4 pr-1">
            <InputLabel for="sap_code" value="Дебітор" />
            <TextInput
              readonly
              id="sap_code"
              class="mt-1 w-full"
              v-model.trim="sap_code"
              @change="changeVal"
              autofocus
            />
          </div>
          <div class="w-1/4 pr-1">
            <InputLabel for="code" value="ЄДРПОУ / ІПН" />
            <TextInput
              :invalid="isCodeInvalid"
              @blur="clearValidity('code')"
              id="code"
              class="mt-1 w-full"
              v-model.trim="code"
              maxlength="16"
              @change="changeVal"
              autofocus
            />
            <List :refArr="codeErrors"></List>
          </div>
          <!-- required -->
          <div class="w-1/2 pl-1">
            <InputLabel for="type" value="Тип" />
            <DropdownList
              :invalid="isTypeInvalid"
              @blur="clearValidity('type')"
              @change="changeVal"
              id="type"
              class="mt-1 w-full"
              :refArr="refOwnerType"
              v-model="type"
            />
            <List :refArr="typeErrors"></List>
          </div>
        </div>

        <InputLabel for="name" value="Назва" class="mt-2" />
        <TextArea
          :invalid="isNameInvalid"
          @blur="clearValidity('name')"
          @change="changeVal"
          id="name"
          name="name"
          rows="2"
          class="block mt-1 w-full"
          v-model.trim="name"
          autofocus
        ></TextArea>
        <List :refArr="nameErrors"></List>

        <InputLabel for="properties" value="Реквізити" class="mt-2" />
        <TextArea
          :invalid="isPropertiesInvalid"
          @blur="clearValidity('properties')"
          @change="changeVal"
          id="properties"
          name="properties"
          rows="2"
          class="block mt-1 w-full"
          v-model.trim="properties"
          autofocus
        ></TextArea>
        <List :refArr="propertiesErrors"></List>

        <InputLabel for="comment" value="Примітки" class="mt-2" />
        <TextArea
          id="comment"
          name="comment"
          rows="2"
          class="block mt-1 w-full"
          v-model.trim="comment"
          @change="changeVal"
          autofocus
        ></TextArea>

        <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
      </div>
    </template>
  </DictFormContent>
</template>

<script>
export default {
  emits: ["clearValidity"], // emits і не обовєязкове, працює і без нього )
  data() {
    return {
      // rem: "",
      type: "",
      sap_code: "",
      code: "",
      name: "",
      properties: "",
      comment: "",
      rowId: null,
    };
  },
  methods: {
    submitForm() {
      let data = new FormData();
      data.append("id", "owners");
      // data.append('rem', this.rem)
      data.append("type", this.type);
      data.append("code", this.code ? this.code : "");
      data.append("name", this.name ? this.name : "");
      data.append("properties", this.properties ? this.properties : "");
      data.append("comment", this.comment ? this.comment : "");
      data.append("row_id", this.rowId);
      data.append("user_id", this.$store.getters["dictModule/userId"]);
      if (this.rowId) data.append("_method", "put");

      this.$store.dispatch("dictModule/storeDict", {
        id: "owners",
        oper: this.rowId ? "upd" : "add",
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
    // refRem() {
    //   return this.$store.getters['dictModule/refRem']
    // },
    refOwnerType() {
      return this.$store.getters["dictModule/refOwnerType"];
    },
    isNameInvalid() {
      return this.$store.getters["dictModule/formErrors"]["name"] !== undefined;
    },
    nameErrors() {
      return this.$store.getters["dictModule/formErrors"]["name"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["name"];
    },
    isCodeInvalid() {
      return this.$store.getters["dictModule/formErrors"]["code"] !== undefined;
    },
    codeErrors() {
      return this.$store.getters["dictModule/formErrors"]["code"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["code"];
    },
    // isRemInvalid() {
    //   return this.$store.getters['dictModule/formErrors']['rem'] !== undefined
    // },
    // remErrors() {
    //   return this.$store.getters['dictModule/formErrors']['rem'] === undefined ?
    //     [] : this.$store.getters['dictModule/formErrors']['rem']
    // },
    isTypeInvalid() {
      return this.$store.getters["dictModule/formErrors"]["type"] !== undefined;
    },
    typeErrors() {
      return this.$store.getters["dictModule/formErrors"]["type"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["type"];
    },
    isPropertiesInvalid() {
      return this.$store.getters["dictModule/formErrors"]["properties"] !== undefined;
    },
    propertiesErrors() {
      return this.$store.getters["dictModule/formErrors"]["properties"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["properties"];
    },
    addSaved() {
      return this.$store.getters["dictModule/addSaved"];
    },
  },
  watch: {
    addSaved(newVal, oldVal) {
      if (newVal) {
        console.log("add SAVED!");
        this.type = this.sap_code = this.code = this.name = this.properties = this.comment =
          "";
      }
    },
  },
  created() {
    console.log("FormOwner created");
    // this.$store.dispatch('dictModule/setRef', { id: "rems", })
    this.$store.dispatch("dictModule/setRef", { id: "owner_types" });
  },
  mounted() {
    if (Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0) {
      console.log("1111111111111");
      this.rowId = null;
    } else {
      console.log("2222222222222");
      console.log(
        "ab_inn:",
        typeof this.$store.getters["dictModule/formInputs"].ab_inn,
        `${this.$store.getters["dictModule/formInputs"].ab_inn}`
      );
      this.rowId = this.$store.getters["dictModule/formInputs"].id;
      this.sap_code = this.$store.getters["dictModule/formInputs"].sap_code
        ? String(this.$store.getters["dictModule/formInputs"].sap_code)
        : "";
      // this.code = this.$store.getters['dictModule/formInputs'].ab_inn ? String(this.$store.getters['dictModule/formInputs'].ab_inn) : ""
      this.code = this.$store.getters["dictModule/formInputs"].ab_inn ?? "";
      this.name = this.$store.getters["dictModule/formInputs"].name;
      this.properties = this.$store.getters["dictModule/formInputs"].recvisit ?? "";
      this.comment = this.$store.getters["dictModule/formInputs"].comments ?? "";
      // this.rem = this.$store.getters['dictModule/formInputs'].id_res ?? ""
      this.type = this.$store.getters["dictModule/formInputs"].id_type_owner ?? "";
    }
  },
};
</script>

<style></style>
