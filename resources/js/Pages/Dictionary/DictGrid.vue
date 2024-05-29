<script setup>
import DictLayout from "./../../Layouts/DictLayout.vue";
import GridOwner from "./Grids/GridOwner.vue";
import GridSubstation from "./Grids/GridSubstation.vue";
import GridLine from "./Grids/GridLine.vue";
import GridRem from "./Grids/GridRem.vue";
import GridOwnerType from "./Grids/GridOwnerType.vue";
import GridEquipmentType from "./Grids/GridEquipmentType.vue";
import GridVoltageClass from "./Grids/GridVoltageClass.vue";
import GridObjectType from "./Grids/GridObjectType.vue";
import GridLocationType from "./Grids/GridLocationType.vue";
import GridTechStateType from "./Grids/GridTechStateType.vue";
import GridLineSectionType from "./Grids/GridLineSectionType.vue";
import GridLineType from "./Grids/GridLineType.vue";
import GridDocType from "./Grids/GridDocType.vue";
import GridSapSo from "./Grids/GridSapSo.vue";
import GridSapRem from "./Grids/GridSapRem.vue";
import GridRegister from "./Grids/GridRegister.vue";
import GridContract from "./Grids/GridContract.vue";
import GridContractStatusType from "./Grids/GridContractStatusType.vue";
import GridContractType from "./Grids/GridContractType.vue";
import GridContractFailureType from "./Grids/GridContractFailureType.vue";
import GridContractInexpediencyType from "./Grids/GridContractInexpediencyType.vue";
import GridUser from "./Grids/GridUser.vue";
import GridConnectedSubstation from "./Grids/GridSubstation.vue";
import GridConnectedLine from "./Grids/GridLine.vue";

// import GridTest from "./Grids/GridTest.vue"
</script>

<template>
  <DictLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ structName }} "{{ dictTitle }}"
      </h2>
    </template>

    <template #table>
      <div
        class="pt-1 bg-white dark:bg-gray-800 overflow-auto shadow sm:rounded-lg mx-auto"
        :class="panWidth"
      >
        <GridOwner v-if="dictId === 'owners'" @showActiveRow="showActiveRow"></GridOwner>
        <grid-substation
          v-if="dictId === 'substations'"
          @showActiveRow="showActiveRow"
        ></grid-substation>
        <grid-line v-if="dictId === 'lines'" @showActiveRow="showActiveRow"></grid-line>
        <!-- <grid-rem v-else-if="dictId === 'rems'" @showActiveRow="showActiveRow"></grid-rem> -->
        <grid-owner-type
          v-else-if="dictId === 'owner_types'"
          @showActiveRow="showActiveRow"
        ></grid-owner-type>
        <grid-contract
          v-else-if="dictId === 'contracts'"
          @showActiveRow="showActiveRow"
        ></grid-contract>
        <grid-equipment-type
          v-else-if="dictId === 'equipment_types'"
          @showActiveRow="showActiveRow"
        ></grid-equipment-type>
        <grid-voltage-class
          v-else-if="dictId === 'voltage_classes'"
          @showActiveRow="showActiveRow"
        ></grid-voltage-class>
        <grid-object-type
          v-else-if="dictId === 'object_types'"
          @showActiveRow="showActiveRow"
        ></grid-object-type>
        <grid-location-type
          v-else-if="dictId === 'location_types'"
          @showActiveRow="showActiveRow"
        ></grid-location-type>
        <grid-tech-state-type
          v-else-if="dictId === 'tech_state_types'"
          @showActiveRow="showActiveRow"
        ></grid-tech-state-type>
        <grid-line-section-type
          v-else-if="dictId === 'line_section_types'"
          @showActiveRow="showActiveRow"
        ></grid-line-section-type>
        <grid-line-type
          v-else-if="dictId === 'line_types'"
          @showActiveRow="showActiveRow"
        ></grid-line-type>
        <grid-doc-type
          v-else-if="dictId === 'doc_types'"
          @showActiveRow="showActiveRow"
        ></grid-doc-type>
        <grid-sap-so
          v-else-if="dictId === 'sap_sos'"
          @showActiveRow="showActiveRow"
        ></grid-sap-so>
        <grid-sap-rem
          v-else-if="dictId === 'sap_rems'"
          @showActiveRow="showActiveRow"
        ></grid-sap-rem>
        <grid-register
          v-else-if="dictId === 'registers'"
          @showActiveRow="showActiveRow"
        ></grid-register>
        <grid-contract-status-type
          v-else-if="dictId === 'contract_status_types'"
          @showActiveRow="showActiveRow"
        ></grid-contract-status-type>
        <grid-contract-type
          v-else-if="dictId === 'contract_types'"
          @showActiveRow="showActiveRow"
        ></grid-contract-type>
        <grid-contract-failure-type
          v-else-if="dictId === 'contract_failure_types'"
          @showActiveRow="showActiveRow"
        ></grid-contract-failure-type>
        <grid-contract-inexpediency-type
          v-else-if="dictId === 'contract_inexpediency_types'"
          @showActiveRow="showActiveRow"
        ></grid-contract-inexpediency-type>
        <grid-user
          v-else-if="dictId === 'users'"
          @showActiveRow="showActiveRow"
        ></grid-user>
        <grid-connected-substation
          v-if="dictId === 'connected_substations'"
          @showActiveRow="showActiveRow"
        ></grid-connected-substation>
        <grid-connected-line
          v-if="dictId === 'connected_lines'"
          @showActiveRow="showActiveRow"
        ></grid-connected-line>
      </div>
    </template>
  </DictLayout>
