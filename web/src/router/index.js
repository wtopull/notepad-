import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
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
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '../views/info/login.vue')
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
