<script setup>
  import DictFormContent from './../../../Layouts/DictFormContent.vue';
  import InputLabel from './../../../Components/InputLabel.vue';
  import TextInput from './../../../Components/TextInput.vue';
  import List from './../../../Components/List.vue';
  import DropdownList from './../../../Components/DropdownList.vue';
</script>

<template>
  <!-- required  -->
  <DictFormContent @submitForm="submitForm" >
    <template #default>
      <div>
        <div class="flex flex-row mt-2">
        <!-- <div class="grid grid-cols-2"> -->
          <div class="w-1/2 pr-1">
            <InputLabel for="name" value="Ім'я" />
            <TextInput readonly
              id="name" class="mt-1 w-full" v-model.trim="name"
              autofocus
            />
          </div>
          <div class="w-1/2 pl-1">
            <InputLabel for="email" value="Email" />
            <TextInput readonly
              id="email" class="mt-1 w-full" v-model.trim="email"
              autofocus
            />
          </div>
        </div>
        <div class="flex flex-row mt-3">
          <div class="w-1/2 pr-1">
            <InputLabel for="so" value="Структурна одиниця" />
            <!-- <DropdownList :invalid="isSapSoInvalid" @blur="clearValidity('so')" -->
            <DropdownList
              id="so" class="mt-1 w-full" :refArr="refSapSo" v-model="so_id" @change="soChange"/>
            <!-- <List :refArr="sapSoErrors"></List> -->
          </div>
          <div class="w-1/2 pl-1">
            <InputLabel for="rem" value="Дільниця"/>
            <!-- <DropdownList :invalid="isSapRemInvalid" @blur="clearValidity('rem')" -->
            <DropdownList
              id="rem" class="mt-1 w-full" :refArr="refSapRem" v-model="rem_id"/>
            <!-- <List :refArr="sapRemErrors"></List> -->
          </div>
        </div>
        <div class="flex flex-row mt-3">
          <div class="w-1/2 pr-1">
            <InputLabel for="bo" value="Балансова одиниця (договори)" />
            <DropdownList
              id="bo" class="mt-1 w-full" :refArr="refSapBo" v-model="bo_id"/>
          </div>
        </div>
      </div>
    </template>
  </DictFormContent>
</template>

<script>
export default {
  emits: ["clearValidity"],
  data() {
    return {
      name: "",
      email: "",
      so_id: "",
			rem_id: "",
      bo_id: "",
      row_id: null,
      // isInvalid: true,
    }
  },
  methods: {
    submitForm() {
      console.log(this.name, this.shortName, this.row_id)
      let data = new FormData();
      data.append('id', "users")
      // data.append('name', this.name)
      data.append('row_id', this.row_id)
      data.append('user_id', this.$store.getters['dictModule/userId'])
      data.append('so_id', this.so_id)
      data.append('rem_id', this.rem_id)
      data.append('bo_id', this.bo_id)
      if (this.row_id)
        data.append("_method", "put");

      this.$store.dispatch('dictModule/storeDict', { "id": "users", "oper": this.row_id ? "upd" : "add", "data": data } )
    },
    soChange() {
      this.rem_id = ""
    },

  },
  computed: {
    refSapSo() {
      const sapSo = this.$store.getters['dictModule/refSapSo'].filter(
        item => item.id !== ""
      )
      sapSo.push({ id: -1, name: "Права відсутні" })
      return sapSo
    },
		refSapRem() {
      return this.$store.getters['dictModule/refSapRem'].filter(
				item => {
					return item.id === "" || item.so_id === Number(this.so_id)
				}
			)
    },
    refSapBo() {
      const sapBo = this.$store.getters['dictModule/refSapBo'].filter(
        item => item.id !== ""
      )
      sapBo.push({ id: -1, name: "Права відсутні" })
      return sapBo
    },
  },
  created() {
    this.$store.dispatch('dictModule/setRef', { id: "sap_sos", })
    this.$store.dispatch('dictModule/setRef', { id: "sap_rems", })
    this.$store.dispatch('dictModule/setRef', { id: "sap_bos", })
  },
  mounted() {
    this.row_id = this.$store.getters['dictModule/formInputs'].id
    this.name = this.$store.getters['dictModule/formInputs'].name
    this.email = this.$store.getters['dictModule/formInputs'].email
    this.so_id = this.$store.getters['dictModule/formInputs'].so_id/* === -1
        ? "" 
        : this.$store.getters['dictModule/formInputs'].so_id*/
    this.rem_id = this.$store.getters['dictModule/formInputs'].rem_id === -1 || this.$store.getters['dictModule/formInputs'].rem_id === 0 
        ? "" 
        : this.$store.getters['dictModule/formInputs'].rem_id
    this.bo_id = this.$store.getters['dictModule/formInputs'].bo_id/* === -1
        ? "" 
        : this.$store.getters['dictModule/formInputs'].bo_id*/
  },
}
</script>
<style>

</style>