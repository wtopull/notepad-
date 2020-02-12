const Vue = require('vue')
import Vant from 'vant';
import App from './App.vue'
import router from './router'
import store from './store'
import api from './assets/js/api'
import Cookies from "js-cookie";
import './assets/css/public.css'
import 'amfe-flexible/index.js'
import 'vant/lib/index.css';
import 'vant/lib/index.less';
import { Lazyload } from 'vant';
import i18n from './lang/'
import mavonEditor from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'

Vue.use(mavonEditor)
Vue.use(Vant);
Vue.use(Lazyload);
Vue.prototype.$api = api;
Vue.config.productionTip = false

router.beforeEach((to, from, next) => {
  const user = Cookies.get("user");
  if (to.matched.some(record => record.meta.requireAuth)) {
    if (user != '' && user !== undefined) {
      next();
    } else {
      next({
        path: '/login',
        query: {
          redirect: to.fullPath
        }
      })
    }
  } else {
    next();
  }
});

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
