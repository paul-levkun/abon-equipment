<script setup>
import Paginator from "./../Components/Paginator.vue";
import PrimaryButton from "./../Components/PrimaryButton";
import SecondaryButton from "./../Components/SecondaryButton";
import DangerButton from "./../Components/DangerButton";
import ModalDeleteConfirm from "./../Components/Modal/DeleteConfirm";
import ModalDeleteBusy from "./../Components/Modal/DeleteBusy";
import FilterSubstation from "./../Components/Modal/FilterSubstation";
import FilterLine from "./../Components/Modal/FilterLine";
import FilterRegister from "./../Components/Modal/FilterRegister";
import FilterOwner from "./../Components/Modal/FilterOwner";
import FilterContract from "./../Components/Modal/FilterContract";
import DocList from "./../Components/Modal/DocList";
import FilterConnectedSubstation from "./../Components/Modal/FilterConnectedSubstation";
import FilterConnectedLine from "./../Components/Modal/FilterConnectedLine";
</script>

<template>
  <!-- <div class="flex flex-col h-[calc(100vh-50px)] max-w-7xl mx-auto"> -->
  <div class="flex flex-col h-[calc(100vh-50px)] w-full mx-auto">
    <div class="flex justify-between px-1">
      <div v-if="!isDictRef">
        <!-- <a href="{{ route('dict-form') }}"></a> -->
        <PrimaryButton @click="addRec" :disabled="!canAdd">Додати</PrimaryButton>
        <PrimaryButton @click="updateRec" class="ml-1" :disabled="!canUD">
          Редагувати
        </PrimaryButton>
        <DangerButton @click="deleteAsk" class="ml-1" :disabled="!canUD">
          Видалити
        </DangerButton>
        <SecondaryButton class="ml-1" @click="backToList"> Назад </SecondaryButton>
      </div>
      <div v-else>
        <PrimaryButton @click="selectObject" :disabled="!canSelect"
          >Вибрати</PrimaryButton
        >
        <SecondaryButton class="ml-1" @click="back">Назад</SecondaryButton>
      </div>

      <div class="flex justify-start">
        <SecondaryButton class="me-1 max-h-10" @click="filterClick"
          >Фільтр</SecondaryButton
        >
        <Paginator @dict-grid-changed="dictGridChanged"></Paginator>
      </div>
    </div>

    <div v-if="isLoading" class="py-12">
      <base-spinner></base-spinner>
    </div>
    <div v-else class="flex-grow overflow-auto sm:p-0">
      <table class="relative w-full border border-slate-400 table-auto">
        <thead>
          <slot name="thead"></slot>
        </thead>
        <tbody class="h-96 overflow-auto">
          <slot
            name="tbody"
            :currentDict="currentDict"
            :pageId="pageId"
            :clickedRow="clickedRow"
          ></slot>
        </tbody>
      </table>
    </div>
  </div>
  <div>
    <modal-delete-confirm
      v-if="modDeleteConfirmVisible"
      @deleteRec="deleteRec"
      @hideDialog="hideDialog"
    ></modal-delete-confirm>
    <modal-delete-busy
      v-if="deleteBusyVisible"
      @hideDialog="hideDialog"
    ></modal-delete-busy>
    <filter-substation
      v-if="modFilterSubstationVisible"
      @resetPageId="resetPageId"
    ></filter-substation>
    <filter-line v-if="modFilterLineVisible" @resetPageId="resetPageId"></filter-line>
    <filter-register
      v-if="modFilterRegisterVisible"
      @resetPageId="resetPageId"
    ></filter-register>
    <filter-owner v-if="modFilterOwnerVisible" @resetPageId="resetPageId"></filter-owner>
    <filter-contract
      v-if="modFilterContractVisible"
      @resetPageId="resetPageId"
    ></filter-contract>
    <doc-list v-if="modDocListVisible" :register-id="docRegId"></doc-list>
    <filter-connected-substation
      v-if="modFilterConnectedSubstationVisible"
      @resetPageId="resetPageId"
    ></filter-connected-substation>
    <filter-connected-line
      v-if="modFilterConnectedLineVisible"
      @resetPageId="resetPageId"
    ></filter-connected-line>
  </div>
</template>

