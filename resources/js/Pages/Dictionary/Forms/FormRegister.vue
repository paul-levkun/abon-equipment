<script setup>
import DictFormContent from "./../../../Layouts/DictFormContent.vue";
import InputLabel from "./../../../Components/InputLabel.vue";
import TextInput from "./../../../Components/TextInput.vue";
import TextArea from "./../../../Components/TextArea.vue";
import DropdownList from "./../../../Components/DropdownList.vue";
import List from "./../../../Components/List.vue";
import SecondaryButton from "./../../../Components/SecondaryButton";
import NavLink from "./../../../Components/NavLink";
import Checkbox from "./../../../Components/Checkbox";

// ref - це функція, яка надає можливість створювати реактивні змінні в Vue 3.
import { ref } from "vue";
const deletedDocs = ref([]);
</script>

<template>
  <!-- required -->
  <DictFormContent @submitForm="submitForm">
    <template #default>
      <div>
        <div class="flex flex-row mt-1">
          <div class="w-1/2 pr-1">
            <InputLabel for="sap_so" value="Структурна одиниця" />
            <DropdownList
              :invalid="isSapSoInvalid"
              @blur="clearValidity('sap_so')"
              id="sap_so"
              class="mt-1 w-full"
              :refArr="refSapSo"
              v-model="sap_so_id"
              @change="soChange"
            />
            <List :refArr="sapSoErrors"></List>
          </div>
          <div class="w-1/2 pl-1">
            <InputLabel for="sap_rem" value="Дільниця" />
            <DropdownList
              :invalid="isSapRemInvalid"
              @blur="clearValidity('sap_rem')"
              @change="changeVal"
              id="sap_rem"
              class="mt-1 w-full"
              :refArr="refSapRem"
              v-model="sap_rem_id"
            />
            <List :refArr="sapRemErrors"></List>
          </div>
        </div>

        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- ЕНЕРГООБ'ЄКТ -->
        <div class="my-3 text-lg font-bold border-b-4" :class="isEnObjectInvalid">
          <h2>Енергооб'єкт</h2>
        </div>
        <List :refArr="enObjectErrors"></List>

        <div class="flex flex-row mt-2 items-end">
          <div class="flex flex-row w-1/2 pr-1">
            <div class="w-1/2">
              <InputLabel for="object_code" value="Код" />
              <TextInput
                readonly
                @blur="clearValidity('en_object')"
                id="object_code"
                class="mt-1 w-full"
                v-model.trim="object_code"
                autofocus
              />
            </div>
          </div>
          <div class="w-1/2 ml-1" dir="rtl">
            <SecondaryButton
              @click.right.prevent="objectSelectChange"
              @click="objectSelect"
              @blur="clearValidity('en_object')"
              class="h-11 py-2"
              :disabled="rowId"
            >
              {{ object_select_title }}
            </SecondaryButton>
          </div>
        </div>
        <div class="flex flex-row mt-2 items-end">
          <div class="w-1/2 pr-1">
            <InputLabel for="object_name" value="Назва" />
            <TextArea
              readonly
              @blur="clearValidity('en_object')"
              id="object_name"
              rows="1"
              class="block mt-1 w-full"
              v-model.trim="object_name"
              autofocus
            ></TextArea>
          </div>
          <!-- <div class="w-1/4 pl-1">
            <InputLabel for="in_cds" value="Наявність в БД ЦДС" />
            <DropdownList @blur="clearValidity('en_object')"
              id="in_cds" class="mt-1 w-full" :refArr="refInCds" v-model="in_cds_id"/>
          </div> -->
          <div class="w-1/4 pl-1 pt-1">
            <InputLabel for="object_type" value="Тип" />
            <TextInput
              readonly
              id="object_type"
              class="mt-1 w-full"
              v-model.trim="refObjectType"
            />
          </div>
          <div class="w-1/4 ml-1" dir="rtl">
            <SecondaryButton
              @click="clickObjectDetail"
              class="h-11 py-2"
              @blur="clearValidity('en_object')"
              dir="ltr"
              :disabled="!substation_id && !line_id"
            >
              Детально&nbsp;<span v-if="isObjectDetail">&#9650;</span
              ><span v-else>&#9660;</span>
            </SecondaryButton>
          </div>
        </div>

        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->
        <div v-if="isObjectDetail" class="my-3 pb-2 bg-gray-200 detail">
          <div class="flex flex-row">
            <!-- <div class="w-1/4 pl-1 pt-1">
              <InputLabel for="object_type" value="Тип"/>
              <TextInput readonly
                id="object_type" class="mt-1 w-full" v-model.trim="refObjectType" />
            </div> -->
            <div class="w-1/4 px-1 pt-1">
              <InputLabel for="object_status" value="Статус" />
              <TextInput
                readonly
                id="object_status"
                class="mt-1 w-full"
                v-model.trim="object_status"
              />
            </div>
          </div>
          <div class="flex flex-row mt-2">
            <div class="w-1/2 px-1">
              <InputLabel for="object_settlement" value="Населений пункт" />
              <TextArea
                readonly
                id="object_settlement"
                rows="1"
                class="block mt-1 w-full"
                v-model.trim="object_settlement"
                autofocus
              ></TextArea>
            </div>
            <div class="w-1/2 px-1">
              <InputLabel for="object_street" value="Вулиця" />
              <TextArea
                readonly
                id="object_street"
                rows="1"
                class="block mt-1 w-full"
                v-model.trim="object_street"
                autofocus
              ></TextArea>
            </div>
          </div>
          <div v-if="substation_id" class="flex flex-row mt-2">
            <div class="w-1/4 pl-1">
              <InputLabel for="object_trans_number" value="Кількість трансформаторів" />
              <TextInput
                readonly
                id="object_trans_number"
                class="block mt-1 w-full"
                v-model.trim="object_trans_number"
                autofocus
              ></TextInput>
            </div>
            <div class="w-1/4 px-1">
              <InputLabel for="object_total_power" value="Сумарна потужність" />
              <TextInput
                readonly
                id="object_total_power"
                class="block mt-1 w-full"
                v-model.trim="object_total_power"
                autofocus
              ></TextInput>
            </div>
          </div>
          <div v-if="line_id" class="flex flex-row mt-2">
            <div class="w-1/4 pl-1">
              <InputLabel for="object_length_route" value="Довжина по трасі, км" />
              <TextInput
                readonly
                id="object_length_route"
                class="block mt-1 w-full"
                v-model.trim="object_length_route"
                autofocus
              ></TextInput>
            </div>
            <div class="w-1/4 px-1">
              <InputLabel for="object_power_poles" value="Кількість опор" />
              <TextInput
                readonly
                id="object_power_poles"
                class="block mt-1 w-full"
                v-model.trim="object_power_poles"
                autofocus
              ></TextInput>
            </div>
          </div>
        </div>
        <!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< -->

        <div class="flex flex-row mt-2">
          <div class="w-1/4 pr-0">
            <InputLabel for="location_type" value="Розміщення" />
            <DropdownList
              @blur="clearValidity('en_object')"
              @change="changeVal"
              id="location_type"
              class="mt-1 w-full"
              :refArr="refLocationType"
              v-model="location_type_id"
            />
          </div>
          <div class="w-1/4 px-1">
            <InputLabel for="line_section_type" value="Тип ділянки" />
            <DropdownList
              @blur="clearValidity('en_object')"
              @change="changeVal"
              id="line_section_type"
              class="mt-1 w-full"
              :refArr="refLineSectionType"
              v-model="line_section_type_id"
            />
          </div>
          <div class="w-1/4 px-1">
            <InputLabel for="tech_state_type" value="Технічний стан" />
            <DropdownList
              @blur="clearValidity('en_object')"
              @change="changeVal"
              id="tech_state_type"
              class="mt-1 w-full"
              :refArr="refTechStateType"
              v-model="tech_state_type_id"
            />
          </div>
          <div class="w-1/4 pl-0">
            <InputLabel for="cond_units" value="Умовні одиниці" />
            <TextInput
              :invalid="isCondUnitsInvalid"
              @blur="clearValidity('cond_units')"
              @change="changeVal"
              id="cond_units"
              class="mt-1 w-full"
              v-model.trim="cond_units"
              maxlength="8"
              autofocus
            />
            <List :refArr="condUnitsErrors"></List>
          </div>
        </div>
        <div class="flex flex-row mt-2">
          <div class="w-1/2 pr-1">
            <InputLabel
              for="contract_inexpediency_types"
              value="Недоцільність заключення договору"
            />
            <DropdownList
              id="contract_inexpediency_types"
              class="mt-1 w-full"
              :refArr="refContractInexpediencyType"
              v-model="contract_inexpediency_type_id"
              @change="changeVal"
            />
            <!-- <List :refArr="contractInexpediencyTypeErrors"></List> -->
          </div>
        </div>

        <div class="flex flex-row mt-2 items-end">
          <div class="w-3/4 pr-1">
            <InputLabel for="connected_object_name" value="Підключення до" />
            <TextArea
              readonly
              id="connected_object_name"
              rows="1"
              class="block mt-1 w-full"
              v-model.lazy.trim="connected_object_name"
              autofocus
            ></TextArea>
          </div>
          <div class="w-1/4 ml-1" dir="rtl">
            <SecondaryButton
              @click.right.prevent="connectedObjectSelectChange"
              @click="connectedObjectSelect"
              class="h-11 py-2"
            >
              {{ connected_object_select_title }}
            </SecondaryButton>
          </div>
        </div>

        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- ВЛАСНИК -->
        <div class="my-3 text-lg font-bold border-b-4" :class="isOwnerInvalid">
          <h2>Власник</h2>
        </div>
        <List :refArr="ownerErrors"></List>

        <div class="flex flex-row mt-2 items-end">
          <div class="flex flex-row w-1/2 pr-1">
            <div class="w-1/2">
              <InputLabel for="owner_code" value="ЄДРПОУ / ІПН" />
              <TextInput
                readonly
                @blur="clearValidity('owner')"
                id="owner_code"
                class="mt-1 w-full"
                v-model.trim="owner_code"
                autofocus
              />
            </div>
          </div>
          <div class="w-1/2 ml-1" dir="rtl">
            <SecondaryButton
              @click="ownerSelect"
              @blur="clearValidity('owner')"
              class="h-11 ml-1 py-2"
            >
              Вибрати власника
            </SecondaryButton>
          </div>
        </div>
        <div class="flex flex-row mt-2 items-end">
          <div class="w-1/2 pr-1">
            <InputLabel for="owner_name" value="Назва" />
            <TextArea
              readonly
              @blur="clearValidity('owner')"
              id="owner_name"
              rows="2"
              class="block mt-1 w-full"
              v-model.trim="owner_name"
              autofocus
            ></TextArea>
          </div>
          <div class="w-1/2 ml-1" dir="rtl">
            <SecondaryButton
              @click="clickOwnerDetail"
              @blur="clearValidity('owner')"
              class="h-11 py-2"
              dir="ltr"
              :disabled="!owner_id"
            >
              Детально&nbsp;<span v-if="isOwnerDetail">&#9650;</span
              ><span v-else>&#9660;</span>
            </SecondaryButton>
          </div>
        </div>

        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->
        <div v-if="isOwnerDetail" class="my-3 pb-2 bg-gray-200 detail">
          <!-- <p>Детальна інформація за власником</p> -->
          <div class="flex flex-row">
            <div class="w-1/4 pl-1 pt-1 pr-1">
              <InputLabel for="owner_type" value="Тип" />
              <TextInput
                readonly
                id="owner_type"
                class="mt-1 w-full"
                v-model.trim="refOwnerType"
              />
            </div>
          </div>
          <div class="flex flex-row mt-2">
            <div class="px-1 w-full">
              <InputLabel for="owner_properties" value="Реквізити" />
              <TextArea
                readonly
                id="owner_properties"
                rows="2"
                class="block mt-1 w-full"
                v-model.trim="owner_properties"
                autofocus
              ></TextArea>
            </div>
          </div>
          <div class="flex flex-row mt-2">
            <div class="px-1 w-full">
              <InputLabel for="owner_comments" value="Примітка" />
              <TextArea
                readonly
                id="owner_comments"
                rows="1"
                class="block mt-1 w-full"
                v-model.trim="owner_comments"
                autofocus
              ></TextArea>
            </div>
          </div>
        </div>
        <!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< -->

        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- ДОГОВІР -->
        <div class="my-3 text-lg font-bold border-b-4 text-gray-700 border-gray-700">
          <h2>Договір</h2>
        </div>

        <div class="flex flex-row mt-1">
          <div class="w-1/2 pr-1">
            <InputLabel for="contract_status_types" value="Статус" />
            <DropdownList
              @change="contractStatusTypeChange"
              id="contract_status_types"
              class="mt-1 w-full"
              :refArr="refContractStatusType"
              v-model="contract_status_type_id"
            />
          </div>
          <div class="w-1/2 ml-1" dir="rtl">
            <SecondaryButton @click="contractSelect" class="h-11 ml-1 py-2">
              Вибрати договір
            </SecondaryButton>
          </div>
        </div>

        <div class="flex flex-row mt-1">
          <div v-if="isContractType" class="w-1/2 pr-1">
            <InputLabel for="contract_types" value="Тип" />
            <DropdownList
              :invalid="contractTypeInvalid"
              @blur="clearValidity('contract_type')"
              @change="changeVal"
              id="contract_types"
              class="mt-1 w-full"
              :refArr="refContractType"
              v-model="contract_type_id"
            />
            <List :refArr="contractTypeErrors"></List>
          </div>
        </div>

        <div class="flex flex-row mt-1">
          <div v-if="isContractFailureType" class="w-1/2 pr-1">
            <InputLabel for="contract_failure_types" value="Відмова" />
            <DropdownList
              :invalid="contractFailureTypeInvalid"
              @blur="clearValidity('contract_failure_type')"
              @change="changeVal"
              id="contract_failure_types"
              class="mt-1 w-full"
              :refArr="refContractFailureType"
              v-model="contract_failure_type_id"
            />
            <List :refArr="contractFailureTypeErrors"></List>
          </div>
        </div>

        <!-- <div class="flex flex-row mt-1">
          <div v-if="isContractInexpediencyType" class="w-1/2 pr-1">
            <InputLabel for="contract_inexpediency_types" value="Недоцільність заключення договору" />
            <DropdownList :invalid="contractInexpediencyTypeInvalid" @blur="clearValidity('contract_inexpediency_type')"
              id="contract_inexpediency_types" class="mt-1 w-full" :refArr="refContractInexpediencyType" v-model="contract_inexpediency_type_id" /> 
            <List :refArr="contractInexpediencyTypeErrors"></List>
          </div>
        </div> -->

        <div class="flex flex-row mt-2 items-end">
          <div class="w-1/2 pr-1">
            <InputLabel for="contract_owner_name" value="Назва власника" />
            <TextArea
              readonly
              id="contract_owner_name"
              rows="2"
              class="block mt-1 w-full"
              v-model.trim="contract_owner_name"
              autofocus
            ></TextArea>
          </div>
        </div>

        <div class="flex flex-row mt-2 items-end">
          <div class="w-1/4 pr-0">
            <InputLabel for="contract_code" value="№ SAP договору" />
            <TextInput
              readonly
              id="contract_code"
              class="block mt-1 w-full"
              v-model.trim="contract_code"
              autofocus
            ></TextInput>
          </div>
          <div class="w-1/4 px-1">
            <InputLabel for="contract_start_date" value="Дата початку" />
            <TextInput
              readonly
              id="contract_start_date"
              class="block mt-1 w-full"
              v-model.trim="contract_start_date"
              autofocus
            ></TextInput>
          </div>
          <div class="w-1/4 px-1">
            <InputLabel for="contract_end_date" value="Дата завершення" />
            <TextInput
              readonly
              id="contract_end_date"
              class="block mt-1 w-full"
              v-model.trim="contract_end_date"
              autofocus
            ></TextInput>
          </div>
          <div class="w-1/4 ml-1" dir="rtl">
            <SecondaryButton
              @click="clickContractDetail"
              class="h-11 py-2"
              dir="ltr"
              :disabled="!contract_id"
            >
              Детально&nbsp;<span v-if="isContractDetail">&#9650;</span
              ><span v-else>&#9660;</span>
            </SecondaryButton>
          </div>
        </div>

        <!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->
        <div v-if="isContractDetail" class="my-3 pb-2 bg-gray-200 detail">
          <div class="flex flex-row">
            <div class="w-1/4 pl-1 pt-1">
              <InputLabel for="contract_amount" value="Сума договору, грн" />
              <TextInput
                readonly
                id="contract_amount"
                class="mt-1 w-full"
                v-model.trim="contract_amount"
              />
            </div>
            <div class="w-1/4 px-1 pt-1">
              <InputLabel for="payment_amount" value="Сума оплат, грн" />
              <TextInput
                readonly
                id="payment_amount"
                class="mt-1 w-full"
                v-model.trim="payment_amount"
              />
            </div>
            <div class="w-1/4 px-1 pt-1">
              <InputLabel for="sales_amount" value="Сума реалізації, грн" />
              <TextInput
                readonly
                id="sales_amount"
                class="mt-1 w-full"
                v-model.trim="sales_amount"
              />
            </div>
          </div>
        </div>
        <!-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< -->

        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- ДОКУМЕНТИ, ЗАВАНТАЖЕНІ НА СЕРВЕР -->
        <div class="mt-3 text-lg font-bold border-b-4 text-gray-700 border-gray-700">
          <h2>Документи, завантажені на сервер</h2>
        </div>

        <div>
          <div v-for="doc in documents" :key="doc.id" class="mx-3">
            <div
              v-if="doc.isTypeName"
              class="text-md font-bold border-b-2 text-gray-500 border-gray-500 mt-2"
            >
              <h2>{{ doc.typeName }}</h2>
            </div>
            <div class="flex flex-row mt-1 justify-between">
              <NavLink :href="doc.fileFullPath" active="true">{{ doc.fileName }}</NavLink>
              <Checkbox
                class="mt-1"
                label="Видалити файл"
                :fieldId="`chb_delete_${doc.id}`"
                v-model="deletedDocs"
                :value="doc"
                @change="changeVal"
              />
            </div>
          </div>
        </div>

        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
        <!-- ДОКУМЕНТИ, ДЛЯ ЗАВАНТАЖЕННЯ НА СЕРВЕР -->
        <div class="my-3 text-lg font-bold border-b-4" :class="isFtpInvalid">
          <h2>Документи для завантаження на сервер</h2>
        </div>
        <List :refArr="ftpErrors"></List>

        <div class="flex flex-row mt-1">
          <div class="w-1/2 pr-1">
            <InputLabel for="doc_type" value="Тип документа" />
            <DropdownList
              :invalid="hasDocsInvalid"
              @blur="clearValidity('has_docs')"
              @change="changeVal"
              id="doc_type"
              class="mt-1 w-full"
              :refArr="refDocType"
              v-model="doc_type_id"
            />
            <List :refArr="hasDocsErrors"></List>
          </div>
        </div>

        <div class="flex flex-row mt-3 items-center">
          <input
            type="file"
            name="file_docs[]"
            id="file_docs"
            class="focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-gray-900"
            accept="image/*,.zip,.7z,.rar,.arj,.pdf,.xls,.xlsx,.doc,.docx,.ppt,.pptx,.vsd"
            multiple
            style="color: red"
          />

          <SecondaryButton @click="clearFiles" class="h-11 ml-1 py-2">
            Очистити
          </SecondaryButton>
        </div>

        <div class="my-3 text-lg font-bold border-b-4 text-gray-700 border-gray-700">
          <h2>Загальна інформація</h2>
        </div>

        <InputLabel for="comment" value="Примітки" class="mt-2" />
        <TextArea
          id="comment"
          name="comment"
          rows="2"
          class="block mt-1 w-full"
          v-model.trim="comment"
          @change="changeVal"
          autofocus
        ></TextArea>
      </div>
    </template>
  </DictFormContent>
