import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../pages/login/LoginComponent'
import Dealership from '../pages/Dealership/List'

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
        component: Dealership,
        children: [
            {
                path: '/create',
                name: 'listDealership',
                component: LoginComponent
            },

            {
                path: '/:id/edit',
                name: 'createDealership',
                component: LoginComponent
            }
        ]
    }
]

export default new Router({
    mode: 'history',
    routes
})
