import mutations from "./mutations";
import actions from "./actions";
import getters from "./getters";

export default {
  namespaced: true,
  state() {
    return {
      dicts: [
        {
          id: 'sap_sos',
          title: 'Структурні одиниці SAP',
          description:
            'Довідник "Структурні одиниці АТ ВОЕ системи SAP"',
        },
        {
          id: 'sap_rems',
          title: 'Дільниці SAP',
          description:
            'Довідник "Дільниці АТ ВОЕ системи SAP"',
        },
        // {
        //   id: 'rems',
        //   title: 'Структурні одиниці',
        //   description:
        //     'Довідник "Структурні одиниці АТ \'ВОЕ\'"',
        // },
        {
          id: 'owner_types',
          title: 'Типи власників',
          description:
            'Довідник "Типи власників абонентського обладнання"',
        },
        {
          id: 'users',
          title: 'Users',
          description:
            'Довідник "Users"',
        },
        // {
        //   id: 'equipment_types',
        //   title: 'Типи абонентського обладнання',
        //   description:
        //     'Довідник "Типи абонентського обладнання"',
        // },
        // {
        //   id: 'voltage_classes',
        //   title: 'Класи напруги',
        //   description:
        //     'Довідник "Класи напруги абонентського обладнання"',
        // },
        {
          id: 'object_types',
          title: "Типи об'єктів SAP",
          description:
            "Довідник \"Типи об'єктів SAP\"",
        },
        {
          id: 'location_types',
          title: 'Типи розміщення',
          description:
            'Довідник "Типи розміщення абонентського обладнання"',
        },
        {
          id: 'tech_state_types',
          title: 'Типи технічного стану об’єктів електричних мереж напругою 0,4- 20 кВ',
          description:
            'Довідник "Типи технічного стану об’єктів електричних мереж напругою 0,4-20 кВ"',
        },
        {
          id: 'line_section_types',
          title: 'Типи ділянки',
          description:
            'Довідник "Типи ділянки абонентського обладнання"',
        },
        // {
        //   id: 'line_types',
        //   title: 'Типи ЛЕП',
        //   description:
        //     'Довідник "Типи ліній електропередач абонентського обладнання"',
        // },
        {
          id: 'doc_types',
          title: 'Типи документів',
          description:
            'Довідник "Типи документів абонентського обладнання"',
        },
        {
          id: 'contract_status_types',
          title: 'Статуси договорів',
          description:
            'Довідник "Статуси договорів на обслуговування абонентського обладнання"',
        },
        {
          id: 'contract_types',
          title: 'Типи договорів',
          description:
            'Довідник "Типи договорів на обслуговування абонентського обладнання"',
        },
        {
          id: 'contract_failure_types',
          title: 'Причини відмов власників абонентського обладнання',
          description:
            'Довідник "Причини відмов власників абонентського обладнання від договорів на обслуговування"',
        },
        {
          id: 'contract_inexpediency_types',
          title: 'Недоцільності заключення договорів',
          description:
            'Довідник "Недоцільності заключення договорів на обслуговування абонентського обладнання"',
        },
      ],
      regs: [
        {
          id: 'registers',
          title: 'Абонентське обладнання',
          description:
            'Реєстр "Абонентське обладнання АТ \'ВОЕ\'"',
        },
        {
          id: 'owners',
          title: 'Власники',
          description:
            'Реєстр "Власники абонентського обладнання"',
        },
        {
          id: 'substations',
          title: 'Підстанції SAP',
          description:
            'Реєстр "Високовольтні (35-110 кВ) та трансформаторні (6-10-20 кВ) підстанції системи SAP"',
        },
        {
          id: 'lines',
          title: 'ЛЕП SAP',
          description:
            'Реєстр "Повітряні та кабельні лінії електропередачі (6-10-20-35-110 кВ) системи SAP"',
        },
        {
          id: 'contracts',
          title: 'Договори ОТО SAP',
          description:
            'Реєстр "Договори на оперативно-технічне обслуговування SAP"',
        },
      ],
      reps: [
        {
          id: 'ao_detail1', // ao_summary1
          title: 'Абонентське обладнання (детально)',
          description:
            'Звіт "Абонентське обладнання / МСР - Малі Системи Розподілу (детально)"',
        },
        {
          id: 'ao_detail2', // ao_summary1
          title: 'Абонентське обладнання (документи)',
          description:
            'Звіт "Абонентське обладнання / МСР - Малі Системи Розподілу (документи)"',
        },
      ],
      currentDictId: "",
      currentDictTitle: "",
      currentDictPageId: "",
      currentDict: [],
      currentDictRCount: 0,
      currentDictPageSize: 20,
      isLoading: false,
      refOwnerType: [],
      refSapSo: [],
      refSapRem: [],
      refSapBo: [],
      refLocationType: [],
      refLineSectionType: [],
      refTechStateType: [],
      refOblectType: [],
      refStatusType: [],
      refDocType: [],
      refDocument: [],
      refContractType: [],
      refContractFailureType: [],
      refContractStatusType: [],
      refContractInexpediencyType: [],
      formInputs: {},
      formErrors: {},
      filterOwnerParams: {},
      filterSubstationParams: {},
      filterLineParams: {},
      filterRegisterParams: {},
      filterContractParams: {},
      filterConnectedSubstationParams: {},
      filterConnectedLineParams: {},
      isDictRef: "",
      formInputsBuffer: {},
      forcedDownload: true,
      regSapSoId: "",
      regSapRemId: "",
      addSaved: false,
      updateSaved: false,
      errorSaved: false,

      bufferDictId: "registers",
      bufferDictTitle: "Абонентське обладнанння",
      bufferDictPageId: "",

      // Аутентифікація/авторизація
      userId: "",
      userName: "",
      soIdAuth: "",
      remIdAuth: "",
      boIdAuth: "",

      structName: "",
      structMode: "",

      allowRoute: true,

      formMode: null,
      isFormModified: 0,
   }
  },
  mutations,
  actions,
  getters
}