</template>

<script>
export default {
  emits: ["clearValidity"], // emits і не обовєязкове, працює і без нього )
  data() {
    return {
      object_select_title: "Вибрати підстанцію",
      object_select_id: 1,

      sap_so_id: "",
      sap_rem_id: "",
      location_type_id: "",
      line_section_type_id: "",
      tech_state_type_id: "",
      in_cds_id: "",
      cond_units: "",
      substation_id: "",
      line_id: "",
      owner_id: "",
      contract_id: "",
      connected_substation_id: "",
      connected_line_id: "",

      object_code: "",
      object_name: "",
      object_settlement: "",
      object_street: "",
      object_trans_number: "",
      object_total_power: "",
      object_length_route: "",
      object_power_poles: "",
      object_type_id: "",
      object_status: "",

      owner_code: "",
      owner_name: "",
      owner_properties: "",
      owner_comments: "",
      owner_type_id: "",

      doc_type_id: "",
      doc_type_name: "",

      contract_status_type_id: "",
      contract_type_id: "",
      contract_failure_type_id: "",
      contract_inexpediency_type_id: "",

      contract_code: "",
      contract_owner_name: "",
      contract_start_date: "",
      contract_end_date: "",
      contract_amount: "",
      payment_amount: "",
      sales_amount: "",

      isObjectDetail: false,
      isOwnerDetail: false,
      isContractDetail: false,

      comment: "",
      rowId: null,
      isFileDelete: true,

      // connected_object_select_title: "Вибрати підстанцію",
      // connected_object_select_id: 1,
      connected_object_select_title: "Вибрати лінію",
      connected_object_select_id: 2,
      connected_object_name: "",
    };
  },
  methods: {
    submitForm() {
      // console.log("deletedDocs", this.deletedDocs)

      let data = new FormData();
      data.append("id", "registers");
      data.append("sap_so_id", this.sap_so_id);
      data.append("sap_rem_id", this.sap_rem_id);

      // Додати дані з input type='file'
      let fileInput = document.getElementById("file_docs");
      for (let i = 0; i < fileInput.files.length; i++) {
        data.append("file_docs[]", fileInput.files[i]);
      }

      data.append("substation_id", this.substation_id);
      data.append("line_id", this.line_id);
      data.append("location_type_id", this.location_type_id);
      data.append("line_section_type_id", this.line_section_type_id);
      data.append("tech_state_type_id", this.tech_state_type_id);
      data.append("in_cds_id", this.in_cds_id);
      data.append("cond_units", this.cond_units.replace(",", "."));
      data.append("connected_substation_id", this.connected_substation_id);
      data.append("connected_line_id", this.connected_line_id);
      data.append("owner_id", this.owner_id);
      data.append("contract_id", this.contract_id);
      data.append("comment", this.comment ? this.comment : "");
      data.append("row_id", this.rowId);
      data.append("user_id", this.$store.getters["dictModule/userId"]);
      data.append("contract_status_type_id", this.contract_status_type_id);
      data.append("contract_type_id", this.contract_type_id);
      data.append("contract_failure_type_id", this.contract_failure_type_id);
      data.append("contract_inexpediency_type_id", this.contract_inexpediency_type_id);

      // Файли на видалення
      data.append("deleted_docs", JSON.stringify(this.deletedDocs));
      this.deletedDocs = ref([]);

      // Перевірка наявності типу документу для збереження
      data.append("doc_type_id", this.doc_type_id);
      data.append("has_docs", fileInput.files.length === 0 ? "" : fileInput.files.length);

      if (this.rowId) {
        data.append("_method", "put");
      }

      this.$store.dispatch("dictModule/storeDict", {
        id: "registers",
        oper: this.rowId ? "upd" : "add",
        data: data,
        row_id: this.rowId,
      });

      this.$store.commit("dictModule/setRegSapSoId", this.sap_so_id);
      this.$store.commit("dictModule/setRegSapRemId", this.sap_rem_id);

      this.$emit("clearValidity", "ftp");

      // this.clearFiles()
    },

    clearValidity(inputId) {
      this.$emit("clearValidity", inputId);
    },

    changeVal() {
      this.$store.commit("dictModule/setIsFormModified", 1);
    },

    objectSelectChange() {
      this.object_select_title =
        this.object_select_id === 1 ? "Вибрати лінію" : "Вибрати підстанцію";
      this.object_select_id = this.object_select_id === 1 ? 2 : 1;
    },
    objectSelect() {
      this.setInputBuffer();

      let this_id, this_title;
      if (this.object_select_id === 1) {
        this_id = "substations";
        this_title = "Підстанції";
      } else {
        this_id = "lines";
        this_title = "ЛЕП";
      }
      this.$store.dispatch("dictModule/showDict", {
        id: this_id,
        title: this_title,
        pageId: 1,
      });
    },
    ownerSelect() {
      this.setInputBuffer();

      const this_id = "owners";
      const this_title = "Власники";

      this.$store.dispatch("dictModule/showDict", {
        id: this_id,
        title: this_title,
        pageId: 1,
      });
    },
    contractSelect() {
      this.setInputBuffer();

      const this_id = "contracts";
      const this_title = "Договори";

      this.$store.dispatch("dictModule/showDict", {
        id: this_id,
        title: this_title,
        pageId: 1,
      });
    },
    connectedObjectSelectChange() {
      this.connected_object_select_title =
        this.connected_object_select_id === 1 ? "Вибрати лінію" : "Вибрати підстанцію";
      this.connected_object_select_id = this.connected_object_select_id === 1 ? 2 : 1;
    },
    connectedObjectSelect() {
      this.setInputBuffer();

      let this_id, this_title;
      if (this.connected_object_select_id === 1) {
        this_id = "connected_substations";
        this_title = "Підстанції";
      } else {
        this_id = "connected_lines";
        this_title = "ЛЕП";
      }
      this.$store.dispatch("dictModule/showDict", {
        id: this_id,
        title: this_title,
        pageId: 1,
      });
    },

    setInputBuffer() {
      const inputBuffer = {};
      // const retInputBuffer =
      Object.assign(inputBuffer, this.$store.getters["dictModule/formInputs"]); // (retInputBuffer === inputBuffer) === true
      inputBuffer["sap_so_id"] = this.sap_so_id;
      inputBuffer["sap_rem_id"] = this.sap_rem_id;
      inputBuffer["substation_id"] = this.substation_id;
      inputBuffer["line_id"] = this.line_id;
      inputBuffer["location_type_id"] = this.location_type_id;
      inputBuffer["line_section_type_id"] = this.line_section_type_id;
      inputBuffer["tech_state_type_id"] = this.tech_state_type_id;
      inputBuffer["in_cds_id"] = this.in_cds_id;
      inputBuffer["cond_units"] = this.cond_units;
      inputBuffer["connected_substation_id"] = this.connected_substation_id;
      inputBuffer["connected_line_id"] = this.connected_line_id;
      inputBuffer["owner_id"] = this.owner_id;
      inputBuffer["contract_id"] = this.contract_id;
      inputBuffer["contract_status_type_id"] = this.contract_status_type_id;
      inputBuffer["contract_type_id"] = this.contract_type_id;
      inputBuffer["contract_failure_type_id"] = this.contract_failure_type_id;
      inputBuffer["contract_inexpediency_type_id"] = this.contract_inexpediency_type_id;
      inputBuffer["doc_type_id"] = this.doc_type_id;
      inputBuffer["comment"] = this.comment;
      this.$store.commit("dictModule/setFormInputsBuffer", inputBuffer);

      this.$store.commit("dictModule/setIsDictRef", true);
    },

    clearValidity(inputId) {
      this.$emit("clearValidity", inputId);
    },
    clickObjectDetail() {
      this.isObjectDetail = !this.isObjectDetail;
    },
    clickOwnerDetail() {
      this.isOwnerDetail = !this.isOwnerDetail;
    },
    clickContractDetail() {
      this.isContractDetail = !this.isContractDetail;
    },

    soChange() {
      this.sap_rem_id = "";
      this.changeVal();
    },

    clearFiles() {
      let fileInput = document.getElementById("file_docs");
      fileInput.value = "";
    },

    contractStatusTypeChange() {
      this.contract_type_id = this.contract_failure_type_id = this.contract_inexpediency_type_id =
        "";
      this.changeVal();
    },
  },
  computed: {
    refSapSo() {
      // add
      if (Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0) {
        const soIdAuth = Number(this.$store.getters["dictModule/soIdAuth"]);
        this.sap_so_id =
          soIdAuth === 0 ? this.$store.getters["dictModule/regSapSoId"] ?? "" : soIdAuth;

        return this.$store.getters["dictModule/refSapSo"].filter((item) =>
          soIdAuth === 0 ? item.id !== 0 : item.id === soIdAuth
        );
      }
      // edit
      else {
        return this.$store.getters["dictModule/refSapSo"].filter((item) => {
          return item.id !== 0;
        });
      }
    },
    refSapRem() {
      if (Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0) {
        // add
        const soIdAuth = Number(this.$store.getters["dictModule/soIdAuth"]);
        if (soIdAuth === 0) {
          this.sap_rem_id = this.$store.getters["dictModule/regSapRemId"] ?? "";
          return this.$store.getters["dictModule/refSapRem"].filter(
            (item) => item.id === "" || item.so_id === Number(this.sap_so_id)
          );
        } else {
          const remIdAuth = Number(this.$store.getters["dictModule/remIdAuth"]);
          if (remIdAuth === 0) {
            this.sap_rem_id = this.$store.getters["dictModule/regSapRemId"] ?? "";
            return this.$store.getters["dictModule/refSapRem"].filter(
              (item) => item.id === "" || item.so_id === Number(this.sap_so_id)
            );
          } else {
            this.sap_rem_id = remIdAuth;
            return this.$store.getters["dictModule/refSapRem"].filter(
              (item) => item.id === remIdAuth
            );
          }
        }
      } else {
        // edit
        return this.$store.getters["dictModule/refSapRem"].filter((item) => {
          return item.id === "" || item.so_id === Number(this.sap_so_id);
        });
      }
    },
    refLocationType() {
      return this.$store.getters["dictModule/refLocationType"];
    },
    refLineSectionType() {
      return this.$store.getters["dictModule/refLineSectionType"];
    },
    refTechStateType() {
      return this.$store.getters["dictModule/refTechStateType"];
    },
    refInCds() {
      const arrInCds = [
        { id: "", name: "Оберіть значення" },
        { id: "1", name: "Так" },
        { id: "2", name: "Ні" },
      ];
      return arrInCds;
    },
    refContractType() {
      return this.$store.getters["dictModule/refContractType"].filter(
        (item) => item.id !== 0
      );
    },
    refObjectType() {
      if (this.$store.getters["dictModule/refObjectType"]) {
        return this.object_type_id
          ? this.$store.getters["dictModule/refObjectType"].find(
              (item) => item.id === this.object_type_id
            ).name
          : "";
      }
      return "";
    },
    refOwnerType() {
      return this.owner_type_id
        ? this.$store.getters["dictModule/refOwnerType"].find(
            (item) => item.id === this.owner_type_id
          ).name
        : "";
    },
    refDocType() {
      return this.$store.getters["dictModule/refDocType"];
    },
    refContractFailureType() {
      return this.$store.getters["dictModule/refContractFailureType"].filter(
        (item) => item.id !== 0
      );
    },
    refContractStatusType() {
      return this.$store.getters["dictModule/refContractStatusType"].filter(
        (item) => item.id !== 0
      );
    },
    refContractInexpediencyType() {
      return this.$store.getters["dictModule/refContractInexpediencyType"].filter(
        (item) => item.id !== 0
      );
    },

    isSapSoInvalid() {
      return this.$store.getters["dictModule/formErrors"]["sap_so"] !== undefined;
    },
    sapSoErrors() {
      return this.$store.getters["dictModule/formErrors"]["sap_so"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["sap_so"];
    },
    isSapRemInvalid() {
      return this.$store.getters["dictModule/formErrors"]["sap_rem"] !== undefined;
    },
    sapRemErrors() {
      return this.$store.getters["dictModule/formErrors"]["sap_rem"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["sap_rem"];
    },
    isEnObjectInvalid() {
      return this.$store.getters["dictModule/formErrors"]["en_object"] !== undefined
        ? "text-red-700 border-red-700"
        : "text-gray-700 border-gray-700";
    },
    enObjectErrors() {
      return this.$store.getters["dictModule/formErrors"]["en_object"] === undefined
        ? []
        : [this.$store.getters["dictModule/formErrors"]["en_object"][0]];
    },
    isOwnerInvalid() {
      return this.$store.getters["dictModule/formErrors"]["owner"] !== undefined
        ? "text-red-700 border-red-700"
        : "text-gray-700 border-gray-700";
    },
    ownerErrors() {
      return this.$store.getters["dictModule/formErrors"]["owner"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["owner"];
    },
    isCondUnitsInvalid() {
      return this.$store.getters["dictModule/formErrors"]["cond_units"] !== undefined;
    },
    condUnitsErrors() {
      return this.$store.getters["dictModule/formErrors"]["cond_units"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["cond_units"];
    },
    hasDocsInvalid() {
      return this.$store.getters["dictModule/formErrors"]["has_docs"] !== undefined;
    },
    hasDocsErrors() {
      return this.$store.getters["dictModule/formErrors"]["has_docs"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["has_docs"];
    },
    contractTypeInvalid() {
      return this.$store.getters["dictModule/formErrors"]["contract_type"] !== undefined;
    },
    contractTypeErrors() {
      return this.$store.getters["dictModule/formErrors"]["contract_type"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["contract_type"];
    },
    contractFailureTypeInvalid() {
      return (
        this.$store.getters["dictModule/formErrors"]["contract_failure_type"] !==
        undefined
      );
    },
    contractFailureTypeErrors() {
      return this.$store.getters["dictModule/formErrors"]["contract_failure_type"] ===
        undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["contract_failure_type"];
    },
    contractInexpediencyTypeInvalid() {
      return (
        this.$store.getters["dictModule/formErrors"]["contract_inexpediency_type"] !==
        undefined
      );
    },
    contractInexpediencyTypeErrors() {
      return this.$store.getters["dictModule/formErrors"][
        "contract_inexpediency_type"
      ] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["contract_inexpediency_type"];
    },

    isFtpInvalid() {
      return this.$store.getters["dictModule/formErrors"]["ftp"] !== undefined
        ? "text-red-700 border-red-700"
        : "text-gray-700 border-gray-700";
    },
    ftpErrors() {
      return this.$store.getters["dictModule/formErrors"]["ftp"] === undefined
        ? []
        : this.$store.getters["dictModule/formErrors"]["ftp"];
    },

    isContractType() {
      return this.contract_status_type_id == 1;
    },
    isContractFailureType() {
      return this.contract_status_type_id == 2;
    },
    isContractInexpediencyType() {
      return this.contract_status_type_id == 3;
    },

    addSaved() {
      return this.$store.getters["dictModule/addSaved"];
    },
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
          typeName: docType.name,
          isTypeName: isTypeName,
        };
      });
    },
  },
  watch: {
    addSaved(newVal, oldVal) {
      if (newVal) {
        console.log("add SAVED!");
        console.log(newVal);

        this.location_type_id = this.line_section_type_id = this.tech_state_type_id = this.in_cds_id =
          "";
        this.cond_units = this.substation_id = this.line_id = this.connected_substation_id = this.connected_line_id =
          "";
        this.owner_id = this.contract_id = this.object_code = this.object_name = this.object_settlement =
          "";
        this.object_street = this.object_trans_number = this.object_total_power = this.object_length_route =
          "";
        this.object_power_poles = this.object_type_id = this.object_status = this.connected_object_name =
          "";
        this.owner_code = this.owner_name = this.owner_properties = this.owner_comments = this.owner_type_id =
          "";
        this.contract_code = this.contract_owner_name = this.contract_start_date = this.contract_end_date =
          "";
        this.contract_amount = this.payment_amount = this.sales_amount = this.contract_status_type_id =
          "";
        this.contract_type_id = this.contract_failure_type_id = this.contract_inexpediency_type_id = this.comment =
          "";

        this.isObjectDetail = this.isOwnerDetail = this.isContractDetail = false;
      }
    },
  },

  created() {
    this.$store.dispatch("dictModule/setRef", { id: "sap_sos" });
    this.$store.dispatch("dictModule/setRef", { id: "sap_rems" });
    this.$store.dispatch("dictModule/setRef", { id: "location_types" });
    this.$store.dispatch("dictModule/setRef", { id: "line_section_types" });
    this.$store.dispatch("dictModule/setRef", { id: "tech_state_types" });
    this.$store.dispatch("dictModule/setRef", { id: "object_types" });
    this.$store.dispatch("dictModule/setRef", { id: "owner_types" });
    this.$store.dispatch("dictModule/setRef", { id: "doc_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_status_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_failure_types" });
    this.$store.dispatch("dictModule/setRef", { id: "contract_inexpediency_types" });
  },
  mounted() {
    console.log("dictModule/formInputs", this.$store.getters["dictModule/formInputs"]);
    if (Object.keys(this.$store.getters["dictModule/formInputs"]).length === 0) {
      this.sap_so_id = this.$store.getters["dictModule/regSapSoId"];
      this.sap_rem_id = this.$store.getters["dictModule/regSapRemId"];

      console.log("Add record ° ", this.sap_so_id, this.sap_rem_id);

      this.rowId = null;
    } else {
      console.log("Update record ° ");

      this.rowId = this.$store.getters["dictModule/formInputs"].id;
      this.sap_so_id = this.$store.getters["dictModule/formInputs"].sap_so_id;
      this.sap_rem_id = this.$store.getters["dictModule/formInputs"].sap_rem_id;
      this.substation_id = this.$store.getters["dictModule/formInputs"].substations
        ? this.$store.getters["dictModule/formInputs"].substations.id
        : "";
      this.line_id = this.$store.getters["dictModule/formInputs"].lines
        ? this.$store.getters["dictModule/formInputs"].lines.id
        : "";

      // Об'єкт
      if (this.$store.getters["dictModule/formInputs"].substations) {
        this.object_code = this.$store.getters["dictModule/formInputs"].substations.code;
        this.object_name = this.$store.getters["dictModule/formInputs"].substations.name;
        this.object_settlement = this.$store.getters[
          "dictModule/formInputs"
        ].substations.settlement;
        this.object_street = this.$store.getters[
          "dictModule/formInputs"
        ].substations.street;
        this.object_trans_number =
          this.$store.getters["dictModule/formInputs"].substations.trans_number ?? "";
        this.object_total_power =
          this.$store.getters["dictModule/formInputs"].substations.total_power ?? "";
        this.object_type_id =
          this.$store.getters["dictModule/formInputs"].substations.object_type_id ?? "";
        this.object_status =
          this.$store.getters["dictModule/formInputs"].substations.status ?? "";
      } else if (this.$store.getters["dictModule/formInputs"].lines) {
        this.object_code = this.$store.getters["dictModule/formInputs"].lines.code;
        this.object_name = this.$store.getters["dictModule/formInputs"].lines.name;
        this.object_settlement = this.$store.getters[
          "dictModule/formInputs"
        ].lines.settlement;
        this.object_street = this.$store.getters["dictModule/formInputs"].lines.street;
        this.object_length_route =
          this.$store.getters["dictModule/formInputs"].lines.line_length_route ?? "";
        this.object_power_poles =
          this.$store.getters["dictModule/formInputs"].lines.number_of_power_poles ?? "";
        this.object_type_id =
          this.$store.getters["dictModule/formInputs"].lines.object_type_id ?? "";
        this.object_status =
          this.$store.getters["dictModule/formInputs"].lines.status ?? "";
      }

      // Підключення до
      if (this.$store.getters["dictModule/formInputs"].connected_substations) {
        const connected_object_code = this.$store.getters["dictModule/formInputs"]
          .connected_substations.code;
        const connected_object_name = this.$store.getters["dictModule/formInputs"]
          .connected_substations.name;
        this.connected_object_name = connected_object_code + " " + connected_object_name;
        this.connected_substation_id = this.$store.getters[
          "dictModule/formInputs"
        ].connected_substations.id;
      } else if (this.$store.getters["dictModule/formInputs"].connected_lines) {
        const connected_object_code = this.$store.getters["dictModule/formInputs"]
          .connected_lines.code;
        const connected_object_name = this.$store.getters["dictModule/formInputs"]
          .connected_lines.name;
        this.connected_object_name = connected_object_code + " " + connected_object_name;
        this.connected_line_id = this.$store.getters[
          "dictModule/formInputs"
        ].connected_lines.id;
      }

      // Власник
      this.owner_id = this.$store.getters["dictModule/formInputs"].owners
        ? this.$store.getters["dictModule/formInputs"].owners.id
        : "";
      this.owner_code = this.$store.getters["dictModule/formInputs"].owners
        ? this.$store.getters["dictModule/formInputs"].owners.ab_inn
        : "";
      this.owner_name = this.$store.getters["dictModule/formInputs"].owners
        ? this.$store.getters["dictModule/formInputs"].owners.name
        : "";
      this.owner_type_id = this.$store.getters["dictModule/formInputs"].owners
        ? this.$store.getters["dictModule/formInputs"].owners.id_type_owner
        : "";
      this.owner_properties = this.$store.getters["dictModule/formInputs"].owners
        ? this.$store.getters["dictModule/formInputs"].owners.recvisit ?? ""
        : "";
      this.owner_comments = this.$store.getters["dictModule/formInputs"].owners
        ? this.$store.getters["dictModule/formInputs"].owners.comments ?? ""
        : "";
      this.contract_status_type_id =
        this.$store.getters["dictModule/formInputs"].contract_status_type_id ?? "";
      this.contract_type_id =
        this.$store.getters["dictModule/formInputs"].contract_type_id ?? "";
      this.contract_failure_type_id =
        this.$store.getters["dictModule/formInputs"].contract_failure_type_id ?? "";
      this.contract_inexpediency_type_id =
        this.$store.getters["dictModule/formInputs"].contract_inexpediency_type_id ?? "";

      // Договір
      if (this.$store.getters["dictModule/formInputs"].contracts) {
        this.contract_id = this.$store.getters["dictModule/formInputs"].contracts.id;
        this.contract_code = this.$store.getters["dictModule/formInputs"].contracts.code;
        this.contract_owner_name = this.$store.getters[
          "dictModule/formInputs"
        ].contracts.owner_name;
        this.contract_start_date = this.$store.getters[
          "dictModule/formInputs"
        ].contracts.start_date;
        this.contract_end_date = this.$store.getters[
          "dictModule/formInputs"
        ].contracts.end_date;
        this.contract_amount = this.$store.getters[
          "dictModule/formInputs"
        ].contracts.contract_amount;
        this.payment_amount = this.$store.getters[
          "dictModule/formInputs"
        ].contracts.payment_amount;
        this.sales_amount = this.$store.getters[
          "dictModule/formInputs"
        ].contracts.sales_amount;
      } else {
        this.contract_id = this.contract_code = this.contract_start_date = this.contract_end_date = this.contract_owner_name = this.contract_amount = this.payment_amount = this.sales_amount =
          "";
      }

      // Об'єкт додатково
      this.location_type_id =
        this.$store.getters["dictModule/formInputs"].location_type_id ?? "";
      this.line_section_type_id =
        this.$store.getters["dictModule/formInputs"].line_section_type_id ?? "";
      this.tech_state_type_id =
        this.$store.getters["dictModule/formInputs"].tech_state_type_id ?? "";
      this.in_cds_id = this.$store.getters["dictModule/formInputs"].in_cds_id ?? "";
      this.cond_units = this.$store.getters["dictModule/formInputs"].cond_units ?? "";

      // Документи;
      const dict_id = "documents";
      this.$store.dispatch("dictModule/updateDocs", { id: dict_id, row_id: this.rowId });

      // Загальне
      this.comment = this.$store.getters["dictModule/formInputs"].comment ?? "";
    }

    console.log(
      "dictModule/AuthAuthAuth",
      this.$store.getters["dictModule/userId"],
      this.$store.getters["dictModule/soIdAuth"],
      this.$store.getters["dictModule/remIdAuth"]
    );
  },
};
</script>

<style>
.detail {
  animation: detail 0.5s ease-out forwards;
}

@keyframes detail {
  from {
    opacity: 0;
    transform: scale(0%);
  }
  to {
    opacity: 1;
    transform: scale(100%);
  }
}
</style>
