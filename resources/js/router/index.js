import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../pages/login/LoginComponent'
import * as Dealership from '../pages/Dealership/index'
import * as Countries from '../pages/country/index'
import * as Language from '../pages/Language/index'
import * as Brands from '../pages/Brands/index'

Vue.use(Router)

const routes = [
    {
        path: '/',
        name: 'login',
        component: LoginComponent
    },

    {
        path: '/dealerships',
        name: 'dealerships',
        component: Dealership.Root,
        children: [
            {
                path: '',
                name: 'listDealerships',
                component: Dealership.List
            },

            {
                path: 'create',
                name: 'addDealerships',
                component: Dealership.Create
            },

            {
                path: ':id/edit',
                name: 'editDealerships',
                component: Dealership.List
            }
        ]
    },

    {
        path: '/countries',
        name: 'countries',
        component: Countries.Root,
        children:[
            {
                path:'',
                name: 'listCountries',
                component: Countries.List,
            },

            {
                path:'create',
                name: 'createCountries',
                component: Countries.Create,
            },

            {
                path:':id/edit',
                name: 'editCountries',
                component: Countries.Edit,
            }
        ]
    },

    {
        path: '/languages',
        name: 'languages',
        component: Language.Root,
        children:[
            {
                path:'',
                name: 'listLanguages',
                component: Language.List,
            }
        ]
    },

    {
        path: '/brands',
        name: 'brands',
        component: Brands.Root,
        children:[
            {
                path:'',
                name: 'listBrands',
                component: Brands.List,
            },

            {
                path:'create',
                name: 'createBrands',
                component: Brands.Create,
            },

            {
                path:':id/edit',
                name: 'editBrands',
                component: Brands.Edit,
            }
        ]
    }
]

export default new Router({
    mode: 'history',
    routes
})
