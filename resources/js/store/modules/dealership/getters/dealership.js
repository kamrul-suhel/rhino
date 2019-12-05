export default {
    getDealerships(state){
        return state.dealerships
    },

    getDealershipListHeader(state){
        return state.listHeader
    },

    getDealershipLoading(state){
        return state.loading
    },

    getSelectedDealershipBrand(state){
        return state.selectedBrands
    },

    getDealershipListRowsPerPage(state){
        return state.dealershipListRowPerPage
    },

    getSelectedDealership(state){
        return state.selectedDealership
    },

    getTotalDealership(state){
        return state.totalDealership
    }
}
