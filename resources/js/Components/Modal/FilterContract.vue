<script setup>
  import Filter from './../../Layouts/Filter.vue';
  import InputLabel from './../InputLabel.vue';
  import TextInput from './../TextInput.vue';
  import DropdownList from './../DropdownList.vue';
</script>

<template>
  <Filter @submitForm="submitForm">
    <div class="flex flex-row mt-2">
      <div class="w-1/2 pr-1">
        <InputLabel for="sap_bo" value="Балансова одиниця" />
        <DropdownList id="sap_bo" class="mt-1 w-full" :refArr="refSapBo" v-model="sap_bo_id"/>
      </div>
    </div>
    <div class="flex flex-row mt-2">
      <div class="w-1/4 pr-1">
        <InputLabel for="code" value="№ SAP договору" />
        <TextInput
          id="code" class="mt-1 w-full" v-model.trim="code" autofocus
        />
      </div>
      <div class="w-1/4 pr-1">
        <InputLabel for="owner_code" value="ЄДРПОУ / ІПН власника" />
        <TextInput
          id="owner_code" class="mt-1 w-full" v-model.trim="owner_code" autofocus
        />
      </div>
      <div class="w-1/2 px-1">
        <InputLabel for="owner_name" value="Назва власника" />
        <TextInput
          id="owner_name" class="mt-1 w-full" v-model.trim="owner_name" autofocus
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
      sap_bo_id: "",
      code: "",
      owner_code: "",
      owner_name: "",
    }
  },
  methods: {
    submitForm(/*sap_so_id, sap_rem_id*/) {
      const dict_id = this.$store.getters['dictModule/currentDictId']
      const dict_title = this.$store.getters['dictModule/currentDictTitle']
      
      const filterParams = {
        // sap_so_id: sap_so_id,
        // sap_rem_id: sap_rem_id,
        sap_bo_id: this.sap_bo_id,
        code: this.code,
        owner_code: this.owner_code,
        owner_name: this.owner_name,
      }
      this.$store.commit('dictModule/setFilterContractParams', filterParams)

      this.$store.dispatch('dictModule/showDict', { 
        id: dict_id, 
        title: dict_title, 
        pageId: 1, 
      })

      this.$emit('resetPageId')
    },
  },
  computed: {
		refSapBo() {
      // return this.$store.getters['dictModule/refSapBo']
    },
		refSapBo() {
			const boIdAuth = Number(this.$store.getters['dictModule/boIdAuth'])
			const filterParams = this.$store.getters['dictModule/filterContractParams']

			this.sap_bo_id = boIdAuth === 0 ? filterParams["sap_bo_id"] ?? "" : boIdAuth
			return this.$store.getters['dictModule/refSapBo'].filter(
				item => boIdAuth === 0 ? true : item.id === boIdAuth
			)
    },
  },
  created() {
    console.log("FilterContract createdd")
    this.$store.dispatch('dictModule/setRef', { id: "sap_bos", })
  },
  mounted() {
    console.log("FilterContract mounting")
		const filterParams = this.$store.getters['dictModule/filterContractParams']
    this.sap_bo_id = filterParams["sap_bo_id"] ?? ""
		this.code = filterParams["code"] ?? ""
		this.owner_code = filterParams["owner_code"] ?? ""
		this.owner_name = filterParams["owner_name"] ?? ""
    console.log("FilterContract mounted")
	}
}
</script>
