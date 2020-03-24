import fn from '../../utils/function'

const defaultState = {
    selectedSale: {},
    listHeader: [],
    sales:[],
    loading: 'white',
    totalSales: 0,
    saleListRowPerPage: [15, 25, 40],
}

const state = {
    ...defaultState
}

const mutations = {
    setSales(state, sales) {
        state.sales = [...sales]
    },


    setSelectedSale(state, sale) {
        state.selectedSale = {...sale}
    },

    setSaleLoading(state, status) {
        state.loading = status
    },

    setTotalSales(state, totalSales) {
        state.totalSales = totalSales
    },

    setSaleListHeader(state, trans) {
        const header = [
            {
                text: trans.name,
                value: 'name',
                sortable: false,
            },

            {
                text: trans.appointment,
                align: 'left',
                sortable: false,
                value: 'appointment'
            },

            {
                text: trans.complete,
                align: 'left',
                sortable: false,
                value: 'complete'
            },

            {
                text: trans.actions,
                value: 'actions',
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    },
}

const getters = {
    getSales(state) {
        return state.sales
    },

    getSaleListHeader(state) {
        return state.listHeader
    },

    getSaleLoading(state) {
        return state.loading
    },

    getSaleListRowsPerPage(state) {
        return state.saleListRowPerPage
    },

    getSelectedSale(state) {
        return state.selectedSale
    },

    getTotalSales(state) {
        return state.totalSales
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
    fetchSales({commit, dispatch}, payload = {}) {

        // Set loading is true
        commit('setSaleLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setSaleListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/sales/${params}`

        axios.get(URL).then((response) => {
            if (response.data.brands) {
                commit('setSales', response.data.sales)
                commit('setTotalSales', response.data.total)
                commit('setSaleLoading', false)
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
