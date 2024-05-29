<script setup>
  import DictGridContent from './../../../Layouts/DictGridContent.vue';
</script>

<template>
  <DictGridContent :clickedRow="clickedRow">
    <template #thead>
      <tr>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300 w-20">№ з/п</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">№ SAP договору</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">БО</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Власник</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">ЄДРПОУ / ІПН</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Дата початку</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Дата завершення</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Сума договору, грн</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Сума оплат, грн</th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">Сума реалізації, грн</th>
      </tr>
    </template>

    <template #tbody="{ currentDict, pageId }">
      <tr v-for="(row, index) in currentDict" :key="row.id" class="bg-white tr" 
          @click="rowClick(row.id, row.isSelected)" 
          :class="{ 'tr-selected': row.isSelected }">
        <td class="p-1 border-collapse border border-slate-400 text-center">{{ (pageId - 1) * 20 + index + 1 }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.code }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.sap_bos ? row.sap_bos.code_bo + " " + row.sap_bos.name : "" }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.owners ? row.owners.name : "" }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.owners ? row.owners.ab_inn : "" }}</td>
        <td class="p-1 border-collapse border border-slate-400 text-center">{{ row.start_date }}</td>
        <td class="p-1 border-collapse border border-slate-400 text-center">{{ row.end_date }}</td>
        <td class="py-1 px-2 border-collapse border border-slate-400 text-right">{{ row.contract_amount }}</td>
        <td class="py-1 px-2 border-collapse border border-slate-400 text-right">{{ row.payment_amount }}</td>
        <td class="py-1 px-2 border-collapse border border-slate-400 text-right">{{ row.sales_amount }}</td>
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
      this.clickedRow.id = id
      this.clickedRow.isSelected = !isSelected
      this.$emit('showActiveRow', this.clickedRow)
    },

  },
  computed: {
  },
  mounted() {
  }
}
</script>
