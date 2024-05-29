<script setup>
import DictGridContent from "./../../../Layouts/DictGridContent.vue";
</script>

<template>
  <DictGridContent :clickedRow="clickedRow" @delete-click-reset="deleteClickReset">
    <template #thead>
      <tr>
        <th
          class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300 w-20"
        >
          № з/п
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Назва
        </th>
      </tr>
    </template>

    <template #tbody="{ currentDict, pageId }">
      <tr
        v-for="(row, index) in currentDict"
        :key="row.id"
        class="bg-white tr"
        @click="rowClick(row.id, row.isSelected)"
        :class="{ 'tr-selected': row.isSelected }"
      >
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ (pageId - 1) * 20 + index + 1 }}
        </td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.name }}</td>
      </tr>
    </template>
  </DictGridContent>
</template>

<script>
export default {
  emits: ["showActiveRow"],
  data() {
    return {
      clickedRow: { id: null, isSelected: false },
    };
  },
  methods: {
    rowClick(id, isSelected) {
      this.clickedRow.id = id;
      this.clickedRow.isSelected = !isSelected;
      this.$emit("showActiveRow", this.clickedRow);
    },
    deleteClickReset() {
      this.clickedRow.isSelected = false;
      this.$emit("showActiveRow", this.clickedRow);
    },
  },
  computed: {},
};
</script>
