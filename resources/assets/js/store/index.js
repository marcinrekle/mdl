import Vue from 'vue'
import Vuex from 'vuex'

import mutations from './mutations'
import actions from './actions'
import getters from './getters'

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
  	isLoading: false,
    users: [],
    fields: [],
    roles: [],
    permissions: [],
    drives: [],
    hours: {},
    payments: {},
    costNames: [],
    notifications: {
    	error : [],
    	success : [],
    	info : [],
    },
  },
  mutations,
  actions,
  getters,
  /*plugins*/
})