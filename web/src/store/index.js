import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'js-cookie'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    theme: "",
    language: Cookies.get('language') || 'zh',
  },
  mutations: {
    setTheme(state,themeName){
      state.theme=themeName;
    },
    // 中英文
    SET_LANGUAGE: (state, language) => {
      state.language = language
      Cookies.set('language', language)
    }
  },
  actions: {
    setTheme({ commit }, themeName) {
      commit('setTheme', themeName)
    },
    // 中英文
    setLanguage({ commit }, language) {
      commit('SET_LANGUAGE', language)
    }
  },
  getters: {
    getTheme: state => state.theme,
  }
})
