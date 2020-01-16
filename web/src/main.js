import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from 'axios'
import './assets/css/public.css'
import 'amfe-flexible/index.js'
import 'vant/lib/index.css';
import { Tabbar, TabbarItem } from 'vant';
import { Swipe, SwipeItem } from 'vant';
import { Lazyload } from 'vant';
import { Grid, GridItem } from 'vant';
import { NoticeBar } from 'vant';
import { Cell, CellGroup } from 'vant';
import { Image } from 'vant';
import { NavBar } from 'vant';
import { Toast } from 'vant';
import { Field } from 'vant';
import { Button } from 'vant';
import { Icon } from 'vant';

Vue.use(Icon);
Vue.use(Button);
Vue.use(Field);
Vue.use(Toast);
Vue.use(NavBar);
Vue.use(Image);
Vue.use(Cell).use(CellGroup);
Vue.use(NoticeBar);
Vue.use(Grid).use(GridItem);
Vue.use(Lazyload);
Vue.use(Swipe).use(SwipeItem);
Vue.use(Tabbar).use(TabbarItem);
Vue.prototype.$axios = axios;
Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
