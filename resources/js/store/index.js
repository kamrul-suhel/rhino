import Vue from 'vue'
import Vuex from 'vuex'

import Button from './modules/button'
import ImageUpload from './modules/imageUpload'

import settings from './modules/settings'
import authUser from './modules/authUser'
import user from './modules/user'
import navigation from './modules/navigation'
import DealershipNavigation from './modules/navigationForDealership'
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
import Appointment from './modules/appointment'
import Booking from './modules/booking'
import Analytics from './modules/analytics'
import Translations from './modules/translation'
import SpecializeBrand from './modules/specializeBrand'
import Header from './modules/header'
import Global from './modules/global'
import SaleUpdate from "./modules/saleUpdate"
import AssignToSaleExecutiveDialog from "./modules/assignToSaleExecutive";
import Error from "./modules/error";


Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        initialize: true,
        initializeAppointment: true
    },

    mutations: {
        resetProductTransition(state){
            state.products = []
        },

        setInitialize(state){
            state.initialize = !state.initialize
        },

        setInitializeAppointment(state){
            state.initializeAppointment = !state.initializeAppointment
        }

    },

    actions: {

    },

    getters: {
        getInitialize(state){
            return state.initialize
        },

        getInitializeAppointment(state){
            return state.initializeAppointment
        }
    },

    modules: {
        Global,
        Header,
        SnackBar,
        Button,
        settings,
        authUser,
        user,
        navigation,
        DealershipNavigation,
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
        EventVehicle,
        Appointment,
        Booking,
        Translations,
        Analytics,
        SpecializeBrand,
        SaleUpdate,
        AssignToSaleExecutiveDialog,
        Error
    }
})

export default store
