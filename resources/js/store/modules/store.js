import {createStore} from "vuex";
import dictModule from './dicts/states'

const store = createStore( {

    modules: {
        dictModule,
    },
    // state() {
    //     return {
    //         userId: 'd3'
    //     }
    // },

    // getters: {
    //     userId(state) {
    //         return state.userId
    //     }
    // }
})

export default store