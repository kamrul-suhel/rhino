import fn from "../../../../utils/function";

export default {
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
        // Set loading is true
        commit('setDealershipLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setDealershipListHeader', payload.trans)

        const params = fn.generateParams(payload)
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
        const URL = `/api/dealerships/${payload.id}/show${fn.generateParams(payload)}`
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedDealership', response.data.dealership)
                dispatch('fetchRegions', {id: response.data.dealership.country_id})
            }
        }).catch((error)=>{
            // Generate error message
        })
    },

    /**
     * Generate dealership dropdown
     * @param commit
     * @param payload
     */
    fetchDealershipsForDropdown({commit}, payload = {}) {
        const URL = '/api/dealerships/dropdown'
        axios.get(URL).then((response) => {
            if (response.data.dealership) {
                commit('setDealerships', response.data.dealership)
                commit('setTotalDealership', response.data.total)
            }
        });
    },
}
