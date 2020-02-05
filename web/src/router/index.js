const Vue = require('vue')
const VueRouter = require('vue-router')
import Home from '../views/Home.vue'
import login from '../views/info/login.vue'

if (!window.VueRouter) Vue.use(VueRouter)

const routes = [
  {
    path: '',
    redirect: '/login'
  },
  {
    path: '/',
    redirect: '/login'
  },
  {
    path: '/login',
    name: 'login',
    component: login
  },
  {
    path: '/Home',
    name: 'Home',
    component: () => import(/* webpackChunkName: "Home" */ '../views/Home.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Fro',
    name: 'Fro',
    component: () => import(/* webpackChunkName: "front" */ '../views/Fro.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Ser',
    name: 'Ser',
    component: () => import(/* webpackChunkName: "Ser" */ '../views/Ser.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/Info',
    name: 'Info',
    component: () => import(/* webpackChunkName: "Info" */ '../views/Info.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/detail',
    name: 'detail',
    component: () => import(/* webpackChunkName: "detail" */ '../views/details/detail.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/register',
    name: 'register',
    component: () => import(/* webpackChunkName: "register" */ '../views/info/register.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/setpwd',
    name: 'setpwd',
    component: () => import(/* webpackChunkName: "setpwd" */ '../views/info/setpwd.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/fixTx',
    name: 'fixTx',
    component: () => import(/* webpackChunkName: "fix-tx" */ '../views/info/fix-tx.vue'),
    meta: {
      requireAuth: true
    }
  },
  {
    path: '/issue',
    name: 'issue',
    component: () => import(/* webpackChunkName: "issue" */ '../views/issue/issue.vue'),
    meta: {
      requireAuth: true
    }
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
