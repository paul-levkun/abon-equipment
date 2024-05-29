<script setup>
import DictGridContent from "./../../../Layouts/DictGridContent.vue";
import SecondaryButton from "./../../../Components/SecondaryButton";
</script>

<template>
  <DictGridContent
    :clickedRow="clickedRow"
    :doc-reg-id="docRegId"
    :is-doc-list="isDocList"
    @delete-click-reset="deleteClickReset"
  >
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
          SAP код
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Назва абон. обладнання
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Тип об'єкта
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Підключення до
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Недоцільність закл. договору
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Дебітор
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          ЄДРПОУ / IПН
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Назва власника
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Статус договору
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Відмова
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Тип договору
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          № SAP договору
        </th>
        <th
          class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300"
          title="Сума договору, грн&#10;Сума оплат, грн&#10;Сума реалізації, грн"
        >
          Сума Д/О/Р, грн
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Умовні одиниці
        </th>
        <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Кількість документів
        </th>
        <!-- <th class="sticky top-0 p-2 border-collapse border border-slate-400 bg-slate-300">
          Примітка
        </th> -->
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
        <!-- <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.sap_sos.name }} <br/> {{ row.sap_rems.name }}</td> -->
        <td class="p-1 border-collapse border border-slate-400 text-center">
          <b
            ><p>{{ row.sap_sos ? row.sap_sos.name : 'Всі АТ "ВОЕ"' }}</p></b
          >
          <p>{{ row.sap_rems ? row.sap_rems.name : "" }}</p>
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.substations ? row.substations.code : row.lines ? row.lines.code : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.substations ? row.substations.name : row.lines ? row.lines.name : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{
            row.substations
              ? row.substations.object_types.name
              : row.lines
              ? row.lines.object_types.name
              : ""
          }}
        </td>

        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{
            row.connected_substations
              ? row.connected_substations.code + " " + row.connected_substations.name
              : row.connected_lines
              ? row.connected_lines.code + " " + row.connected_lines.name
              : ""
          }}
        </td>

        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{
            row.contract_inexpediency_types
              ? !row.contract_inexpediency_types.name ||
                row.contract_inexpediency_types.name === "Невизначено"
                ? ""
                : row.contract_inexpediency_types.name
              : ""
          }}
        </td>

        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.owners ? row.owners.sap_code : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.owners ? row.owners.ab_inn : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.owners ? row.owners.name : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{
            row.contract_status_types
              ? !row.contract_status_types.name ||
                row.contract_status_types.name === "Невизначено"
                ? ""
                : row.contract_status_types.name
              : ""
          }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.contract_failure_types ? row.contract_failure_types.name : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.contract_types ? row.contract_types.name : "" }}
        </td>
        <td class="p-1 border-collapse border border-slate-400 text-center">
          {{ row.contracts ? row.contracts.code : "" }}
        </td>

        <td
          class="px-2 py-1 border-collapse border border-slate-400 text-right"
          v-html="
            row.contracts
              ? row.contracts.contract_amount +
                '<br>' +
                row.contracts.payment_amount +
                '<br>' +
                row.contracts.sales_amount
              : ''
          "
        ></td>

        <td class="px-2 py-1 border-collapse border border-slate-400 text-right">
          {{ row.cond_units }}
        </td>

        <td class="px-2 py-1 border-collapse border border-slate-400 text-center">
          <SecondaryButton
            class="text-base"
            @click="docShow(row.id, row.documents_count)"
            @mouseup="docShowReset"
            >{{ row.documents_count }}</SecondaryButton
          >
        </td>

        <!-- <td class="p-1 border-collapse border border-slate-400">
          {{ row.comment }}
        </td> -->
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
      docRegId: null,
      isDocList: false,
    };
  },
  methods: {
    rowClick(id, isSelected) {
      this.clickedRow.id = id;
      this.clickedRow.isSelected = !isSelected;
      this.$emit("showActiveRow", this.clickedRow);
    },
    docShow(id, doc_count) {
      // console.log(id);
      if (doc_count) {
        this.docRegId = id;
        this.isDocList = true;
      }
    },
    docShowReset() {
      this.isDocList = false;
    },
    deleteClickReset() {
      this.clickedRow.isSelected = false;
      this.$emit("showActiveRow", this.clickedRow);
    },
  },
  computed: {},
};
</script>
