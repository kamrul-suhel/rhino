import fn from '../../utils/function'

const defaultState = {
    regions : [],
    selectedRegion: {},
    listHeader:[],
    loading: 'white',
    totalRegions: 0,
    brandListRowPerPage: [15,25,40]
}

const state = {
    ...defaultState
}

const mutations = {
    setRegions(state, regions){
        state.regions = [...regions]
    },

    setRegionLoading(state, status){
        state.loading = status
    },

    setSelectedRegion(state, brand){
        state.selectedRegion = {...brand}
    },

    setTotalRegions(state, totalRegion){
        state.totalRegions = totalRegion
    },

    resetRegionStore(state){
        state = {...defaultState}
    },

    setRegionListHeader(state, trans){
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
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

        state.listHeader = header
    }
}

const getters = {
    getRegions(state){
        return state.regions
    },

    getRegionListHeader(state){
        return state.listHeader
    },

    getRegionLoading(state){
        return state.loading
    },

    getRegionListRowsPerPage(state){
        return state.brandListRowPerPage
    },

    getSelectedRegion(state){
        return state.selectedRegion
    },

    getTotalRegions(state){
        return state.totalRegions
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
    fetchRegions({commit}, payload = {}) {

        // Set loading is true
        commit('setRegionLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setRegionListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/regions${params}`

        axios.get(URL).then((response) => {
            if (response.data.regions) {
                commit('setRegions', response.data.regions)
                commit('setTotalRegions', response.data.total)
                commit('setRegionLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchRegion({commit, dispatch}, payload){
        const URL = `/api/regions/${payload.id}/show`+ fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedRegion', response.data.brand)
            }
        }).catch((error)=>{
            // Generate error message
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
