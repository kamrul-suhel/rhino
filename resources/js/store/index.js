import Vue from 'vue';
import Vuex from 'vuex';

import settings from './modules/settings';
import user from './modules/user'
import navigation from "./modules/navigation";
import language from './modules/language'
import country from "./modules/country";


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
        user,
        navigation,
        language,
        country
    }
});

export default store;
