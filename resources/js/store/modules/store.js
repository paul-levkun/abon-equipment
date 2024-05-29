import {createStore} from "vuex";
import dictModule from './dicts/states'

const store = createStore( {

    modules: {
        dictModule,
    },
})

export default store