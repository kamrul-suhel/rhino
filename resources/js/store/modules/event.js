import fn from '../../utils/function'

const defaultState = {
    events : [],
    selectedEvent: {},
    listHeader:[],
    loading: 'white',
    totalEvents: 0,
    eventListRowPerPage: [15,25,40],

    // For dropdown
    eventsDropDown: [],

    // Regions variable
    brands:[],
    totalBrands: 0,
    eventBrandHeader:[],
    selectedEventBrand:{}
}

const state = {
    ...defaultState
}

const mutations = {
    setEvents(state, events){
        state.events = [...events]
    },

    setEventsForDropDown(state, events){
        state.eventsDropDown = [...events]
    },

    setSelectedEventRegion(state, selectedRegion){
        state.selectedEventRegion = selectedRegion
    },

    setRegionsByEventId(state, regions){
        state.regions = [...regions]
    },

    setTotalRegionByEventId(state, totalRegion){
        state.totalRegions = totalRegion
    },

    setEventLoading(state, status){
        state.loading = status
    },

    setSelectedEvent(state, event){
        state.selectedEvent = {...event}
    },

    setTotalEvents(state, totalEvent){
        state.totalEvents = totalEvent
    },

    resetEventstore(state){
        state = {...defaultState}
    },

    setEventListHeader(state, trans){
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.startDate,
                align: 'left',
                sortable: false,
                value: 'startDate'
            },

            {
                text: trans.endDate,
                align: 'left',
                sortable: false,
                value: 'endDate'
            },

            {
                text: `${trans.event} ${trans.type}`,
                align: 'left',
                sortable: false,
                value: 'type'
            },

            {
                text: trans.dealership,
                align: 'left',
                sortable: false,
                value: 'dealership'
            },

            {
                text: trans.country,
                align: 'left',
                sortable: false,
                value: 'country'
            },

            {
                text: trans.status,
                value: 'status'
            },

            {
                text: trans.actions,
                value: 'actions',
                align:'right'
            }
        ]

        state.listHeader = [...header]
    },

    setEventBrandListHeader(state, trans){
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

    setEventBrands(state, brands){
        state.brands = [...brands]
    }
}

const getters = {
    getEvents(state){
        return state.events
    },

    getEventsForDropDown(state){
        return state.eventsDropDown
    },

    getEventListHeader(state){
        return state.listHeader
    },

    getSelectedEventRegion(state){
        return state.selectedEventRegion
    },

    getEventBrandListHeader(state){
      return state.eventBrandHeader
    },

    getEventLoading(state){
        return state.loading
    },

    getEventListRowsPerPage(state){
        return state.eventListRowPerPage
    },

    getSelectedEvent(state){
        return state.selectedEvent
    },

    getTotalEvents(state){
        return state.totalEvents
    },

    getRegionByEventId(state){
        return state.regions
    },

    getTotalRegionByEventId(state){
        return state.totalRegions
    },

    getEventBrands(state){
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
    fetchEvents({commit}, payload = {}) {

        // Set loading is true
        commit('setEventLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setEventListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/events${params}`

        axios.get(URL).then((response) => {
            if (response.data.events) {
                commit('setEvents', response.data.events)
                commit('setTotalEvents', response.data.total)
                commit('setEventLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchEvent({commit, dispatch}, payload={}){
        const URL = `/api/events/${payload.id}`+ fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedEvent', response.data.event)
            }
        }).catch((error)=>{
            // Generate error message
        })
    },

    fetchRegionByBranId({commit}, payload={}){
        // Set loading is true
        commit('setEventLoading', payload.themeOption.loadingColor)

        commit('setEventRegionsListHeader', payload.trans)
        const params = fn.generateParams(payload)

        const URL = `/api/events/${payload.id}/regions${params}`
        axios.get(URL).then((response)=>{
            if(response.data.regions){
                commit('setRegionsByEventId', response.data.regions)
                commit('setTotalRegionByEventId', response.data.total)
                commit('setEventLoading', false)
            }
        })
    },

    fetchEventForDropDown({commit}, payload = {}){
        const URL = `/api/events/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response)=>{
            if(response.data){
                commit('setEventsForDropDown', response.data)
            }
        })
            .catch((error)=>{

            })
    },

    /**
     * Get brands detail by event
     * @param commit
     * @param payload
     */
    fetchBrandsByEventId({commit} ,payload = {}){
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
        });
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
