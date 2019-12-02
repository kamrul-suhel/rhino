const defaultState = {
    dealerships : [],
    selectedDealership: {},
    listHeader:[],
    loading: 'white',
    totalDealership: 0,
    dealershipListRowPerPage: [15,25,40],

    // Relation between dealership & brand
    brands:[],
    totalBrands: 0
}

const state = {
    ...defaultState
}

const mutations = {
    setDealerships(state, dealerships){
        state.dealerships = [...dealerships]
    },

    setDealershipLoading(state, status){
        state.loading = status
    },

    setSelectedDealership(state, dealership){
        state.selectedDealership = {...dealership}
    },

    setTotalDealership(state, totalDealership){
        state.totalDealership = totalDealership
    },

    resetDealershipStore(state){
        state = {...defaultState}
    },

    setDealershipListHeader(state, trans){
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.country,
                value: 'country'
            },

            {
                text: trans.group,
                value: 'group'
            },

            {
                text: trans.status,
                value: 'status'
            },

            {
                text: trans.action,
                value: 'action',
                align: 'right'
            }
        ]

        state.listHeader = header
    }
}

const getters = {
    getDealerships(state){
        return state.dealerships
    },

    getDealershipListHeader(state){
        return state.listHeader
    },

    getDealershipLoading(state){
        return state.loading
    },

    getDealershipListRowsPerPage(state){
        return state.dealershipListRowPerPage
    },

    getSelectedDealership(state){
        return state.selectedDealership
    },

    getTotalDealership(state){
        return state.totalDealership
    },

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
    fetchDealerships({commit}, payload = {}) {

        console.log('paginage option is: ', payload);

        // Set loading is true
        commit('setDealershipLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setDealershipListHeader', payload.trans)

        const params = generateParams(payload)
        const URL = '/api/dealerships' + params

        axios.get(URL).then((response) => {
            if (response.data.dealership) {
                commit('setDealerships', response.data.dealership)
                commit('setTotalDealership', response.data.total)
                commit('setDealershipLoading', false)
            }
        });
    },

    /**
     * Get Selected Dealership
     * @param id // required
     */
    fetchDealership({commit, dispatch}, payload){
        const URL = `/api/dealerships/${payload.id}/show`
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedDealership', response.data.dealership)
                dispatch('fetchRegions', {id: response.data.dealership.country_id})
            }
        }).catch((error)=>{
            // Generate error message
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

    if(payload.sortBy && typeof(payload.sortBy) != 'undefined'){
        params += '&sortBy='+payload.sortBy
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
