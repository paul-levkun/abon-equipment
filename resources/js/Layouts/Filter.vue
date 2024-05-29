<script setup>
import InputLabel from "./../Components/InputLabel.vue";
import DropdownList from "./../Components/DropdownList.vue";
import PrimaryButton from "./../Components/PrimaryButton";
import SecondaryButton from "./../Components/SecondaryButton";
import BaseModal from "./BaseModal.vue";
</script>

<!-- required -->
<template>
  <base-modal>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Фільтр</h2>
    <form @submit.prevent="submit">
      <div v-if="showSoRem" class="flex flex-row mt-3">
        <div class="w-1/2 pr-1">
          <InputLabel for="sap_so" value="Структурна одиниця" />
          <DropdownList
            id="sap_so"
            class="mt-1 w-full"
            :refArr="refSapSo"
            v-model="sap_so_id"
            @change="soChange"
          />
        </div>
        <div class="w-1/2 pl-1">
          <InputLabel for="sap_rem" value="Дільниця" />
          <DropdownList
            id="sap_rem"
            class="mt-1 w-full"
            :refArr="refSapRem"
            v-model="sap_rem_id"
          />
        </div>
      </div>

      <slot></slot>

      <div class="mt-4">
        <PrimaryButton>Застосувати</PrimaryButton>
        <SecondaryButton @click="hideDialog()" class="ml-1">Закрити</SecondaryButton>
      </div>
    </form>
  </base-modal>
</template>

<script>
export default {
  emits: ["submitForm"],
  inject: ["hideDialog"],
  data() {
    return {
      sap_so_id: "",
      sap_rem_id: "",
      showSoRem: true,
      bMounted: true,
    };
  },
  methods: {
    submit() {
      this.$emit("submitForm", this.sap_so_id, this.sap_rem_id);
      this.hideDialog();
    },
    soChange() {
      this.sap_rem_id = "";
    },
    getFilterParams() {
      let filterParams;
      switch (this.$store.getters["dictModule/currentDictId"]) {
        case "substations":
          filterParams = this.$store.getters["dictModule/filterSubstationParams"];
          break;
        case "lines":
          filterParams = this.$store.getters["dictModule/filterLineParams"];
          break;
        case "owners":
          filterParams = this.$store.getters["dictModule/filterOwnerParams"];
          this.showSoRem = false;
          break;
        case "registers":
          filterParams = this.$store.getters["dictModule/filterRegisterParams"];
          break;
        case "contracts":
          filterParams = this.$store.getters["dictModule/filterContractParams"];
          this.showSoRem = false;
          break;
        case "connected_substations":
          filterParams = this.$store.getters[
            "dictModule/filterConnectedSubstationParams"
          ];
          break;
        case "connected_lines":
          filterParams = this.$store.getters["dictModule/filterConnectedLineParams"];
          break;
      }
      return filterParams;
    },
  },
  computed: {
    // refSapSo() {
    //   return this.$store.getters['dictModule/refSapSo']
    // },
    refSapSo() {
      const soIdAuth = Number(this.$store.getters["dictModule/soIdAuth"]);
      const remIdAuth = Number(this.$store.getters["dictModule/remIdAuth"]);
      const filterParams = this.getFilterParams();

      this.sap_so_id = soIdAuth === 0 ? filterParams["sap_so_id"] ?? "" : soIdAuth;
      return this.$store.getters["dictModule/refSapSo"].filter(
        (item) => (soIdAuth === 0 ? true : item.id === soIdAuth) // || (remIdAuth === 0 && item.id === 0)
      );
    },
    // refSapRem() {
    //   return this.$store.getters['dictModule/refSapRem'].filter(
    // 		item => {
    // 			return item.id === "" || item.so_id === Number(this.sap_so_id)
    // 		}
    // 	)
    // },
    refSapRem() {
      const soIdAuth = Number(this.$store.getters["dictModule/soIdAuth"]);
      const filterParams = this.getFilterParams();

      if (soIdAuth === 0) {
        if (this.bMounted) {
          this.sap_rem_id = filterParams["sap_rem_id"];
          this.bMounted = false;
        }
        return this.$store.getters["dictModule/refSapRem"].filter(
          (item) => item.id === "" || item.so_id === Number(this.sap_so_id)
        );
      } else {
        const remIdAuth = Number(this.$store.getters["dictModule/remIdAuth"]);
        if (remIdAuth === 0) {
          if (this.bMounted) {
            this.sap_rem_id = filterParams["sap_rem_id"];
            this.bMounted = false;
          }
          // this.sap_rem_id = filterParams["sap_rem_id"] ?? ""
          return this.$store.getters["dictModule/refSapRem"].filter(
            (item) =>
              item.id === "" || item.so_id === Number(this.sap_so_id) || item.id === 0
          );
        } else {
          this.sap_rem_id = remIdAuth;
          return this.$store.getters["dictModule/refSapRem"].filter(
            (item) => item.id === remIdAuth
          );
        }
      }
    },
  },

  watch: {
    // sap_so_id(newVal, oldVal) {
    // 	this.sap_rem_id = ""
    // },
  },

  created() {
    this.$store.dispatch("dictModule/setRef", { id: "sap_sos" });
    this.$store.dispatch("dictModule/setRef", { id: "sap_rems" });
  },
  mounted() {
    const filterParams = this.getFilterParams();

    this.sap_so_id = filterParams["sap_so_id"] ?? "";
    this.sap_rem_id = filterParams["sap_rem_id"] ?? "";

    console.log("filterParams", this.sap_so_id, this.sap_rem_id);
  },
};
</script>

<style scoped></style>
