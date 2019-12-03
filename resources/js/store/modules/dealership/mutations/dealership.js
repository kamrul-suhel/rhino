import defaultState from "../state";

export default {
    setDealerships(state, dealerships){
        state.dealerships = [...dealerships]
    },

    setDealershipLoading(state, status){
        state.loading = status
    },

    setSelectedDealership(state, dealership){
        state.selectedDealership = {...dealership}
    },

    setSelectedDealershipBrand(state, brand){
        state.selectedBrands = {...brand}
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
