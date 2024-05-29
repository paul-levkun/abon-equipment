export default {
  setCurrentDictId(state, payload) {
    state.currentDictId = payload
    sessionStorage['currentDictId'] = payload
  },
  setCurrentDictTitle(state, payload) {
    state.currentDictTitle = payload
    sessionStorage['currentDictTitle'] = payload
  },
  setCurrentDictPageId(state, payload) {
    state.currentDictPageId = payload
    sessionStorage['currentDictPageId'] = payload
  },
  setCurrentDict(state, payload) {
    state.currentDict = payload
  },
  setCurrentDictRCount(state, payload) {
    state.currentDictRCount = payload
  },
  setIsLoading(state, payload) {
    state.isLoading = payload
  },
  setRefRem(state, payload) {
    state.refRem = payload
  },
  setRefOwnerType(state, payload) {
    state.refOwnerType = payload
  },
  setRefSapSo(state, payload) {
    state.refSapSo = payload
  },
  setRefSapRem(state, payload) {
    state.refSapRem = payload
  },
  setRefSapBo(state, payload) {
    state.refSapBo = payload
  },
  setRefLocationType(state, payload) {
    state.refLocationType = payload
  },
  setRefLineSectionType(state, payload) {
    state.refLineSectionType = payload
  },
  setRefTechStateType(state, payload) {
    state.refTechStateType = payload
  },
  setRefContractType(state, payload) {
    state.refContractType = payload
  },
  setRefObjectType(state, payload) {
    state.refObjectType = payload
  },
  setRefStatusType(state, payload) {
    state.refStatusType = payload
  },
  setRefDocType(state, payload) {
    state.refDocType = payload
  },
  setRefDocument(state, payload) {
    state.refDocument = payload
  },
  setRefContractFailureType(state, payload) {
    state.refContractFailureType = payload
  },
  setRefContractType(state, payload) {
    state.refContractType = payload
  },
  setRefContractStatusType(state, payload) {
    state.refContractStatusType = payload
  },
  setRefContractInexpediencyType(state, payload) {
    state.refContractInexpediencyType = payload
  },
  setFormInputs(state, payload) {
    state.formInputs = payload
    sessionStorage['formInputs'] = JSON.stringify(payload)
  },
  setFormErrors(state, payload) {
    state.formErrors = payload
  },
  setFilterOwnerParams(state, payload) {
    state.filterOwnerParams = payload
    sessionStorage['filterOwnerParams'] = JSON.stringify(payload)
  },
  setFilterSubstationParams(state, payload) {
    state.filterSubstationParams = payload
    sessionStorage['filterSubstationParams'] = JSON.stringify(payload)
  },
  setFilterLineParams(state, payload) {
    state.filterLineParams = payload
    sessionStorage['filterLineParams'] = JSON.stringify(payload)
  },
  setFilterRegisterParams(state, payload) {
    state.filterRegisterParams = payload
    sessionStorage['filterRegisterParams'] = JSON.stringify(payload)
  },
  setFilterContractParams(state, payload) {
    state.filterContractParams = payload
    sessionStorage['filterContractParams'] = JSON.stringify(payload)
  },
  setFilterConnectedSubstationParams(state, payload) {
    state.filterConnectedSubstationParams = payload
    sessionStorage['filterConnectedSubstationParams'] = JSON.stringify(payload)
  },
  setFilterConnectedLineParams(state, payload) {
    state.filterConnectedLineParams = payload
    sessionStorage['filterConnectedLineParams'] = JSON.stringify(payload)
  },
  setIsDictRef(state, payload) {
    state.isDictRef = payload
    sessionStorage['isDictRef'] = JSON.stringify(payload) // 'true' or 'false'
    if (payload === true) {
      state.bufferDictPageId = state.currentDictPageId
      sessionStorage['bufferDictPageId'] = state.currentDictPageId
      console.log("1 >>> ", state.bufferDictPageId, "*", sessionStorage['bufferDictPageId'])
    }
    else {
      state.currentDictId = sessionStorage['currentDictId'] = state.bufferDictId
      state.currentDictTitle = sessionStorage['currentDictTitle'] = state.bufferDictTitle
      let dictPageId = ""
      if (state.bufferDictPageId === "") {
        if (sessionStorage['bufferDictPageId']) {
          dictPageId = sessionStorage['bufferDictPageId']
          console.log("2 >>> ", dictPageId)
        }
      }
      else
        dictPageId = state.bufferDictPageId

      state.currentDictPageId = sessionStorage['currentDictPageId'] = dictPageId
      console.log("3 >>> ", dictPageId, " °T° ", state.currentDictPageId)
      console.log(state.currentDictId, "°", state.currentDictTitle, " °T° ", state.currentDictPageId)
    }
  },
  setFormInputsBuffer(state, payload) {
    state.formInputsBuffer = payload
    sessionStorage['formInputsBuffer'] = JSON.stringify(payload)
  },
  setForcedDownload(state, payload) {
    state.forcedDownload = payload
  },

  setRegSapSoId(state, payload) {
    state.regSapSoId = sessionStorage['regSapSoId'] = payload
  },
  setRegSapRemId(state, payload) {
    state.regSapRemId = sessionStorage['regSapRemId'] = payload
  },
  setAddSaved(state, payload) {
    state.addSaved = payload
  },
  setUpdateSaved(state, payload) {
    state.updateSaved = payload
  },
  setErrorSaved(state, payload) {
    state.errorSaved = payload
  },

  // Аутентифікація/авторизація
  setUserId(state, payload) {
    state.userId = sessionStorage['userId'] = payload
  },
  setUserName(state, payload) {
    console.log("mutsetUserName", payload)
    state.userName = sessionStorage['userName'] = payload
  },
  setSoIdAuth(state, payload) {
    state.soIdAuth = sessionStorage['soIdAuth'] = payload
  },
  setRemIdAuth(state, payload) {
    state.remIdAuth = sessionStorage['remIdAuth'] = payload
  },
  setBoIdAuth(state, payload) {
    state.boIdAuth = sessionStorage['boIdAuth'] = payload
  },
  setStructName(state, payload) {
    state.structName = sessionStorage['structName'] = payload
  },
  setStructMode(state, payload) {
    state.structMode = sessionStorage['structMode'] = payload
  },

  setAllowRoute(state, payload) {
    state.allowRoute = payload
  },

  setFormMode(state, payload) {
    state.formMode = payload
    sessionStorage['formMode'] = payload
  },

  setIsFormModified(state, payload) {
    state.isFormModified = payload
    sessionStorage['isFormModified'] = payload
  },
}