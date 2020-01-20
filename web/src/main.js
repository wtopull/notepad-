const Vue = require( 'vue' )
import Vant from 'vant';
import App from './App.vue'
import router from './router'
import store from './store'
import api from './assets/js/api'
import './assets/css/public.css'
import 'amfe-flexible/index.js'
import 'vant/lib/index.css';
import 'vant/lib/index.less';
import { Lazyload } from 'vant';
import { Locale } from 'vant';
import i18n from './lang/'


Vue.use(Vant);
Vue.use(Lazyload);
Vue.prototype.$api = api;
Vue.prototype.$theme = 'default';
Vue.config.productionTip = false

new Vue({
  router,
  store,
  i18n,
  render: h => h(App)
}).$mount('#app')
