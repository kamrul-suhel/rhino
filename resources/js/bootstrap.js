window._ = require('lodash');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

import 'babel-polyfill'


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// try {
//     window.$ = window.jQuery = require('jquery');
// } catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuex from 'vuex';


/**
 * Import plugins
 */
import ImageUploader from 'vue-image-upload-resize'

/**
 * Import filter
 */

import router from './router'
Vue.use(Vuetify);
Vue.use(Vuex);
Vue.use(ImageUploader)
Vue.config.productionTip = true

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */


import App from './components/App'
import store from './store';


/* eslint-disable no-new */
new Vue({
    el: '#app',
    store,
    router,
    components: {App},
    template: '<App/>',

    created(){
        this.initSetting();
    },

    methods: {
        initSetting(){
            // Setup translation fields
            this.$store.dispatch('getAllSettingFields');

            // Initialize language
            this.$store.dispatch('fetchLanguages')

        }
    }
})
