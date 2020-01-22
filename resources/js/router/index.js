import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../pages/login/LoginComponent'
import DealershipRoutes from './Modules/dealership'
import LanguageRoutes from './Modules/languages'
import BrandsRoutes from './Modules/brands'
import VehiclesRoutes from './Modules/vehicles'
import CountriesRoutes from './Modules/countries'
import Groups from './Modules/groups'
import Company from './Modules/company'
import Booking from "./Modules/booking"
import User from "./Modules/user"
import Event from "./Modules/event"
import TypesRoutes from "./Modules/type"
import Guest from "./Modules/guest"
import Settings from "./Modules/settings"
import Admin from "./Modules/admin"
import Dashboard from "./Modules/dashboard"
import DealershipAdmin from "./Modules/dealershipAdmin"

// Remove in product please
import Test from "./Modules/test"

Vue.use(Router)

const routes = [
    {
        path: '/',
        name: 'login',
        component: LoginComponent
    },

    // Dealership Routes
    {...DealershipRoutes},

    // Dealership Groups Routes
    {...Groups},

    // Languages Routes
    {...LanguageRoutes},

    // Countries Routes
    {...CountriesRoutes},

    // Brands routes
    {...BrandsRoutes},

    // Vehicles routes
    {...VehiclesRoutes},

    // Company Routes
    {...Company},

    // Events Routes
    {...Event},

    // Types routes
    {...TypesRoutes},

    // Frontend Routes
    {...Booking},

    // Frontend Routes
    {...User},

    // Guest Routes
    {...Guest},

    // Settings Routes
    {...Settings},

    // Test Routes
    {...Test},

    // Admin Routes
    {...Admin},

    // Dashboard Routes
    {...Dashboard},

    {...DealershipAdmin}
]

export default new Router({
    mode: 'history',
    routes
})
