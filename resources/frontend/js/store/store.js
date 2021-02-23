import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    logined: true
  },
  mutations: {
    status (state) { //bar消失
      state.logined = false;
    },
    statusOf (state) { //bar顯示
        state.logined = true;
      }
  }
})
export default store;