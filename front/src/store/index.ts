import Vue from 'vue'
import Vuex from 'vuex'
import Todo from '@/store/modules/todo'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isLoading: true,
    curDate: new Date(),
  },
  mutations: {
    toggleLoading(state) {
      state.isLoading = !state.isLoading
    },
    changeCurDate(state, newDate: Date) {
      state.curDate = newDate
    },
  },
  actions: {
    toggleLoading({ commit }) {
      commit('toggleLoading')
    },
    changeCurDate({ commit }, newDate: Date) {
      commit('changeCurDate', newDate)
    },
  },
  modules: {
    todo: Todo,
  },
})
