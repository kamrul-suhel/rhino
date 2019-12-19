import Vue from 'vue'
import Vuex from 'vuex'

import Button from './modules/button'
import ImageUpload from './modules/imageUpload'

import settings from './modules/settings'
import authUser from './modules/authUser'
import user from './modules/user'
import navigation from './modules/navigation'
import language from './modules/language'
import country from './modules/country'
import SnackBar from './modules/snackbar'
import Dealership from './modules/dealership'
import Group from './modules/group'
import Company from './modules/company'
import Brand from './modules/brand'
import Vehicle from './modules/vehicle'
import Region from './modules/region'
import Type from './modules/eventType'
import Event from './modules/event'
import Guest from './modules/guest'
import EventVehicle from './modules/eventVehicle'


Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        initialize: true
    },

    mutations: {
        resetProductTransition(state){
            state.products = []
        },

        setInitialize(state){
            state.initialize = !state.initialize
        }
    },

    actions: {

    },

    getters: {
        getInitialize(state){
            return state.initialize
        }
    },

    modules: {
        SnackBar,
        Button,
        settings,
        authUser,
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
        Type,
        Event,
        Guest,
        EventVehicle
    }
})

export default store
