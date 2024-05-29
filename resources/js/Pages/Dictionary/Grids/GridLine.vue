<script setup>
import DictGridContent from "./../../../Layouts/DictGridContent.vue";
</script>

<template>
  <DictGridContent :clickedRow="clickedRow">
    <template #thead>
      <tr>
        <th
          class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300 w-20"
        >
          № з/п
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          СО / Дільниця
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Функціональне розташування
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Назва
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Тип об'єкта
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Нас. пункт
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Вулиця
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Статус
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Інв.№
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Осн. засіб
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Дата експл.
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Довжина по трасі, км
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Кількість опор
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
        <td class="p-1 border-collapse border border-slate-400 text-center">
          <b
            ><p>{{ row.sap_sos ? row.sap_sos.name : 'Всі АТ "ВОЕ"' }}</p></b
          >
          <p>{{ row.sap_rems ? row.sap_rems.name : "" }}</p>
        </td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.code }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.name }}</td>
        <!-- <td class="p-1 border-collapse border border-slate-400 text-center">{{ row.object_types.name }}</td> -->
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.object_types ? row.object_types.name : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.settlement }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.street }}</td>
        <td class="p-1 border-collapse border border-slate-400">{{ row.status }}</td>
        <td class="p-1 border-collapse border border-slate-400">
          {{ row.inventory_number }}
        </td>
        <td class="p-1 border-collapse border border-slate-400">
          {{ row.asset_number }}
        </td>
        <td class="p-1 border-collapse border border-slate-400">
          {{ row.exploitation_date }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-right">
          {{ row.line_length_route }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-right">
          {{ row.number_of_power_poles }}
        </td>
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
  },
  computed: {},
};
</script>
