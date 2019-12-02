import Vue from 'vue'
import VueI18n from 'vue-i18n'

import dateTimeFormats from './datetimeFormats'

Vue.use(VueI18n)


const i18n = new VueI18n({
    dateTimeFormats
})

export default i18n
