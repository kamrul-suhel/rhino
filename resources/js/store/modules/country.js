const defaultState = {
    countries: [],
    selectedCountry: {},
    listHeader:[],
    totalCountry: 0,
    loading: 'white',
    countryListRowPerPage: [15,25,40],

    regions:[],
    selectedRegion: {}
}

const state = {
    ...defaultState
}

const mutations = {
    setCountryListRowsPerPage(state, rowsPerPage){
        // Need to send and array of object
        state.countryListRowPerPage = [...rowsPerPage]
    },

    setCountries(state, countries){
        state.countries = [...countries]
    },

    setSelectedCountry(state, country){
        state.selectedCountry = {...country}
    },

    setTotalCountry(state, totalCountry){
        state.totalCountry = totalCountry
    },

    resetCountriesStore(state){
        state = {...defaultState}
    },

    setCountryLoading(state, loading){
        state.loading = loading
    },

    setCountriesListHeader(state, trans){
        const header = [
            {
                text: trans.name,
                align: 'left',
                value: 'name'
            },

            {
                text: trans.code ,
                value: 'code',
                sortable: false,
            },

            {
                text: trans.seatingPosition,
                value: 'seating_position',
                sortable: false,
            },

            {
                text: trans.status,
                value: 'status'
            },

            {
                text: trans.action,
                value: 'action',
                align: 'right',
                sortable: false,
            }
        ]

        state.listHeader = header
    },

    setRegions(state, regions){
        state.regions = [...regions]
    }
}

const getters = {
    getCountries(state){
        return state.countries
    },

    getSelectedCountry(state){
        return state.selectedCountry
    },

    getCountriesListHeader(state){
        return state.listHeader
    },

    getTotalCountry(state){
        return state.totalCountry
    },

    getCountryLoading(state){
        return state.loading
    },

    getCountryListRowsPerPage(state){
        return state.countryListRowPerPage
    },

    getCountryRegions(state){
        return state.regions
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
    fetchCountries({commit}, payload = {}){
        // Set loading is true
        commit('setCountryLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setCountriesListHeader', payload.trans)

        const params = generateParams(payload)
        const URL = '/api/countries'+ params
        axios.get(URL).then((response)=>{
            if(response.data.data){
                commit('setCountries', response.data.data)
                commit('setTotalCountry', response.data.total)
                commit('setCountryLoading', false)
            }
        });
    },

    /**
     * Fetch countries for dropdown
     * @param commit
     * @param payload
     */
    fetchCountriesForDropdown({commit}, payload = {}){
        const URL = '/api/countries/dropdown'
        axios.get(URL).then((response)=>{
            if(response.data){
                commit('setCountries', response.data)
            }
        });
    },

    /**
     * Get Selected country & regions
     * @param id // required
     */
    fetchCountry({commit}, payload){
        const URL = `/api/countries/${payload.id}/show`
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedCountry', response.data)
            }
        }).catch((error)=>{
            // Generate error message
        })
    },

    /**
     * Regions based on country
     */

    fetchCountryRegions({commit}, payload){
        const URL = `/api/countries/${payload.id}/regions`
        axios.get(URL).then((response)=>{
            commit('setRegions', response.data)
        })
    }
}

/**
 * helper function to generate params
 * @param payload
 * @returns {string}
 */
function generateParams(payload){
    let params = '?'
    if(payload.type && typeof(payload.type) != 'undefined'){
        params += 'type='+payload.type
    }

    if(payload.rowsPerPage && typeof(payload.rowsPerPage) != 'undefined'){
        params += '&rowsPerPage='+payload.rowsPerPage
    }

    if(payload.paginate && typeof(payload.paginate) != 'undefined'){
        params += '&paginate=true'
    }

    if(payload.page && typeof(payload.page) != 'undefined'){
        params += '&page='+payload.page
    }

    if(payload.search && typeof (payload.search) != 'undefined'){
        params += '&search='+payload.search
    }

    return params
}

export default {
    state,
    mutations,
    getters,
    actions
}