</template>

<script>
export default {
  beforeRouteLeave: function (to, from, next) {
    console.log(sessionStorage["allowRoute"], !!+sessionStorage["allowRoute"]);
    if (!!+sessionStorage["allowRoute"]) {
      sessionStorage["allowRoute"] = 0;
      console.log(
        "Leaving DictGrid",
        sessionStorage["structName"],
        sessionStorage["allowRoute"]
      );
      next();
    } else {
      sessionStorage["allowRoute"] = 0;
      next(false);
    }
  },

  name: "DictGrid",
  data() {
    return {
      dictId: "",
      dictTitle: "",
      structName: "",
      dictCanUD: false,
      activeRowId: null,
    };
  },

  provide() {
    return {
      // dictCanUD: computed(() => this.dictCanUD),// this.dictCanUD // так в доках. не працює реактивність
      dictCanUD: () => this.dictCanUD, // вертає функцію
    };
  },

  methods: {
    showActiveRow(clickedRow) {
      if (this.activeRowId && this.activeRowId !== clickedRow.id) {
        this.$store.getters["dictModule/currentDict"].forEach((item) => {
          if (item.id === this.activeRowId) {
            item.isSelected = false;
          }
        });
      }

      this.$store.getters["dictModule/currentDict"].forEach((item) => {
        if (item.id === clickedRow.id) {
          item.isSelected = clickedRow.isSelected;
        }
      });

      this.activeRowId = clickedRow.isSelected ? clickedRow.id : null;
      this.dictCanUD = !!this.activeRowId;
    },
  },

  computed: {
    panWidth() {
      switch (this.dictId) {
        case "registers":
          return "w-11/12";
        case "substations":
        case "lines":
        case "contracts":
        case "connected_substations":
        case "connected_lines":
          return "w-10/12";
        default:
          return "max-w-6xl";
      }
    },
  },

  mounted() {
    // console.log("mounted DictGrid")
    this.dictId = this.$store.getters["dictModule/currentDictId"];
    this.dictTitle = this.$store.getters["dictModule/currentDictTitle"];
    this.structName = this.$store.getters["dictModule/structName"];

    if (this.$store.getters["dictModule/forcedDownload"]) {
      this.$store.dispatch("dictModule/showDict", {
        id: this.dictId,
        title: this.dictTitle,
        pageId: this.$store.getters["dictModule/currentDictPageId"],
      });
    } else {
      this.$store.commit("dictModule/setForcedDownload", true);
    }

    // console.log('Leaving DictGrid enter', this.allowRoute);
  },
};
</script>

<style>
.tr:hover {
  border-color: purple;
  border-width: 3px;
  border-style: dotted;
}

.tr-selected {
  border-color: purple;
  border-width: 3px;
  border-style: solid;
}
</style>
