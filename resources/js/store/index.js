import Vue from 'vue';
import Vuex from 'vuex';

import settings from './modules/settings';
import user from './modules/user'
import navigation from "./modules/navigation";
import language from './modules/language'
import country from "./modules/country";
import SnackBar from "./modules/snackbar";
import Dealership from './modules/dealership'
import Group from './modules/group'


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
        Dealership,
        Group
    }
});

export default store;
