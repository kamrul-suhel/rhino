import Vue from 'vue';
import Vuex from 'vuex';

import settings from './modules/settings';
import user from './modules/user'


Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        products:[],
    },

    mutations: {
        resetProductTransition(state){
            state.products = [];
        }
    },

    actions: {

    },

    getters: {

    },

    modules: {
        settings,
        user
    }
});

export default store;
