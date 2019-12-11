import Vue from 'vue';
import Router from 'vue-router';
import LoginComponent from '../pages/login/LoginComponent';
import DealershipRoutes from './Modules/dealership';
import LanguageRoutes from './Modules/languages';
import BrandsRoutes from './Modules/brands';
import VehiclesRoutes from './Modules/vehicles';
import CountriesRoutes from './Modules/countries';
import Groups from './Modules/groups';
import Company from './Modules/company';
import Frontend from "./Modules/frontend";
import User from "./Modules/user";
import Event from "./Modules/event";
import TypesRoutes from "./Modules/type";
import Guest from "./Modules/guest";

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
    {...Frontend},

    // Frontend Routes
    {...User},

    // Guest Routes
    {...Guest}
]

export default new Router({
    mode: 'history',
    routes
})
