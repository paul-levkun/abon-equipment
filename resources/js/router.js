import { createRouter, createWebHistory } from "vue-router";
import store from "./store/modules/store";
import DictList from './Pages/Dictionary/DictList.vue'
import RegList from './Pages/Dictionary/RegList.vue'
import RepList from './Pages/Dictionary/RepList.vue'
import DictGrid from './Pages/Dictionary/DictGrid.vue'
import DictForm from './Pages/Dictionary/DictForm.vue'
import NotFound from './views/NotFound.vue'

const routes = [
  // { path: "/",         // тут цього не є
  //   component: Dictionary
  // },
  {
    path: "/dict-list",
    component: DictList
  },
  { 
    path: "/dict-grid",
    name: "dict-grid",
    // params: ':allowRoute',
    component: DictGrid,
    props: true,
    // params: { allowRoute: true }
    // props: (route) => ({ allowRoute: store.getters['dictModule/allowRoute'] })
    // // props: { allowRoute: store.getters['dictModule/allowRoute'] },
    // beforeRouteLeave(to, from, next) {
    //   console.log('Leaving DictGrid', this.allowRoute);
    //   // if (this.allowRoute) {
    //   //   next();
    //   // }
    //   // else {
    //     next(false);
    //   // }
    // },
  },
  { 
    path: "/dict-form",
    component: DictForm,
  },
  {
    path: "/reg-list",
    component: RegList,
  },
  // { 
  //   path: "/reg-grid",
  //   component: DictGrid,

  // },
  // { 
  //   path: "/reg-form",
  //   component: DictForm,
  // },
  {
    path: "/rep-list",
    component: RepList
  },
  // { 
  //   path: "/dict-test",
  //   component: DictTest
  // },
  // { path: "/post/:id",
  //   component: Post
  // },
  // { path: "/create",
  //   component: CreatePost
  // }
  { path: '/:notFound(.*)', 
    component: NotFound 
  },
];

const router  = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

// router.beforeEach((to, from, next) => {
//   console.log("router before: ", from.path, to.path, store.getters['dictModule/allowRoute'])
//   if (store.getters['dictModule/allowRoute']) { // глобальний store
//     next();
//   }
//   else {
//     next(false);
//   }
// });

export default router;