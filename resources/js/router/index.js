import Vue from 'vue'
import Router from 'vue-router'
import LoginComponent from '../components/pages/login/LoginComponent'

Vue.use(Router)

const routes = [
    {
        path: '/',
        name: 'login',
        component: LoginComponent
    }
]

export default new Router({
    mode: 'history',
    routes
})
