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
        <InputLabel for="object_code" value="Функціональне розташування" />
        <TextInput
          id="object_code"
          class="mt-1 w-full"
          v-model.trim="object_code"
          autofocus
        />
      </div>
      <div class="w-1/4 pr-1">
        <InputLabel for="object_name" value="Назва абон. обладнання" />
        <TextInput
          id="object_name"
          class="mt-1 w-full"
          v-model.trim="object_name"
          autofocus
        />
      </div>
      <div class="w-1/4 pl-1 pr-1">
        <InputLabel for="s" value="Тип об'єкта" />
        <DropdownList
          id="object_types"
          class="mt-1 w-full"
          :refArr="refObjectType"
          v-model="object_type_id"
        />
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-1/2 pr-1">
        <InputLabel
          for="contract_inexpediency_types"
          value="Недоцільність закл. договору"
        />
        <DropdownList
          id="contract_inexpediency_types"
          class="mt-1 w-full"
          :refArr="refContractInexpediencyType"
          v-model="contract_inexpediency_type_id"
        />
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-1/4 pr-1">
        <InputLabel for="owner_code" value="Дебітор" />
        <TextInput
          id="owner_code"
          class="mt-1 w-full"
          v-model.trim="owner_code"
          autofocus
        />
      </div>
      <div class="w-1/4 pr-1">
        <InputLabel for="owner_inn" value="ЄДРПОУ / ІПН власника" />
        <TextInput
          id="owner_inn"
          class="mt-1 w-full"
          v-model.trim="owner_inn"
          autofocus
        />
      </div>
      <div class="w-1/2 pl-1">
        <InputLabel for="owner_name" value="Назва / Ім'я власника" />
        <TextInput
          id="owner_name"
          class="mt-1 w-full"
          v-model.trim="owner_name"
          autofocus
        />
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-1/4 pr-1">
        <InputLabel for="contract_status_types" value="Статус договору" />
        <DropdownList
          id="contract_status_types"
          class="mt-1 w-full"
          :refArr="refContractStatusType"
          v-model="contract_status_type_id"
        />
      </div>
      <div class="w-1/4 pl-1">
        <InputLabel for="contract_code" value="№ SAP договору" />
        <TextInput
          id="contract_code"
          class="mt-1 w-full"
          v-model.trim="contract_code"
          autofocus
        />
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-1/2 pr-1">
        <InputLabel for="contract_failure_types" value="Відмова" />
        <DropdownList
          id="contract_failure_types"
          class="mt-1 w-full"
          :refArr="refContractFailureType"
          v-model="contract_failure_type_id"
        />
      </div>
      <div class="w-1/2 pl-1">
        <InputLabel for="contract_types" value="Тип договору" />
        <DropdownList
          id="contract_types"
          class="mt-1 w-full"
          :refArr="refContractType"
          v-model="contract_type_id"
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
      object_code: "",
      object_name: "",
      object_type_id: "",
      contract_inexpediency_type_id: "",
      owner_code: "",
      owner_inn: "",
      owner_name: "",
      contract_status_type_id: "",
      contract_failure_type_id: "",
      contract_type_id: "",
      contract_code: "",
    };
  },
  methods: {
    submitForm(sap_so_id, sap_rem_id) {
      console.log(sap_so_id, sap_rem_id);
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const dict_title = this.$store.getters["dictModule/currentDictTitle"];

      const filterParams = {
        sap_so_id: sap_so_id,
        sap_rem_id: sap_rem_id,
        object_code: this.object_code,
        object_name: this.object_name,
        object_type_id: this.object_type_id,
        contract_inexpediency_type_id: this.contract_inexpediency_type_id,
        owner_code: this.owner_code,
        owner_inn: this.owner_inn,
        owner_name: this.owner_name,
        contract_status_type_id: this.contract_status_type_id,
        contract_failure_type_id: this.contract_failure_type_id,
        contract_type_id: this.contract_type_id,
        contract_code: this.contract_code,
        contract_inexpediency_type: this.$store.getters[
          "dictModule/refContractInexpediencyType"
        ].find((item) => item.id === +this.contract_inexpediency_type_id)["name"],
        contract_status_type: this.$store.getters[
          "dictModule/refContractStatusType"
        ].find((item) => item.id === +this.contract_status_type_id)["name"],
      };
      console.log("НЕВИЗНАЧЕНО", filterParams);
      this.$store.commit("dictModule/setFilterRegisterParams", filterParams);

      this.$store.dispatch("dictModule/showDict", {
        id: dict_id,
        title: dict_title,
        pageId: 1,
      });

      this.$emit("resetPageId");
    },
  },
  computed: {
    refObjectType() {
      return this.$store.getters["dictModule/refObjectType"];
    },
    refContractInexpediencyType() {
      return this.$store.getters["dictModule/refContractInexpediencyType"];
    },
    refContractStatusType() {
      return this.$store.getters["dictModule/refContractStatusType"];
    },
    refContractFailureType() {
      return this.$store.getters["dictModule/refContractFailureType"];
    },
    refContractType() {
      return this.$store.getters["dictModule/refContractType"];
    },
  },
  created() {
    console.log("FilterRegister created");
    this.$store.dispatch("dictModule/setRef", { id: "object_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_inexpediency_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_status_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_failure_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_types" });
  },
  mounted() {
    const filterParams = this.$store.getters["dictModule/filterRegisterParams"];
    this.object_code = filterParams["object_code"] ?? "";
    this.object_name = filterParams["object_name"] ?? "";
    this.object_type_id = filterParams["object_type_id"] ?? "";
    this.contract_inexpediency_type_id =
      filterParams["contract_inexpediency_type_id"] ?? "";
    this.owner_code = filterParams["owner_code"] ?? "";
    this.owner_inn = filterParams["owner_inn"] ?? "";
    this.owner_name = filterParams["owner_name"] ?? "";
    this.contract_status_type_id = filterParams["contract_status_type_id"] ?? "";
    this.contract_failure_type_id = filterParams["contract_failure_type_id"] ?? "";
    this.contract_type_id = filterParams["contract_type_id"] ?? "";
    this.contract_code = filterParams["contract_code"] ?? "";
  },
};
</script>
