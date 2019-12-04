export default {
    setBrandsByDealership(state, brands){
        state.brands = [...brands]
    },

    setSelectedBrandDealership(state, brandDealership){
        state.selectedBrands = {...brandDealership}
    },

    setTotalBrandByDealership(state, totalBrands){
        state.totalBrands = totalBrands
    },

    setDealershipBrandListHeader(state, trans){
        const header = [
            {
                text: trans.brand,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.country,
                value: 'country'
            },

            {
                text: trans.region,
                value: 'group'
            },

            {
                text: trans.actions,
                align:'right',
                value: 'actions'
            }
        ]

        state.listHeaderForBrand = header
    },

    setInitializeBrands(state){
        state.initializeBrands = !state.initializeBrands
    }
}