<script>
export default {
  props: ["clickedRow", "isDocList", "docRegId"],
  emits: ["deleteClickReset"],
  inject: ["dictCanUD"],
  data() {
    return {
      modDeleteConfirmVisible: false,
      modFilterSubstationVisible: false,
      modFilterLineVisible: false,
      modFilterRegisterVisible: false,
      modFilterOwnerVisible: false,
      modFilterContractVisible: false,
      modDocListVisible: false,
      modFilterConnectedSubstationVisible: false,
      modFilterConnectedLineVisible: false,
      isDictRef: false,
    };
  },

  provide() {
    return {
      modSize: () => {
        // вертає функцію
        if (
          this.modFilterSubstationVisible ||
          this.modFilterLineVisible ||
          this.modFilterRegisterVisible ||
          this.modFilterOwnerVisible ||
          this.modFilterContractVisible ||
          this.modDocListVisible ||
          this.modFilterConnectedSubstationVisible ||
          this.modFilterConnectedLineVisible
        )
          return "modal-size60";
        else return "modal-size30";
      },
      hideDialog: this.hideDialog,
    };
  },

  methods: {
    dictGridChanged(pageIdNew) {
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const dict_title = this.$store.getters["dictModule/currentDictTitle"];
      this.$store.dispatch("dictModule/showDict", {
        id: dict_id,
        title: dict_title,
        pageId: pageIdNew,
      });
      this.$store.commit("dictModule/setCurrentDictPageId", pageIdNew);
      this.$emit("deleteClickReset");
    },
    addRec() {
      this.$store.commit("dictModule/setFormInputs", {});
      this.$store.commit("dictModule/setFormMode", 0);
      console.log("Ю 333333");
      sessionStorage["allowRoute"] = 1;
      this.$router.push("/dict-form");
    },
    updateRec() {
      console.log("Ю 33333311111");
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const row_id = this.clickedRow.id;
      this.$store.dispatch("dictModule/updateDict", { id: dict_id, row_id: row_id });
      this.$store.commit("dictModule/setFormMode", 1);
    },
    deleteRec() {
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const row_id = this.clickedRow.id;
      this.clickedRow.isSelected = false;
      const user_id = this.$store.getters["dictModule/userId"];
      this.$store.dispatch("dictModule/deleteDict", {
        id: dict_id,
        row_id: row_id,
        user_id: user_id,
      });
      this.modDeleteConfirmVisible = false;
      this.$emit("deleteClickReset");
    },
    deleteAsk() {
      this.modDeleteConfirmVisible = true;
    },
    filterClick() {
      const arrAllowed = [
        "substations",
        "lines",
        "registers",
        "owners",
        "contracts",
        "connected_substations",
        "connected_lines",
      ];
      if (arrAllowed.indexOf(this.$store.getters["dictModule/currentDictId"]) !== -1) {
        // console.log(this.$store.getters["dictModule/currentDictId"]);
        switch (this.$store.getters["dictModule/currentDictId"]) {
          case "substations":
            this.modFilterSubstationVisible = true;
            break;
          case "lines":
            this.modFilterLineVisible = true;
            break;
          case "registers":
            this.modFilterRegisterVisible = true;
            break;
          case "owners":
            this.modFilterOwnerVisible = true;
            break;
          case "contracts":
            this.modFilterContractVisible = true;
            break;
          case "connected_substations":
            this.modFilterConnectedSubstationVisible = true;
            break;
          case "connected_lines":
            this.modFilterConnectedLineVisible = true;
            break;
        }
      }
    },
    hideDialog() {
      this.modDeleteConfirmVisible = false;
      //
      let formErrors = this.$store.getters["dictModule/formErrors"];
      delete formErrors["delete"];
      this.$store.commit("dictModule/setFormErrors", formErrors);
      //
      this.modFilterSubstationVisible = this.modFilterLineVisible = this.modFilterRegisterVisible = this.modFilterOwnerVisible = this.modFilterContractVisible = this.modDocListVisible = this.modFilterConnectedSubstationVisible = this.modFilterConnectedLineVisible = false;
    },
    resetPageId() {
      this.$store.commit("dictModule/setCurrentDictPageId", 1);
    },
    selectObject() {
      const dict_id = this.$store.getters["dictModule/currentDictId"];
      const row_id = this.clickedRow.id;
      this.$store.dispatch("dictModule/updateDict", { id: dict_id, row_id: row_id });
    },
    back() {
      this.$store.commit("dictModule/setIsDictRef", false);
      console.log("Ю 444444");
      sessionStorage["allowRoute"] = 1;
      this.$router.push("/dict-form");
    },
    backToList() {
      const arrReg = [
        "registers",
        "owners",
        "substations",
        "lines",
        "contracts",
        "connected_substations",
        "connected_lines",
      ];
      if (arrReg.indexOf(this.$store.getters["dictModule/currentDictId"]) === -1) {
        console.log("Ю 555555");
        sessionStorage["allowRoute"] = 1;
        this.$router.push("/dict-list");
      } else {
        console.log("Ю 666666");
        sessionStorage["allowRoute"] = 1;
        this.$router.push("/reg-list");
      }
    },
    // makeReport() {
    //   this.$store.dispatch("dictModule/makeReport", { id: "ao_detail1" });
    // },
  },

  computed: {
    currentDict() {
      return this.$store.getters["dictModule/currentDict"];
    },
    isLoading() {
      return this.$store.getters["dictModule/isLoading"];
    },
    canAdd() {
      const arrExcept = [
        "rems",
        "voltage_classes",
        "sap_sos",
        "sap_rems",
        "substations",
        "lines",
        "contracts",
        "contract_status_types",
        "users",
        "object_types",
      ];
      return arrExcept.indexOf(this.$store.getters["dictModule/currentDictId"]) === -1;
    },
    canUD() {
      const arrExcept = [
        "rems",
        "voltage_classes",
        "sap_sos",
        "sap_rems",
        "substations",
        "lines",
        "contracts",
        "contract_status_types",
        "object_types",
      ];
      return (
        this.dictCanUD() &&
        arrExcept.indexOf(this.$store.getters["dictModule/currentDictId"]) === -1
      );
    },
    canSelect() {
      return this.dictCanUD();
    },
    deleteBusyVisible() {
      return this.$store.getters["dictModule/formErrors"]["delete"] !== undefined;
    },
    // isDictRef() {
    //   return this.$store.getters["dictModule/isDictRef"];
    //   // return false
    // },
    pageId() {
      return this.$store.getters["dictModule/currentDictPageId"];
    },
  },
  watch: {
    isDocList(newVal, oldVal) {
      if (newVal) {
        // console.log(this.docRegId);
        this.modDocListVisible = true;
      }
    },
  },

  mounted() {
    console.log(
      "mounted mounted DictGridContent",
      this.$store.getters["dictModule/isDictRef"]
    );
    this.isDictRef = this.$store.getters["dictModule/isDictRef"];
  },
  unmounted() {
    // console.log("UNMOUNTED")
  },
};
</script>

<style scoped></style>
