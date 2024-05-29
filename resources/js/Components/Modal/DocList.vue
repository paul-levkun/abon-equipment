<script setup>
import InputLabel from "./../InputLabel.vue";
import DropdownList from "./../DropdownList.vue";
import SecondaryButton from "./../SecondaryButton";
import NavLink from "./../NavLink";
import BaseModal from "./../../Layouts/BaseModal.vue";
</script>

<!-- required -->
<template>
  <base-modal>
    <div class="min-h-96 max-h-96">
      <div class="absolute top-0">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mt-4">
          Документи, завантажені на сервер
        </h2>
      </div>

      <div class="min-h-80 max-h-80 mt-10 overflow-auto">
        <div v-for="doc in documents" :key="doc.id" class="mx-3">
          <div
            v-if="doc.isTypeName"
            class="text-md font-bold border-b-2 text-gray-500 border-gray-500 mt-2"
          >
            <h2>{{ doc.typeName }}</h2>
          </div>
          <div class="flex flex-row mt-1 justify-between">
            <NavLink :href="doc.fileFullPath" active="true">{{ doc.fileName }}</NavLink>
          </div>
        </div>
      </div>

      <div class="absolute bottom-0">
        <SecondaryButton @click="hideDialog()" class="mb-4 ml-1">Закрити</SecondaryButton>
      </div>
    </div>
  </base-modal>
</template>

<script>
export default {
  inject: ["hideDialog"],
  props: ["registerId"],
  data() {
    return {};
  },
  methods: {},
  computed: {
    documents() {
      let typeName = "";
      return this.$store.getters["dictModule/refDocument"].map((itemDoc) => {
        const fileFullPath =
          `${window.location.protocol}//${window.location.hostname}:${window.location.port}/download` +
          `?file_path=${itemDoc.file_path}`;
        const fileName = itemDoc.file_path.split("/")[4];
        const docType = this.$store.getters["dictModule/refDocType"].find(
          (itemDocType) => itemDoc.doc_type_id === itemDocType.id
        );
        let isTypeName = false;
        if (typeName !== docType.name) {
          isTypeName = true;
          typeName = docType.name;
        }
        return {
          id: itemDoc.id,
          fileFullPath: fileFullPath,
          fileRelPath: itemDoc.file_path,
          fileName: fileName,
          typeName: typeName,
          isTypeName: isTypeName,
        };
      });
    },
  },

  watch: {},

  created() {
    this.$store.dispatch("dictModule/setRef", { id: "doc_types" });
    // Документи
    const dict_id = "documents";
    this.$store.dispatch("dictModule/updateDocs", {
      id: dict_id,
      row_id: this.registerId,
    });
  },
  mounted() {
    console.log(this.$store.getters["dictModule/refDocument"]);
  },
};
</script>

<style scoped></style>
