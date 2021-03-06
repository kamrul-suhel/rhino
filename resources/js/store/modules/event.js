import fn from '../../utils/function'

const defaultState = {
    events: [],
    selectedEvent: {},
    listHeader: [],
    loading: 'white',
    totalEvents: 0,
    eventListRowPerPage: [15, 25, 40],

    // For dropdown
    eventsDropDown: [],

    // Regions variable
    brands: [],
    totalBrands: 0,
    eventBrandHeader: [],
    selectedEventBrand: {}

}

const state = {
    ...defaultState
}

const mutations = {
    setEvents(state, events) {
        state.events = [...events]
    },

    setEventsForDropDown(state, events) {
        state.eventsDropDown = [...events]
    },

    setSelectedEventRegion(state, selectedRegion) {
        state.selectedEventRegion = selectedRegion
    },

    setRegionsByEventId(state, regions) {
        state.regions = [...regions]
    },

    setTotalRegionByEventId(state, totalRegion) {
        state.totalRegions = totalRegion
    },

    setEventLoading(state, status) {
        state.loading = status
    },

    setSelectedEvent(state, event) {
        state.selectedEvent = {...event}
    },

    setTotalEvents(state, totalEvent) {
        state.totalEvents = totalEvent
    },

    resetEventstore(state) {
        state = {...defaultState}
    },

    setEventListHeader(state, payload) {
        const trans = {...payload.trans}

        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.country,
                align: 'left',
                sortable: false,
                value: 'country'
            },

            {
                text: trans.dealership,
                align: 'left',
                sortable: false,
                value: 'dealership'
            },

            {
                text: trans.date,
                align: 'left',
                sortable: false,
                value: 'date'
            },


            {
                text: trans.appointmentDuration,
                value: 'appointment_duration'
            },

            {
                text: `${trans.eventType}`,
                align: 'left',
                sortable: false,
                value: 'type'
            },

            {
                text: trans.actions,
                value: 'actions',
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    },

    setEventBrandListHeader(state, trans) {
        const header = [
            {
                text: trans.brand,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.company,
                value: 'company',
                sortable: false
            },

            {
                text: trans.logo,
                value: 'logo',
                sortable: false
            },

            {
                text: trans.action,
                align: 'right',
                value: 'actions',
                sortable: false
            }
        ]

        state.eventBrandHeader = [...header]
    },

    setEventBrands(state, brands) {
        state.brands = [...brands]
    }
}

const getters = {
    getEvents(state) {
        return state.events
    },

    getEventsForDropDown(state) {
        return state.eventsDropDown
    },

    getEventListHeader(state) {
        return state.listHeader
    },

    getSelectedEventRegion(state) {
        return state.selectedEventRegion
    },

    getEventBrandListHeader(state) {
        return state.eventBrandHeader
    },

    getEventLoading(state) {
        return state.loading
    },

    getEventListRowsPerPage(state) {
        return state.eventListRowPerPage
    },

    getSelectedEvent(state) {
        return state.selectedEvent
    },

    getTotalEvents(state) {
        return state.totalEvents
    },

    getRegionByEventId(state) {
        return state.regions
    },

    getTotalRegionByEventId(state) {
        return state.totalRegions
    },

    getEventBrands(state) {
        return state.brands
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
    fetchEvents({commit, dispatch}, payload = {}) {

        // Set loading is true
        commit('setEventLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setEventListHeader', {trans: payload.trans})


        const params = fn.generateParams(payload)
        const URL = `/api/events${params}`

        axios.get(URL).then((response) => {
            if (response.data.events) {
                commit('setEvents', response.data.events)
                commit('setTotalEvents', response.data.total)
                commit('setEventLoading', false)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchEvent({commit, dispatch}, payload = {}) {
        const URL = `/api/events/${payload.id}` + fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setSelectedEvent', response.data.event)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },

    fetchEventForDropDown({commit, dispatch}, payload = {}) {
        const URL = `/api/events/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setEventsForDropDown', response.data.events)

                // Initialize state select first event
                if (
                    payload.selectFirst &&
                    payload.selectFirst !== 'undefined' &&
                    response.data.events.length > 0 // And event is exists
                ) {
                    const event = response.data.events[0]
                    commit('setSelectedEvent', event)
                    dispatch('fetchGuestForDropDown', {eventId: event.id})
                }
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },

    /**
     * Get brands detail by event
     * @param commit
     * @param payload
     */
    fetchBrandsByEventId({commit, dispatch}, payload = {}) {
        // Set loading is true
        commit('setEventLoading', payload.themeOption.loadingColor)
        // Setup header for list view
        commit('setEventBrandListHeader', payload.trans)

        const params = fn.generateParams(payload)

        const URL = `/api/events/${payload.eventId}/brands${params}`

        axios.get(URL).then((response) => {
            if (response.data.brands) {
                commit('setEventBrands', response.data.brands)
                commit('setTotalEvents', response.data.total)
                commit('setEventLoading', false)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },


    /**
     * Booking for frontend set selected event
     */

    setSelectedEventForFrontend({commit}, payload) {
        commit('setSelectedEvent', payload.event)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
