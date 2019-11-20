import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../pages/login/LoginComponent'
import * as Dealership from '../pages/Dealership/index.js'

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
                name: 'listDealership',
                component: Dealership.List
            },

            {
                path: 'create',
                name: 'addDealership',
                component: Dealership.Create
            },

            {
                path: ':id/edit',
                name: 'editDealership',
                component: Dealership.List
            }
        ]
    }
]

export default new Router({
    mode: 'history',
    routes
})
