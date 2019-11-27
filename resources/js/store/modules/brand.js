import fn from '../../utils/function'

const defaultState = {
    brands : [],
    selectedBrand: {},
    listHeader:[],
    loading: 'white',
    totalBrands: 0,
    brandListRowPerPage: [15,25,40]
}

const state = {
    ...defaultState
}

const mutations = {
    setBrands(state, brands){
        state.brands = [...brands]
    },

    setBrandLoading(state, status){
        state.loading = status
    },

    setSelectedBrand(state, brand){
        state.selectedBrand = {...brand}
    },

    setTotalCompanies(state, totalBrand){
        state.totalBrands = totalBrand
    },

    resetBrandStore(state){
        state = {...defaultState}
    },

    setBrandListHeader(state, trans){
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
                value: 'actions'
            }
        ]

        state.listHeader = header
    }
}

const getters = {
    getBrands(state){
        return state.brands
    },

    getBrandListHeader(state){
        return state.listHeader
    },

    getBrandLoading(state){
        return state.loading
    },

    getBrandListRowsPerPage(state){
        return state.brandListRowPerPage
    },

    getSelectedBrand(state){
        return state.selectedBrand
    },

    getTotalBrands(state){
        return state.totalBrands
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
    fetchBrands({commit}, payload = {}) {

        // Set loading is true
        commit('setBrandLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setBrandListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = '/api/brands' + params

        axios.get(URL).then((response) => {
            if (response.data.companies) {
                commit('setBrands', response.data.brands)
                commit('setTotalBrands', response.data.total)
                commit('setBrandLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchBrand({commit, dispatch}, payload){
        const URL = `/api/brand/${payload.id}/show`+ fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedCompany', response.data.brand)
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
