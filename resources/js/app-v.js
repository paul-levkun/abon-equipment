import { createApp } from 'vue'
import store from "./store/modules/store";
import DictList from './Pages/Dictionary/DictList.vue'
import BaseSpinner from "./components/BaseSpinner";
// import BaseModal from "./components/BaseModal";
// import PrimaryButton from "./Components/PrimaryButton";
// import SecondaryButton from "./Components/SecondaryButton";
// import DangerButton from "./Components/DangerButton";

import router from "./router";
// import Paginate from "vuejs-paginate-next"

const app = createApp({ })

app
  .component('dict-list', DictList)
  .component('base-spinner', BaseSpinner)
  // .component('base-modal', BaseModal)
  // .component('primary-button', PrimaryButton)
  // .component('secondary-button', SecondaryButton)
  // .component('danger-button', DangerButton)

app
  .use(router)
  .use(store)

app.mount('#app')
