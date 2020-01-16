import fn from '../../utils/function'

const defaultState = {
    guests: [],
    selectedGuest: {},
    listHeader: [],
    loading: 'white',
    totalGuests: 0,
    guestListRowPerPage: [15, 25, 40],

    // For dropdown
    guestsDropDown: []
}

const state = {
    ...defaultState
}

const mutations = {
    setGuests(state, guests) {
        state.guests = [...guests]
    },

    setGuestsForDropDown(state, guests) {
        state.guestsDropDown = [...guests]
    },

    setGuestLoading(state, status) {
        state.loading = status
    },

    setSelectedGuest(state, guest) {
        state.selectedGuest = {...guest}
    },

    setTotalGuests(state, totalGuest) {
        state.totalGuests = totalGuest
    },

    resetGuestStore(state) {
        state = {...defaultState}
    },

    setGuestListHeader(state, trans) {
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.email,
                align: 'left',
                sortable: false,
                value: 'email'
            },

            {
                text: trans.mobile,
                value: 'mobile'
            },

            {
                text: trans.address,
                value: 'address'
            },

            {
                text: 'Unique ID',
                value: 'uniqueId'
            },

            {
                text: trans.status,
                value: 'status'
            },

            {
                text: trans.actions,
                value: 'actions',
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    }
}

const getters = {
    getGuests(state) {
        return state.guests
    },

    getGuestsForDropDown(state) {
        return state.guestsDropDown
    },

    getGuestListHeader(state) {
        return state.listHeader
    },


    getGuestLoading(state) {
        return state.loading
    },

    getGuestListRowsPerPage(state) {
        return state.guestListRowPerPage
    },

    getSelectedGuest(state) {
        return state.selectedGuest
    },

    getTotalGuests(state) {
        return state.totalGuests
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
    fetchGuests({commit}, payload = {}) {

        // Set loading is true
        commit('setGuestLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setGuestListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/guests${params}`

        axios.get(URL).then((response) => {
            if (response.data.guests) {
                commit('setGuests', response.data.guests)
                commit('setTotalGuests', response.data.total)
                commit('setGuestLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchGuest({commit, dispatch}, payload) {
        const URL = `/api/guests/${payload.id}` + fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setSelectedGuest', response.data.guest)
            }
        }).catch((error) => {
            // Generate error message
        })
    },

    fetchGuestForDropDown({commit}, payload = {}) {
        const URL = `/api/guests/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setGuestsForDropDown', response.data)
            }
        })
        .catch((error) => {

        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
