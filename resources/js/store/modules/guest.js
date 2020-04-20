import fn from '../../utils/function'

const defaultState = {
    guests: [],
    selectedGuest: {},
    guestDetail:{},
    listHeader: [],
    loading: 'white',
    totalGuests: 0,
    guestListRowPerPage: [15, 25, 40],

    // For dropdown
    guestsDropDown: [],

    initialize: false
}

const state = {
    ...defaultState
}

const mutations = {
    setGuests(state, guests) {
        state.guests = [...guests]
    },

    setInitializeGuest(state){
      state.initialize = !state.initialize
    },

    setGuestDetail(state, detail){
        state.guestDetail = {...detail}
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

    setGuestListHeader(state, payload) {
        const trans = {...payload.trans}
        let header = []
        if(payload.eventSale && payload.eventSale !== 'undefined'){
            header = [
                {
                    text: trans.name,
                    align: 'left',
                    sortable: false,
                    value: 'name'
                },

                {
                    text: trans.appointment,
                    align: 'left',
                    sortable: false,
                    value: 'appointment'
                },

                {
                    text: trans.letterSent,
                    align: 'left',
                    sortable: false,
                    value: 'letter'
                },


                {
                    text: trans.complete,
                    align: 'right',
                    sortable: false,
                    value: 'complete'
                }
            ]
        }else{
            header = [
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
                    text: trans.actions,
                    value: 'actions',
                    align: 'right'
                }
            ]
        }

        state.listHeader = [...header]
    }
}

const getters = {
    getGuests(state) {
        return state.guests
    },

    getInitializeGuest(state){
        return state.initialize
    },

    getGuestsForDropDown(state) {
        return state.guestsDropDown
    },

    getGuestListHeader(state) {
        return state.listHeader
    },

    getGuestDetail(state){
        return state.guestDetail
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
        if(payload.eventSale && payload.eventSale !== 'undefined'){
            commit('setGuestListHeader', {trans: payload.trans, eventSale: true})
        }else{
            commit('setGuestListHeader', {trans: payload.trans})
        }

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
                commit('setGuestsForDropDown', response.data.guests)
                commit('setTotalGuests', response.data.total)
            }
        })
        .catch((error) => {

        })
    },

    fetchGuestDetailInfo({commit}, payload = {}) {
        const URL = `/api/guests/${payload.guestId}${fn.generateParams(payload)}`

        axios.get(URL).then((response) => {
            if (response.data.success) {
                commit('setGuestDetail', response.data.guest)
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
