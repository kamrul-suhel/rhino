import fn from "../../utils/function";

const state = {
    languages: [],
    selectedLanguage: {},
    subSelectedLanguage: {},

    /**
     * For language CRUD
     */
    languagesCRUD: [],
    listHeader: [],
    loading: 'white',
    totalLanguages: 0,
    languageListRowPerPage: [15, 25, 40],
}

const mutations = {
    setLanguages(state, languages) {
        state.languages = [...languages]
    },

    setLanguageCRUD(state, languages){
        state.languagesCRUD = [...languages]
    },

    setSelectedLanguage(state, language) {
        state.selectedLanguage = {...language}
    },

    setSubSelectedLanguage(state, language) {
        state.subSelectedLanguage = language
    },

    setSubSelectedLanguageById(state, languageId) {
        const selectedLanguage = _.find(state.languages, (language) => {
            return language.id === languageId
        })
    },

    setLanguageListHeader(state, trans) {
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: `${trans.code} 2`,
                align: 'left',
                sortable: false,
                value: 'code2'
            },

            {
                text: `${trans.code} 3`,
                value: 'code3'
            },

            {
                text: `${trans.status}`,
                value: 'status'
            },

            {
                text: trans.actions,
                value: 'actions',
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    },

    setTotalLanguage(state, totalLanguage) {
        state.totalLanguages = totalLanguage
    },

    setLanguageLoading(state, loading) {
        state.loading = loading
    },
}

const getters = {
    getLanguages(state) {
        return state.languages
    },

    getLanguageCRUD(){
        return state.languagesCRUD
    },

    getSelectedLanguage(state) {
        return state.selectedLanguage
    },

    getSubSelectedLanguage(state) {
        return state.subSelectedLanguage
    },

    getLanguagesListHeader(state) {
        return state.listHeader
    },

    getLanguageLoading(state) {
        return state.loading
    },

    getLanguageListRowsPerPage(state) {
        return state.languageListRowPerPage
    },

    getTotalLanguage(state) {
        return state.totalLanguages
    }
}

const actions = {

    fetchLanguagesForCRUD({commit}, payload = {}) {

        // Set loading is true
        commit('setLanguageLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setLanguageListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/languages${params}`

        axios.get(URL).then((response) => {
            if (response.data.languages) {
                commit('setLanguageCRUD', response.data.languages)
                commit('setTotalLanguage', response.data.total)
                commit('setLanguageLoading', false)
            }
        });
    },

    /**
     * You can filter by status
     * sent type= 'active' | 'inactive'
     * @param commit
     * @param payload
     */
    fetchLanguages({commit}, payload = {}) {
        return new Promise((resolve, reject) => {
            const params = typeof (payload.type) != 'undefined' ? '?type=' + payload.type : '';
            const URL = '/api/languages' + params

            axios.get(URL).then((response) => {
                commit('setLanguages', response.data)
                resolve()
            })
        })
    },

    fetchSubLanguage({commit}, payload = {}) {
        const URL = `/api/languages/${payload.id}/show`
        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setSubSelectedLanguage', response.data.language)
            }
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
