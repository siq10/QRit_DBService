import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {menuchoice:0}
const mutations = {
    redirect (state,choice) {
        // mutate state
        state.menuchoice=choice
        //console.log(choice);
      }
}

export default new Vuex.Store({
    state,
    mutations
})