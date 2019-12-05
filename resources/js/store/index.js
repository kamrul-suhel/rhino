import Vue from 'vue'
import Vuex from 'vuex'

import settings from './modules/settings'
import user from './modules/user'
import navigation from "./modules/navigation"
import language from './modules/language'
import country from "./modules/country"
import SnackBar from "./modules/snackbar"
import Dealership from './modules/dealership'
import Group from './modules/group'
import ImageUpload from "./modules/imageUpload"
import Company from "./modules/company"
import Brand from "./modules/brand"
import Vehicle from "./modules/vehicle"
import Region from "./modules/region"
import Type from "./modules/eventType"
import Button from "./modules/button"


Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        products:[],
    },

    mutations: {
        resetProductTransition(state){
            state.products = []
        }
    },

    actions: {

    },

    getters: {

    },

    modules: {
        SnackBar,
        Button,
        settings,
        user,
        navigation,
        language,
        country,
        Dealership,
        Group,
        ImageUpload,
        Company,
        Brand,
        Vehicle,
        Region,
        Type
    }
})

export default store
