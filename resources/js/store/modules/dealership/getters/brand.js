export default {
    getBrandsByDealership(state){
        return state.brands
    },

    getTotalBrandsByDealership(state){
        return state.totalBrands
    },

    getListHeaderForBrandDealership(state){
        return state.listHeaderForBrand
    },

    getBrandDealershipListRowPerPage(state){
        return state.brandDealershipListRowPerPage
    },

    getSelectedBrandDealership(state){
        return state.selectedBrands
    },

    getBrandDealershipLoading(state){
        return state.brandDealershipLoading
    },

    getInitializeBrands(state){
        return state.initializeBrands
    }
}
