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
    path: '/front',
    name: 'front',
    component: () => import(/* webpackChunkName: "front" */ '../views/front.vue')
  },
  {
    path: '/serves',
    name: 'serves',
    component: () => import(/* webpackChunkName: "serves" */ '../views/serves.vue')
  },
  {
    path: '/info',
    name: 'info',
    component: () => import(/* webpackChunkName: "info" */ '../views/info.vue')
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
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
