import fn from '../../utils/function'

const defaultState = {
    eventVehicles : [],
    selectedEventVehicle: {},
    listHeader:[],
    loading: 'white',
    totalEventVehicles: 0,
    eventVehiclesListRowPerPage: [15,25,40]
}

const state = {
    ...defaultState
}

const mutations = {
    setEventVehicles(state, vehicles){
        state.eventVehicles = [...vehicles]
    },

    setEventVehiclesLoading(state, status){
        state.loading = status
    },

    setSelectedEventVehicle(state, vehicle){
        state.selectedEventVehicle = {...vehicle}
    },

    setTotalEventVehicles(state, totalVehicle){
        state.totalEventVehicles = totalVehicle
    },

    setEventVehicleListHeader(state, trans){
        const header = [
            {
                text: trans.model,
                align: 'left',
                sortable: false,
                value: 'model'
            },

            {
                text: trans.new,
                align: 'left',
                sortable: false,
                value: 'new'
            },

            {
                text: trans.used,
                align: 'left',
                sortable: false,
                value: 'used'
            },

            {
                text: trans.image,
                align: 'left',
                sortable: false,
                value: 'image'
            },

            {
                text: trans.order,
                align: 'left',
                sortable: false,
                value: 'order'
            },

            {
                text: trans.actions,
                value: 'actions',
                align:'right'
            }
        ]

        state.listHeader = [...header]
    },

    setEventBrands(state, brands){
        state.brands = [...brands]
    }
}

const getters = {
    getEventVehicles(state){
        return state.eventVehicles
    },

    getSelectedEventVehicle(state){
        return state.selectedEventVehicle
    },

    getEventVehiclesListHeader(state){
        return state.listHeader
    },


    getEventVehiclesLoading(state){
        return state.loading
    },

    getEventVehiclesListRowsPerPage(state){
        return state.eventVehiclesListRowPerPage
    },

    getTotalEventVehicle(state){
        return state.totalEventVehicles
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
    fetchEventVehicles({commit}, payload = {}) {
        // Set loading is true
        commit('setEventVehiclesLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setEventVehicleListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/events/${payload.id}/vehicles${params}`

        axios.get(URL).then((response) => {
            if (response.data.vehicles) {
                commit('setEventVehicles', response.data.vehicles)
                commit('setTotalEventVehicles', response.data.total)
                commit('setEventVehiclesLoading', false)
            }
        });
    },

    /**
     * Vehicle for frontend
     * Load vehicles from other actions
     */
    fetchVehicleForFrontend({commit}, payload){
        commit('setEventVehicles', payload.vehicles)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
