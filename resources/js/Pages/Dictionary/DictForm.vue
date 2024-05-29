<script setup>
import DictLayout from "./../../Layouts/DictLayout.vue";
import FormOwner from "./Forms/FormOwner.vue";
import FormRem from "./Forms/FormRem.vue";
import FormOwnerType from "./Forms/FormOwnerType.vue";
import FormEquipmentType from "./Forms/FormEquipmentType.vue";
import FormLocationType from "./Forms/FormLocationType.vue";
import FormTechStateType from "./Forms/FormTechStateType.vue";
import FormLineSectionType from "./Forms/FormLineSectionType.vue";
import FormLineType from "./Forms/FormLineType.vue";
import FormDocType from "./Forms/FormDocType.vue";
import FormRegister from "./Forms/FormRegister.vue";
import FormContractType from "./Forms/FormContractType.vue";
import FormContractFailureType from "./Forms/FormContractFailureType.vue";
import FormContractInexpediencyType from "./Forms/FormContractInexpediencyType.vue";
import FormUser from "./Forms/FormUser.vue";
</script>

<template>
  <DictLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ structName }} "{{ dictTitle }}" - {{ structMode }}
      </h2>
    </template>

    <template #table>
      <div
        class="pt-1 bg-white dark:bg-gray-800 shadow sm:rounded-lg mx-auto"
        :class="panWidth"
      >
        <FormOwner v-if="dictId === 'owners'" @clearValidity="clearValidity"></FormOwner>
        <FormRem v-else-if="dictId === 'rems'"></FormRem>
        <form-owner-type
          v-else-if="dictId === 'owner_types'"
          @clearValidity="clearValidity"
        ></form-owner-type>
        <form-equipment-type
          v-else-if="dictId === 'equipment_types'"
          @clearValidity="clearValidity"
        ></form-equipment-type>
        <form-location-type
          v-else-if="dictId === 'location_types'"
          @clearValidity="clearValidity"
        ></form-location-type>
        <form-tech-state-type
          v-else-if="dictId === 'tech_state_types'"
          @clearValidity="clearValidity"
        ></form-tech-state-type>
        <form-line-section-type
          v-else-if="dictId === 'line_section_types'"
          @clearValidity="clearValidity"
        ></form-line-section-type>
        <form-line-type
          v-else-if="dictId === 'line_types'"
          @clearValidity="clearValidity"
        ></form-line-type>
        <form-doc-type
          v-else-if="dictId === 'doc_types'"
          @clearValidity="clearValidity"
        ></form-doc-type>
        <form-register
          v-else-if="dictId === 'registers'"
          @clearValidity="clearValidity"
        ></form-register>
        <form-contract-type
          v-else-if="dictId === 'contract_types'"
          @clearValidity="clearValidity"
        ></form-contract-type>
        <form-contract-failure-type
          v-else-if="dictId === 'contract_failure_types'"
          @clearValidity="clearValidity"
        ></form-contract-failure-type>
        <form-contract-inexpediency-type
          v-else-if="dictId === 'contract_inexpediency_types'"
          @clearValidity="clearValidity"
        ></form-contract-inexpediency-type>
        <FormUser v-else-if="dictId === 'users'"></FormUser>
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
        "Leaving DictForm",
        sessionStorage["structName"],
        sessionStorage["allowRoute"]
      );
      next();
    } else {
      sessionStorage["allowRoute"] = 0;
      next(false);
    }
  },

  name: "DictContent",
  data() {
    return {
      dictId: "",
      dictTitle: "",
      structName: "",
      structMode: "",
    };
  },

  methods: {
    clearValidity(inputId) {
      let formErrors = this.$store.getters["dictModule/formErrors"];
      delete formErrors[inputId];
      this.$store.commit("dictModule/setFormErrors", formErrors);
    },
  },

  computed: {
    panWidth() {
      switch (this.dictId) {
        case "registers":
          return "max-w-6xl";
        default:
          return "max-w-4xl";
      }
    },
  },

  created() {},

  mounted() {
    this.dictId = this.$store.getters["dictModule/currentDictId"];
    this.dictTitle = this.$store.getters["dictModule/currentDictTitle"];
    this.structName = this.$store.getters["dictModule/structName"];
    // this.structMode =
    //   Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0
    //     ? "Додавання"
    //     : "Редагування";
    this.structMode = !!+this.$store.getters["dictModule/formMode"]
      ? "Редагування"
      : "Додавання";
  },
};
</script>

<style></style>
