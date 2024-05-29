<script setup>
import Filter from "./../../Layouts/Filter.vue";
import InputLabel from "./../InputLabel.vue";
import TextInput from "./../TextInput.vue";
import DropdownList from "./../DropdownList.vue";
</script>

<template>
  <Filter @submitForm="submitForm">
    <div class="flex flex-row mt-2">
      <div class="w-1/4 pr-1">
        <InputLabel for="code" value="Функціональне розташування" />
        <TextInput id="code" class="mt-1 w-full" v-model.trim="code" autofocus />
      </div>
      <div class="w-1/4 pr-1">
        <InputLabel for="name" value="Назва" />
        <TextInput id="name" class="mt-1 w-full" v-model.trim="name" autofocus />
      </div>
      <div class="w-1/4 pl-1 pr-1">
        <InputLabel for="settlement" value="Нас. пункт" />
        <TextInput
          id="settlement"
          class="mt-1 w-full"
          v-model.trim="settlement"
          autofocus
        />
      </div>
      <div class="w-1/4">
        <InputLabel for="street" value="Вулиця" />
        <TextInput id="street" class="mt-1 w-full" v-model.trim="street" autofocus />
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-1/4 pr-1">
        <InputLabel for="status_type" value="Статус" />
        <DropdownList
          id="status_type"
          class="mt-1 w-full"
          :refArr="refStatusType"
          v-model="status_type_id"
        />
      </div>
      <div class="w-1/4 pr-1">
        <InputLabel for="object_type" value="Тип об'єкта" />
        <DropdownList
          id="object_type"
          class="mt-1 w-full"
          :refArr="refObjectType"
          v-model="object_type_id"
        />
      </div>
    </div>
  </Filter>
</template>

<script>
export default {
  emits: ["resetPageId"],
  data() {
    return {
      code: "",
      name: "",
      settlement: "",
      street: "",
      status_type_id: "",
      object_type_id: "",
    };
  },
  methods: {
    submitForm(sap_so_id, sap_rem_id) {
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const dict_title = this.$store.getters["dictModule/currentDictTitle"];

      const filterParams = {
        sap_so_id: sap_so_id,
        sap_rem_id: sap_rem_id,
        code: this.code,
        name: this.name,
        settlement: this.settlement,
        street: this.street,
        status_type_id: this.status_type_id,
        object_type_id: this.object_type_id,
      };
      this.$store.commit("dictModule/setFilterConnectedSubstationParams", filterParams);

      this.$store.dispatch("dictModule/showDict", {
        id: dict_id,
        title: dict_title,
        pageId: 1,
      });

      this.$emit("resetPageId");
    },
  },
  computed: {
    refStatusType() {
      return this.$store.getters["dictModule/refStatusType"];
    },
    refObjectType() {
      return this.$store.getters["dictModule/refObjectType"];
    },
  },
  created() {
    console.log("FilterConnectedSubstation created");
    this.$store.dispatch("dictModule/setRef", { id: "status_types" });
    this.$store.dispatch("dictModule/setRef", { id: "object_types" });
  },
  mounted() {
    console.log(this.$store.getters["dictModule/filterConnectedSubstationParams"]);
    const filterParams = this.$store.getters[
      "dictModule/filterConnectedSubstationParams"
    ];
    this.code = filterParams["code"] ?? "";
    this.name = filterParams["name"] ?? "";
    this.settlement = filterParams["settlement"] ?? "";
    this.street = filterParams["street"] ?? "";
    this.status_type_id = filterParams["status_type_id"] ?? "";
    this.object_type_id = filterParams["object_type_id"] ?? "";
  },
};
</script>
