<script setup>
import VLayout from './../../Layouts/VLayout.vue';
import SecondaryButton from "./../../Components/SecondaryButton";
// import { Head } from '@inertiajs/vue3';
</script>

<template>
  <!-- <Head title="Dashboard" /> -->

  <!-- <h1>Dictionary Page</h1> -->

  <VLayout>
    <template #header>
      <div class="flex flex-row justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Довідники</h2>
        <SecondaryButton class="ml-1" @click="backToWelcome">
          Назад
        </SecondaryButton>
      </div>
    </template>

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-auto shadow sm:rounded-lg max-w-6xl mx-auto">
      <!-- <div class="grid grid-cols-1 md:grid-cols-1"> -->
        <dict-item v-for="dict in dictList"
          :key="dict.id"
          :id="dict.id"
          :title="dict.title"
          :description="dict.description" >
        </dict-item>
      <!-- </div> -->
    </div>
    <!-- <button type="button" @click="showDict" class="underline text-gray-900 dark:text-white">button</button> -->
  </VLayout>
</template>


<script>
  import DictItem from "./DictItem";

  export default {
    beforeRouteLeave: function(to, from, next) {
      console.log(sessionStorage['allowRoute'], !!(+sessionStorage['allowRoute']))
      if (!!(+sessionStorage['allowRoute'])) {
        sessionStorage['allowRoute'] = 0
        console.log('Leaving DictGrid', sessionStorage['structName'], sessionStorage['allowRoute']);
        next();
      }
      else {
        sessionStorage['allowRoute'] = 0
        console.log('Іди у с...у')
        next(false);
      }
    },

		name: "DictList",
    // props: ['userId', 'soId', 'remId', ],
    props: {
      userId: {
        type: Number,
        required: true,
      },
      userName: {
        type: String,
        required: true,
        // default: "Admin",
      },
      soId: {
        type: Number,
        required: true,
      },
      remId: {
        type: Number,
        required: true,
        default: 0,
      },
    },

    data() {
      return {
        bView: false
      }
    },
    methods: {
      backToWelcome() {
        window.location.href = `${window.location.protocol}//${window.location.hostname}:${window.location.port}`;
      },
    },
    computed: {
      dictList() {
        const dicts = this.$store.getters['dictModule/dicts']
        return dicts
      },
      // canShowDict(id) {
      //   const arr = [ "users", ]
      //   return arr.indexOf(id) !== -1
      // },
      canShowDict() {
        // const arr = [ "users", ]
        // return arr.indexOf(dict.id) !== -1
        return true;
      },
    },

		mounted() {
      console.log("this.userName", this.userName)
      if (!this.$store.getters['dictModule/userId'] || this.$store.getters['dictModule/userId'] !== this.userId) {
        this.$store.commit('dictModule/setUserId', this.userId)
        this.$store.commit('dictModule/setUserName', this.userName)
        this.$store.commit('dictModule/setSoIdAuth', this.soId)
        this.$store.commit('dictModule/setRemIdAuth', this.remId)
        this.$store.commit('dictModule/setBoIdAuth', this.boId)
        this.$store.commit('dictModule/setStructName', "Довідник")

        // Default Filter
        if (this.soId) {
          const filterParams = {
            sap_so_id: this.soId,
            sap_rem_id: this.remId,
          }
          // this.$store.commit('dictModule/setFilterOwnerParams', filterParams)        
          this.$store.commit('dictModule/setFilterSubstationParams', filterParams)        
          this.$store.commit('dictModule/setFilterLineParams', filterParams)        
          this.$store.commit('dictModule/setFilterRegisterParams', filterParams)        
          // this.$store.commit('dictModule/setFilterContractParams', filterParams)  
          console.log("commit('dictModule/setFilterOwnerParams'", filterParams)      
        }

        // Default Filter
        if (this.boId) {
          const filterParams = {
            sap_bo_id: this.boId,
          }
          this.$store.commit('dictModule/setFilterContractParams', filterParams)  
          console.log("commit('dictModule/setFilterOwnerParams2'", filterParams)      
        }
  		}
    },
  }
</script>

<style scoped>

</style>
