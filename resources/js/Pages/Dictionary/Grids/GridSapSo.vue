<script setup>
  import DictGridContent from './../../../Layouts/DictGridContent.vue';
</script>

<template>
  <DictGridContent :clickedRow="clickedRow">
    <template #thead>
      <tr>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300 w-20">№ з/п</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Код СО</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Індекс</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Нас. пункт</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Назва</th>
      </tr>
    </template>

    <template #tbody="{ currentDict, pageId }">
      <tr v-for="(row, index) in currentDict" :key="row.id" class="bg-white tr" 
          @click="rowClick(row.id, row.isSelected)" 
          :class="{ 'tr-selected': row.isSelected }">
        <td class="p-1 border-collapse border border-slate-400 text-center">{{  (pageId - 1) * 20 + index + 1 }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.code_so }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.post_index }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.settlement }}</td>
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
    }
  },
  methods: {
    rowClick(id, isSelected) {
      this.$emit('showActiveRow', { id: id, isSelected: !isSelected })
    },
  },
}
</script>