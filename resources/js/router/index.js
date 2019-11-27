import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../pages/login/LoginComponent'
import DealershipRoutes from './Modules/dealership'
import LanguageRoutes from './Modules/languages'
import BrandsRoutes from './Modules/brands'
import CountriesRoutes from './Modules/countries'
import Groups from './Modules/groups'

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
    {...BrandsRoutes}

]

export default new Router({
    mode: 'history',
    routes
})
