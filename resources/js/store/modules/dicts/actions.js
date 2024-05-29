import axios from "axios";
import router from "./../../../router";
export default {
	
	showDict(context, payload) {
		context.commit('setIsLoading', true)
		const page_id = payload.pageId;
		const page_size = context.getters['currentDictPageSize'];

		let filterRequest = "";
		let filterParams
		switch (payload.id) {
			case "owners": 
				filterParams = context.getters['filterOwnerParams']; 			break
			case "substations": 
				filterParams = context.getters['filterSubstationParams'];	break
			case "lines": 
			console.log("111111");
				filterParams = context.getters['filterLineParams'];				break
			case "registers": 
				filterParams = context.getters['filterRegisterParams'];		
				// console.log("registers filterParams", filterParams)
				break
			case "contracts": 
				filterParams = context.getters['filterContractParams'];		break
			case "connected_substations": 
				filterParams = context.getters['filterConnectedSubstationParams'];	break
			case "connected_lines": 
			console.log("222222");
				filterParams = context.getters['filterConnectedLineParams'];				break
		}
		
		for (let param in filterParams) {
			if (filterParams[param])
				filterRequest += `&${param}=${filterParams[param]}`
		}

		console.log("filterParams: ", filterParams)
		console.log(`/api/dicts?id=${payload.id}&page_id=${page_id}&page_size=${page_size}${filterRequest}`)

		axios.get(`/api/dicts?id=${payload.id}&page_id=${page_id}&page_size=${page_size}${filterRequest}`)
		.then(res => {
			context.commit('setCurrentDictId', payload.id)
			context.commit('setCurrentDictTitle', payload.title)
			context.commit('setCurrentDictPageId', payload.pageId)
			context.commit('setCurrentDictRCount', res.data.count)
			context.commit('setCurrentDict', res.data.dict)
			context.commit('setIsLoading', false)
			context.commit('setForcedDownload', false)

			console.log("Ю 111111")
			sessionStorage['allowRoute'] = 1
			router.push({ name: "dict-grid", state: { allowRoute: true } })
			console.log(res.data.dict)
		})
		.catch(err => {
			// this.not_found = true;
		})
	},

	setRef(context, payload) {
		axios.get(`/api/dicts?id=${payload.id}&page_id=1&page_size=100`)
		.then(res => {
			switch (payload.id) {
				case "rems": 
					const arrRem = res.data.dict.map(item => { return { id: item.id, name: (item.idParent === 1 ? "" : "-- ") + item.name } } )
					arrRem.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefRem', arrRem) 
					break
				case "owner_types": 
					const arrOwnerType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrOwnerType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefOwnerType', arrOwnerType) 
					break
				case "sap_sos": 
					const arrSapSo = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrSapSo.unshift({ id: 0, name: "Всі" })
					arrSapSo.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefSapSo', arrSapSo) 
					break
				case "sap_rems": 
					const arrSapRem = res.data.dict.map(item => { return { id: item.id, name: item.name, so_id: item.so_id } } )
					arrSapRem.unshift({ id: 0, name: "Всі" })
					arrSapRem.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefSapRem', arrSapRem) 
					break
				case "sap_bos": 
					const arrSapBo = res.data.dict.map(item => { return { id: item.id, name: item.code_bo + " " + item.name } } )
					arrSapBo.unshift({ id: "0", name: "Всі" })
					arrSapBo.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefSapBo', arrSapBo)
					console.log(context.getters['refSapBo'])
					break
				case "location_types": 
					const arrLocationType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrLocationType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefLocationType', arrLocationType) 
					break
				case "line_section_types": 
					const arrLineSectionType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrLineSectionType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefLineSectionType', arrLineSectionType) 
					break
				case "tech_state_types": 
					const arrTechStateType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrTechStateType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefTechStateType', arrTechStateType) 
					break
				case "object_types": 
					const arrObjectType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrObjectType.unshift({ id: "30,31,32,33,34,35", name: "КТП, ЩТП, ЗТП, РП" })
					arrObjectType.unshift({ id: "0", name: "Всі" })
					arrObjectType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefObjectType', arrObjectType) 
					break
				case "status_types": 
					const arrStatusType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrStatusType.unshift({ id: "0", name: "Всі" })
					arrStatusType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefStatusType', arrStatusType) 
					break
				case "doc_types": 
					const arrDocType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					// arrDocType.unshift({ id: "0", name: "Всі" })
					arrDocType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefDocType', arrDocType) 
					break
				case "contract_status_types": 
					const arrContractStatusType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrContractStatusType.unshift({ id: 0, name: "Всі" })
					arrContractStatusType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefContractStatusType', arrContractStatusType) 
					break
				case "contract_types": 
					const arrContractType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrContractType.unshift({ id: 0, name: "Всі" })
					arrContractType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefContractType', arrContractType) 
					break
				case "contract_failure_types": 
					const arrContractFailureType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrContractFailureType.unshift({ id: 0, name: "Всі" })
					arrContractFailureType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefContractFailureType', arrContractFailureType) 
					break
				case "contract_inexpediency_types": 
					const arrContractInexpediencyType = res.data.dict.map(item => { return { id: item.id, name: item.name } } )
					arrContractInexpediencyType.unshift({ id: 0, name: "Всі" })
					arrContractInexpediencyType.unshift({ id: "", name: "Оберіть значення" })
					context.commit('setRefContractInexpediencyType', arrContractInexpediencyType) 
					break
			}
		})
		.catch(err => {
			console.log("Validation errors:", err.response.data.errors);
		})
	},

	storeDict(context, payload) {
		context.commit('setIsLoading', true)
		let config = {
      header : {
       'Content-Type' : 'multipart/form-data'
      }
    }
		if (payload.oper === "add") {
			axios.post('/api/dicts', payload.data, config)
			.then(res => {
				context.commit('setIsLoading', false)
				context.commit('setFormErrors', {})
				context.commit('setFormInputs', {})
				context.commit('setAddSaved', true)

				let fileInput = document.getElementById('file_docs');
				if (fileInput)					// тільки для FormRegister
					fileInput.value = '';
			})
			.catch(err => {
				// context.commit('setIsLoading', false)
				// context.commit('setFormErrors', err.response.data.errors)
				// context.commit('setErrorSaved', true)
				// 				// console.log("Validation errors:", err.response.data.errors);
				// 				console.log("Validation errors:", typeof err.response.data, err.response.data);
				// 				console.log("Validation errors:", err);
				context.commit('setIsLoading', false)
				if (err.response.status === 422) {
					context.commit('setFormErrors', err.response.data.errors)
					context.commit('setErrorSaved', true)
									console.log("Validation errors:", err.response.data.errors);
				}
				else if (err.response.status === 500) {
					if (err.response.data.errors) 
						context.commit('setFormErrors', err.response.data.errors)
					else
						context.commit('setFormErrors', 
							{ 
								ftp: ["Помилка FTP сервера: \"Перевищено максимальний час виконання операції. Можливо, сервер недоступний.\". Звернітся до адміністратора мережі"]
							}
						)
					context.commit('setErrorSaved', true)
									console.log("Validation errors:", err);
				}
			})
		}
		else {
			axios.post(`/api/dicts/${payload.id}`, payload.data, config)
			.then(res => {
				context.commit('setIsLoading', false)
				context.commit('setFormErrors', {})
				context.commit('setUpdateSaved', true)
				console.log("*** => ", res)

				let fileInput = document.getElementById('file_docs');
				if (fileInput)					// тільки для FormRegister
					fileInput.value = '';
	
				if (payload.id === "registers") {				// Якщо registers, то оновити документи
					console.log("1233321", payload.row_id)
					console.log(context.getters['formInputsBuffer'])
					context.dispatch('updateDocs', { id: "documents", row_id: payload.row_id, })
				}
			})
			.catch(err => {
				context.commit('setIsLoading', false)
				if (err.response.status === 422) {
					context.commit('setFormErrors', err.response.data.errors)
					context.commit('setErrorSaved', true)
									console.log("Validation errors:", err.response.data.errors);
				}
				else if (err.response.status === 500) {
					if (err.response.data.errors) 
						context.commit('setFormErrors', err.response.data.errors)
					else
						context.commit('setFormErrors', 
							{ 
								ftp: ["Помилка FTP сервера: \"Перевищено максимальний час виконання операції. Можливо, сервер недоступний.\". Звернітся до адміністратора мережі"]
							}
						)
					context.commit('setErrorSaved', true)
									console.log("Validation errors:", err);
				}
				// else {
				// 	console.log("Other Validation errors:", err);
				// }
			})
		}
	},

	updateDict(context, payload) {
		axios.get(`/api/dicts/${payload.id}?row_id=${payload.row_id}`)
		.then(res => {

			if (context.getters['isDictRef']) {
			// if (isDictRef) {
				const inputBuffer = context.getters['formInputsBuffer']
				switch (payload.id) {
					case 'substations': case 'lines':
						inputBuffer.substation_id = inputBuffer.lines_id = 
							inputBuffer.substations = inputBuffer.lines = null
						if (payload.id === 'substations') {
							inputBuffer.substations = res.data[0]
							inputBuffer.substation_id = res.data[0].id
						}
						else {
							inputBuffer.lines = res.data[0]
							inputBuffer.lines_id = res.data[0].id
						}
						context.commit("setIsFormModified", 1);
						break
					case 'owners':
						inputBuffer.owners = res.data[0]
						inputBuffer.owner_id = res.data[0].id
						context.commit("setIsFormModified", 1);
						break
					case 'contracts':
						inputBuffer.contracts = res.data[0]
						inputBuffer.contract_id = res.data[0].id
						context.commit("setIsFormModified", 1);
						break
					case 'connected_substations': case 'connected_lines':
						inputBuffer.connected_substation_id = inputBuffer.connected_lines_id = 
							inputBuffer.connected_substations = inputBuffer.connected_lines = null
						if (payload.id === 'connected_substations') {
							inputBuffer.connected_substations = res.data[0]
							inputBuffer.connected_substation_id = res.data[0].id
						}
						else {
							inputBuffer.connected_lines = res.data[0]
							inputBuffer.connected_lines_id = res.data[0].id
						}
						context.commit("setIsFormModified", 1);
						break
					}
				context.commit('setFormInputs', inputBuffer)
				context.commit('setIsDictRef', false)
				console.log("3555", context.getters['formInputs'])
				// console.log("356", JSON.parse(sessionStorage['formInputs']))
			}
			else {
				context.commit('setFormInputs', res.data[0])
				// console.log("355", res.data[0])
				// console.log("355", context.getters['formInputs'])
				// console.log("356", sessionStorage['formInputs'])
			}

			console.log("Ю 222222")
			sessionStorage['allowRoute'] = 1
			router.push("/dict-form")

		})
		.catch(err => {
			// this.not_found = true;
		})
	},

	updateDocs(context, payload) {
		axios.get(`/api/dicts/${payload.id}?row_id=${payload.row_id}`)
		.then(res => {
			console.log('documents', res.data)
			context.commit('setRefDocument', res.data)
		})
	},

	deleteDict(context, payload) {
		context.commit('setIsLoading', true)
		axios.delete(`/api/dicts/${payload.id}?row_id=${payload.row_id}&user_id=${payload.user_id}`)
		.then(res => {
			context.commit('setIsLoading', false)
			context.dispatch('showDict', { 
				id: context.getters['currentDictId'], 
				title: context.getters['currentDictTitle'], 
				pageId: context.getters['currentDictPageId'], 
			})

			console.log("delete: ", res.data)
		})
		.catch(err => {
			context.commit('setIsLoading', false)
			console.log("Deleting errors:", err);
			context.commit('setFormErrors', err.response.data.errors)
								console.log("Deleting errors:", err.response.data.errors);
		})
	},

	makeReport(context, payload) {
		context.commit('setIsLoading', true)
		console.log("report Start", `/api/reports/${payload.id}`)
		// axios.get(`/api/reports/${payload.id}`)
		axios.get(`/api/report?id=${payload.id}`)
		.then(res => {
			context.commit('setIsLoading', false)
			window.location.href = `${window.location.protocol}//${window.location.hostname}:${window.location.port}/storage/${res.data}`
			console.log("report Finish", res.data)

			// axios.delete('/api/delete-report', { data: { file_path: res.data } })
			// axios.delete(`/api/deleteFile/${res.data}`) неправильно
			// .then(response => {
			// 	console.log('Файл видалено з сервера', response.data);
			// })
			// .catch(error => {
			// 	console.error('Помилка під час видалення файлу:', error);
			// });
		})
	},
}