export default {
  dicts(state) {
    return state.dicts
  },
  regs(state) {
    return state.regs
  },
  reps(state) {
    return state.reps
  },
  currentDictId(state) {
    if (!state.currentDictId) { 
      if (sessionStorage['currentDictId']) {
        state.currentDictId = sessionStorage['currentDictId']
      }
    }
    return state.currentDictId
  },
  currentDictTitle(state) {
    if (!state.currentDictTitle) { 
      if (sessionStorage['currentDictTitle']) {
        state.currentDictTitle = sessionStorage['currentDictTitle']
      }
    }
    return state.currentDictTitle
  },
  currentDictPageId(state) {
    if (!state.currentDictPageId) { 
      state.currentDictPageId = sessionStorage['currentDictPageId'] ? sessionStorage['currentDictPageId'] : 1
    }
    return state.currentDictPageId
  },
  currentDict(state) {
    return state.currentDict
  },
  currentDictRCount(state) {
    return state.currentDictRCount
  },
  currentDictPageSize(state) {
    return state.currentDictPageSize
  },
  isLoading(state) {
    return state.isLoading
  },
  refRem(state) {
    return state.refRem
  },
  refOwnerType(state) {
    return state.refOwnerType
  },
  refSapSo(state) {
    return state.refSapSo
  },
  refSapRem(state) {
    return state.refSapRem
  },
  refSapBo(state) {
    return state.refSapBo
  },
  refLocationType(state) {
    return state.refLocationType
  },
  refLineSectionType(state) {
    return state.refLineSectionType
  },
  refTechStateType(state) {
    return state.refTechStateType
  },
  refContractType(state) {
    return state.refContractType
  },
  refObjectType(state) {
    return state.refObjectType
  },
  refStatusType(state) {
    return state.refStatusType
  },
  refDocType(state) {
    return state.refDocType
  },
  refDocument(state) {
    return state.refDocument
  },
  refContractFailureType(state) {
    return state.refContractFailureType
  },
  refContractStatusType(state) {
    return state.refContractStatusType
  },
  refContractInexpediencyType(state) {
    return state.refContractInexpediencyType
  },
  formInputs(state) {
    if (Object.keys(state.formInputs).length === 0) { 
      if (sessionStorage['formInputs']) {
        state.formInputs = JSON.parse(sessionStorage['formInputs'])
      }
    }
    return state.formInputs
  },
  formErrors(state) {
    return state.formErrors
  },
  filterOwnerParams(state) {
    if (Object.keys(state.filterOwnerParams).length === 0) { 
      if (sessionStorage['filterOwnerParams']) {
        state.filterOwnerParams = JSON.parse(sessionStorage['filterOwnerParams'])
      }
    }
    return state.filterOwnerParams
  },
  filterSubstationParams(state) {
    if (Object.keys(state.filterSubstationParams).length === 0) { 
      if (sessionStorage['filterSubstationParams']) {
        state.filterSubstationParams = JSON.parse(sessionStorage['filterSubstationParams'])
      }
    }
    return state.filterSubstationParams
  },
  filterLineParams(state) {
    if (Object.keys(state.filterLineParams).length === 0) { 
      if (sessionStorage['filterLineParams']) {
        state.filterLineParams = JSON.parse(sessionStorage['filterLineParams'])
      }
    }
    return state.filterLineParams
  },
  filterRegisterParams(state) {
    if (Object.keys(state.filterRegisterParams).length === 0) { 
      if (sessionStorage['filterRegisterParams']) {
        state.filterRegisterParams = JSON.parse(sessionStorage['filterRegisterParams'])
      }
    }
    return state.filterRegisterParams
  },
  filterContractParams(state) {
    if (Object.keys(state.filterContractParams).length === 0) { 
      if (sessionStorage['filterContractParams']) {
        state.filterContractParams = JSON.parse(sessionStorage['filterContractParams'])
      }
    }
    return state.filterContractParams
  },
  filterConnectedSubstationParams(state) {
    if (Object.keys(state.filterConnectedSubstationParams).length === 0) { 
      if (sessionStorage['filterConnectedSubstationParams']) {
        state.filterConnectedSubstationParams = JSON.parse(sessionStorage['filterConnectedSubstationParams'])
      }
    }
    return state.filterConnectedSubstationParams
  },
  filterConnectedLineParams(state) {
    if (Object.keys(state.filterConnectedLineParams).length === 0) { 
      if (sessionStorage['filterConnectedLineParams']) {
        state.filterConnectedLineParams = JSON.parse(sessionStorage['filterConnectedLineParams'])
      }
    }
    return state.filterConnectedLineParams
  },

  isDictRef(state) {
    if (state.isDictRef === "") { 
      if (sessionStorage['isDictRef']) {
        state.isDictRef = JSON.parse(sessionStorage['isDictRef'])  // true or false
        console.log("isDictRef", state.isDictRef)
      }
    }
    return state.isDictRef
  },
  formInputsBuffer(state) {
    if (Object.keys(state.formInputsBuffer).length === 0) { 
      if (sessionStorage['formInputsBuffer']) {
        state.formInputsBuffer = JSON.parse(sessionStorage['formInputsBuffer'])
      }
    }
    return state.formInputsBuffer
  },
  forcedDownload(state) {
    return state.forcedDownload
  },

  regSapSoId(state) {
    if (state.regSapSoId === "") {
      if (sessionStorage['regSapSoId']) {
        state.regSapSoId = sessionStorage['regSapSoId']
      }
    }
    return state.regSapSoId
  },
  regSapRemId(state) {
    if (state.regSapRemId === "") {
      if (sessionStorage['regSapRemId']) {
        state.regSapRemId = sessionStorage['regSapRemId']
      }
    }
    return state.regSapRemId
  },
  addSaved(state) {
    return state.addSaved
  },
  updateSaved(state) {
    return state.updateSaved
  },
  errorSaved(state) {
    return state.errorSaved
  },

  // Аутентифікація/авторизація
  userId(state) {
    if (state.userId === "") {
      if (sessionStorage['userId']) {
        state.userId = sessionStorage['userId']
      }
    }
    return state.userId
  },
  userName(state) {
    if (state.userName === "") {
      if (sessionStorage['userName']) {
        state.userName = sessionStorage['userName']
      }
    }
    return state.userName
  },
  soIdAuth(state) {
    if (state.soIdAuth === "") {
      if (sessionStorage['soIdAuth']) {
        state.soIdAuth = sessionStorage['soIdAuth']
      }
    }
    return state.soIdAuth
  },
  remIdAuth(state) {
    if (state.remIdAuth === "") {
      if (sessionStorage['remIdAuth']) {
        state.remIdAuth = sessionStorage['remIdAuth']
      }
    }
    return state.remIdAuth
  },
  boIdAuth(state) {
    if (state.boIdAuth === "") {
      if (sessionStorage['boIdAuth']) {
        state.boIdAuth = sessionStorage['boIdAuth']
      }
    }
    return state.boIdAuth
  },

  structName(state) {
    if (state.structName === "") {
      if (sessionStorage['structName']) {
        state.structName = sessionStorage['structName']
      }
    }
    return state.structName
  },
  structMode(state) {
    if (state.structMode === "") {
      if (sessionStorage['structMode']) {
        state.structMode = sessionStorage['structMode']
      }
    }
    return state.structMode
  },
  allowRoute(state) {
    return state.allowRoute
  },

  formMode(state) {
    if (!state.formMode) { 
      if (sessionStorage['formMode']) {
        state.formMode = sessionStorage['formMode']
      }
    }
    return state.formMode
  },
  isFormModified(state) {
    if (!state.isFormModified) { 
      if (sessionStorage['isFormModified']) {
        state.isFormModified = sessionStorage['isFormModified']
      }
    }
    return state.isFormModified
  },
}