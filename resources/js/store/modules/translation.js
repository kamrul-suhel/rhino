import fn from '../../utils/function'

const defaultState = {
    translations: [],
    listHeader: [],
    loading: 'white',
    totalTranslation: 0,
    translationListRowPerPage: [15, 25, 40]
}

const state = {
    ...defaultState
}

const mutations = {
    setTranslation(state, translations) {
        state.translations = [...translations]
    },


    setTranslationLoading(state, status) {
        state.loading = status
    },

    setTotalTranslation(state, totalTranslation) {
        state.totalTranslation = totalTranslation
    },

    resetTranslationStore(state) {
        state = {...defaultState}
    },

    setTranslationListHeader(state, trans) {
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.value,
                value: 'value'
            }
        ]

        state.listHeader = [...header]
    }
}

const getters = {
    getTranslations(state) {
        return state.translations
    },

    getTranslationListHeader(state) {
        return state.listHeader
    },

    getTranslationLoading(state) {
        return state.loading
    },

    getTranslationListRowsPerPage(state) {
        return state.translationListRowPerPage
    },

    getTotalTranslation(state) {
        return state.totalTranslation
    }

}

const actions = {
    /**
     * You can filter by status
     * sent type= 'active' | 'inactive'
     * ...this.pagination // Default pagination object
     * trans: translation object, // Important
     * paginate: true, // If you want all record, do not sent
     * search: optional | if search by any text
     * @param commit
     * @param payload
     */
    fetchTranslations({commit, dispatch}, payload = {}) {

        // Set loading is true
        commit('setTranslationLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setTranslationListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/settings/translations${params}`

        axios.get(URL).then((response) => {
            if (response.data.translations) {
                commit('setTranslation', response.data.translations)
                commit('setTotalTranslation', response.data.total)
                commit('setTranslationLoading', false)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
