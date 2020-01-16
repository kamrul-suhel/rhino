import fn from '../../utils/function'

const defaultState = {
    specializeBrands: [],
    listHeader: [],
    loading: 'white',
    totalSpecializeBrand: 0,
    specializeListRowPerPage: [15, 25, 40]
}
const state = {
    ...defaultState
}

const mutations = {
    setSpecializeBrands(state, specializeBrands) {
        state.specializeBrands = [...specializeBrands]
    },

    setSpecializeBrandLoading(state, status) {
        state.loading = status
    },

    setTotalSpecializeBrands(state, totalSpecializeBrands) {
        state.totalSpecializeBrand = totalSpecializeBrands
    },

    setSpecializeBrandListHeader(state, trans) {

        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: true,
                value: 'name'
            },

            {
                text: trans.email,
                align: 'left',
                sortable: true,
                value: 'email'
            },

            {
                text: trans.actions,
                value: 'actions',
                sortable: false,
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    }
}

const getters = {
    getSpecializeBrands(state) {
        return state.specializeBrands
    },

    getSpecializeBrandListHeader(state) {
        return state.listHeader
    },

    getSpecializeBrandLoading(state) {
        return state.loading
    },

    getSpecializeBrandListRowsPerPage(state) {
        return state.specializeListRowPerPage
    },

    getTotalSpecializeBrand(state) {
        return state.totalSpecializeBrand
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
    fetchUsers({commit}, payload = {}) {

        // Set loading is true
        commit('setUserLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setUserListHeader', {trans: payload.trans})

        const params = fn.generateParams(payload)
        const URL = `/api/users${params}`

        axios.get(URL).then((response) => {
            if (response.data.users) {
                commit('setUsers', response.data.users)
                commit('setTotalUsers', response.data.total)
                commit('setUserLoading', false)
            }
        });
    },

    fetchUsersForEvent({commit}, payload = {}) {
        // Set loading is true
        commit('setUserLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setUserListHeader', {trans: payload.trans, subComponent: payload.subComponent})

        const params = fn.generateParams(payload)
        const URL = `/api/users/events/${payload.eventId}/dealerships/${payload.dealershipId}${params}`

        axios.get(URL).then((response) => {
            if (response.data.users) {
                commit('setUsers', response.data.users)
                commit('setTotalUsers', response.data.total)
                commit('setUserLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchUser({commit, dispatch}, payload) {
        const URL = `/api/users/${payload.id}/show${fn.generateParams(payload)}`
        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setSelectedUser', response.data.user)
            }
        }).catch((error) => {
            // Generate error message
        })
    },

    fetchUserForDropDown({commit}, payload = {}) {
        const URL = `/api/users/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setUsersForDropDown', response.data)
            }
        })
            .catch((error) => {

            })
    },

    fetchSaleExecutivesForBooking({commit}, payload){
        commit('setUsers', payload.users)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
