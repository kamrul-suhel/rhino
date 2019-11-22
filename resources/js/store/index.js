import Vue from 'vue';
import Vuex from 'vuex';

import settings from './modules/settings';
import user from './modules/user'
import navigation from "./modules/navigation";
import language from './modules/language'
import country from "./modules/country";
import SnackBar from "./modules/snackbar";
import Dealership from './modules/dealership'


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
        SnackBar,
        settings,
        user,
        navigation,
        language,
        country,
        Dealership
    }
});

export default store;
