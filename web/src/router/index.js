const Vue = require('vue')
const VueRouter = require('vue-router')
import Home from '../views/Home.vue'

if (!window.VueRouter) Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '../views/info/login.vue')
  },
  {
    path: '/Home',
    name: 'Home',
    // component: Home
    component: () => import(/* webpackChunkName: "Home" */ '../views/Home.vue')
  },
  {
    path: '/Fro',
    name: 'Fro',
    component: () => import(/* webpackChunkName: "front" */ '../views/Fro.vue')
  },
  {
    path: '/Ser',
    name: 'Ser',
    component: () => import(/* webpackChunkName: "Ser" */ '../views/Ser.vue')
  },
  {
    path: '/Info',
    name: 'Info',
    component: () => import(/* webpackChunkName: "Info" */ '../views/Info.vue')
  },
  {
    path: '/detail',
    name: 'detail',
    component: () => import(/* webpackChunkName: "detail" */ '../views/details/detail.vue')
  },
  {
    path: '/register',
    name: 'register',
    component: () => import(/* webpackChunkName: "register" */ '../views/info/register.vue')
  },
  {
    path: '/setpwd',
    name: 'setpwd',
    component: () => import(/* webpackChunkName: "setpwd" */ '../views/info/setpwd.vue')
  },
  {
    path: '/fixTx',
    name: 'fixTx',
    component: () => import(/* webpackChunkName: "fix-tx" */ '../views/info/fix-tx.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
