<script setup>
import Filter from "./../../Layouts/Filter.vue";
import InputLabel from "./../InputLabel.vue";
import TextInput from "./../TextInput.vue";
</script>

<template>
  <Filter @submitForm="submitForm">
    <div class="flex flex-row mt-2">
      <div class="w-1/4 pr-1">
        <InputLabel for="sap_code" value="Дебітор" />
        <TextInput id="sap_code" class="mt-1 w-full" v-model.trim="sap_code" autofocus />
      </div>
      <div class="w-1/4 pr-1">
        <InputLabel for="ab_inn" value="ЄДРПОУ / ІПН" />
        <TextInput id="ab_inn" class="mt-1 w-full" v-model.trim="ab_inn" autofocus />
      </div>
      <div class="w-1/2 pl-1">
        <InputLabel for="name" value="Назва / Ім'я" />
        <TextInput id="name" class="mt-1 w-full" v-model.trim="name" autofocus />
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-full">
        <InputLabel for="recvisit" value="Реквізити" />
        <TextInput id="recvisit" class="mt-1 w-full" v-model.trim="recvisit" autofocus />
      </div>
    </div>
  </Filter>
</template>

<script>
export default {
  emits: ["resetPageId"],
  data() {
    return {
      sap_code: "",
      ab_inn: "",
      name: "",
      recvisit: "",
    };
  },
  methods: {
    submitForm(sap_so_id, sap_rem_id) {
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const dict_title = this.$store.getters["dictModule/currentDictTitle"];

      const filterParams = {
        sap_so_id: sap_so_id,
        sap_rem_id: sap_rem_id,
        sap_code: this.sap_code,
        ab_inn: this.ab_inn,
        name: this.name,
        recvisit: this.recvisit,
      };
      this.$store.commit("dictModule/setFilterOwnerParams", filterParams);

      this.$store.dispatch("dictModule/showDict", {
        id: dict_id,
        title: dict_title,
        pageId: 1,
      });

      this.$emit("resetPageId");
    },
  },
  computed: {},
  created() {
    console.log("FilterOwner created");
  },
  mounted() {
    const filterParams = this.$store.getters["dictModule/filterOwnerParams"];
    this.sap_code = filterParams["sap_code"] ?? "";
    this.ab_inn = filterParams["ab_inn"] ?? "";
    this.name = filterParams["name"] ?? "";
    this.recvisit = filterParams["recvisit"] ?? "";
  },
};
</script>
