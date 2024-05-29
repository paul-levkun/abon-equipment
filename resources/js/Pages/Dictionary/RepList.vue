<script setup>
import VLayout from "./../../Layouts/VLayout.vue";
// import { Head } from '@inertiajs/vue3';
import SecondaryButton from "./../../Components/SecondaryButton";
</script>

<template>
  <!-- <Head title="Dashboard" /> -->

  <!-- <h1>Dictionary Page</h1> -->

  <VLayout>
    <template #header>
      <div class="flex flex-row justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Звіти</h2>
        <SecondaryButton class="ml-1" @click="backToWelcome"> Назад </SecondaryButton>
      </div>
    </template>

    <div v-if="isLoading" class="py-12">
      <base-spinner></base-spinner>
    </div>

    <div
      class="mt-8 bg-white dark:bg-gray-800 overflow-auto shadow sm:rounded-lg max-w-6xl mx-auto"
    >
      <!-- <div class="grid grid-cols-1 md:grid-cols-1"> -->
      <dict-item
        v-for="rep in repList"
        :key="rep.id"
        :id="rep.id"
        :title="rep.title"
        :description="rep.description"
      >
      </dict-item>
      <!-- </div> -->
    </div>
    <!-- <button type="button" @click="showDict" class="underline text-gray-900 dark:text-white">button</button> -->
  </VLayout>
</template>

<script>
import DictItem from "./DictItem";

export default {
  name: "RegList",
  // props: ['userId', 'soId', 'remId', ],
  props: {
    userId: {
      type: Number,
      required: true,
    },
    userName: {
      type: String,
      required: true,
    },
    soId: {
      type: Number,
      required: true,
    },
    remId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      bView: false,
    };
  },
  methods: {
    backToWelcome() {
      window.location.href = `${window.location.protocol}//${window.location.hostname}:${window.location.port}`;
    },
  },
  computed: {
    repList() {
      const reps = this.$store.getters["dictModule/reps"];
      return reps;
    },
    isLoading() {
      return this.$store.getters["dictModule/isLoading"];
    },
  },

  mounted() {
    if (
      !this.$store.getters["dictModule/userId"] ||
      this.$store.getters["dictModule/userId"] !== this.userId
    ) {
      this.$store.commit("dictModule/setUserId", this.userId);
      this.$store.commit("dictModule/setUserName", this.userName);
      this.$store.commit("dictModule/setSoIdAuth", this.soId);
      this.$store.commit("dictModule/setRemIdAuth", this.remId);
      this.$store.commit("dictModule/setBoIdAuth", this.boId);

      // // Default Filter
      // if (this.soId) {
      //   const filterParams = {
      //     sap_so_id: this.soId,
      //     sap_rem_id: this.remId,
      //   }
      //   // this.$store.commit('dictModule/setFilterOwnerParams', filterParams)
      //   this.$store.commit('dictModule/setFilterSubstationParams', filterParams)
      //   this.$store.commit('dictModule/setFilterLineParams', filterParams)
      //   this.$store.commit('dictModule/setFilterRegisterParams', filterParams)
      //   // this.$store.commit('dictModule/setFilterContractParams', filterParams)
      //   console.log("commit('dictModule/setFilterOwnerParams'", filterParams)
      // }

      // // Default Filter
      // if (this.boId) {
      //   const filterParams = {
      //     sap_bo_id: this.boId,
      //   }
      //   this.$store.commit('dictModule/setFilterContractParams', filterParams)
      //   console.log("commit('dictModule/setFilterOwnerParams2'", filterParams)
      // }
    }
  },
};
</script>

<style scoped></style>
