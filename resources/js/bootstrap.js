window._ = require('lodash');

window.axios = require('axios');
window.moment = require('moment');

const token = document.head.querySelector('meta[name="csrf-token"]');

window.axios.defaults.headers.common = {
    'X-CSRF-Token': token.content,
    'X-Requested-With': 'XMLHttpRequest',
    'API-Token' : '8c4955934af8524c934904d699d1c344'
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
import Vuex from 'vuex'


/**
 * Import Global component
 */

import * as Global from './components/index'

Vue.component('r-button', Global.default.Button)
Vue.component('r-language', Global.default.Langauge)
Vue.component('Flag', Global.default.Flag)

/**
 * Import plugins
 */
import ImageUploader from 'vue-image-upload-resize'

import * as CONST from './utils/const'

/**
* Import filter
*/
import './filters/index'


import router from './router'

/**
 * Import flag-icon
 */
import 'flag-icon-css/css/flag-icon.css'

Vue.use(Vuetify)
Vue.use(Vuex)
Vue.use(ImageUploader)
Vue.config.productionTip = true

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */


import App from './components/App'
import store from './store'


/* eslint-disable no-new */
new Vue({
    el: '#app',
    store,
    router,
    components: {
        App
    },
    template: '<App/>',

    created() {
        this.initSetting();
    },

    methods: {
        initSetting() {
            // Setup translation fields
            this.$store.dispatch('fetchSettingFields').then(() => {
                this.$store.dispatch('fetchLanguages').then(() => {
                    this.$store.commit('setLoadSettingLanguage', true)
                })
            })
        }
    }
})
