import fn from '../../utils/function'

const defaultState = {
    brands: [],
    selectedBrand: {},
    listHeader: [],
    loading: 'white',
    totalBrands: 0,
    brandListRowPerPage: [15, 25, 40],

    // For dropdown
    brandsDropDown: [],

    // Regions variable
    regions: [],
    totalRegions: 0,
    brandRegionHeader: [],
    selectedBrandRegion: {}
}

const state = {
    ...defaultState
}

const mutations = {
    setBrands(state, brands) {
        state.brands = [...brands]
    },

    setBrandsForDropDown(state, brands) {
        state.brandsDropDown = [...brands]
    },

    setSelectedBrandRegion(state, selectedRegion) {
        state.selectedBrandRegion = selectedRegion
    },

    setRegionsByBrandId(state, regions) {
        state.regions = [...regions]
    },

    setTotalRegionByBrandId(state, totalRegion) {
        state.totalRegions = totalRegion
    },

    setBrandLoading(state, status) {
        state.loading = status
    },

    setSelectedBrand(state, brand) {
        state.selectedBrand = {...brand}
    },

    setTotalBrands(state, totalBrand) {
        state.totalBrands = totalBrand
    },

    resetBrandStore(state) {
        state = {...defaultState}
    },

    setBrandListHeader(state, trans) {
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.company,
                align: 'left',
                sortable: false,
                value: 'company'
            },

            {
                text: trans.status,
                value: 'status'
            },

            {
                text: trans.actions,
                value: 'actions',
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    },

    setBrandRegionsListHeader(state, trans) {
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },
            {
                text: trans.country,
                value: 'country',
                sortable: false
            },
            {
                text: trans.action,
                align: 'right',
                value: 'actions',
                sortable: false
            }
        ]

        state.brandRegionHeader = [...header]
    }
}

const getters = {
    getBrands(state) {
        return state.brands
    },

    getBrandsForDropDown(state) {
        return state.brandsDropDown
    },

    getBrandListHeader(state) {
        return state.listHeader
    },

    getSelectedBrandRegion(state) {
        return state.selectedBrandRegion
    },

    getBrandRegionListHeader(state) {
        return state.brandRegionHeader
    },

    getBrandLoading(state) {
        return state.loading
    },

    getBrandListRowsPerPage(state) {
        return state.brandListRowPerPage
    },

    getSelectedBrand(state) {
        return state.selectedBrand
    },

    getTotalBrands(state) {
        return state.totalBrands
    },

    getRegionByBrandId(state) {
        return state.regions
    },

    getTotalRegionByBrandId(state) {
        return state.totalRegions
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
    fetchBrands({commit}, payload = {}) {

        // Set loading is true
        commit('setBrandLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setBrandListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/brands${params}`

        axios.get(URL).then((response) => {
            if (response.data.brands) {
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
    fetchBrand({commit, dispatch}, payload) {
        const URL = `/api/brands/${payload.id}/show` + fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setSelectedBrand', response.data.brand)
            }
        }).catch((error) => {
            // Generate error message
        })
    },

    fetchRegionByBranId({commit}, payload = {}) {
        // Set loading is true
        commit('setBrandLoading', payload.themeOption.loadingColor)

        commit('setBrandRegionsListHeader', payload.trans)
        const params = fn.generateParams(payload)

        const URL = `/api/brands/${payload.id}/regions${params}`
        axios.get(URL).then((response) => {
            if (response.data.regions) {
                commit('setRegionsByBrandId', response.data.regions)
                commit('setTotalRegionByBrandId', response.data.total)
                commit('setBrandLoading', false)
            }
        })
    },

    fetchBrandForDropDown({commit}, payload = {}) {
        const URL = `/api/brands/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response) => {
            if (response.data) {                
                commit('setBrandsForDropDown', response.data)
            }
        })
            .catch((error) => {

            })
    },

    /**
     * Load Brand for event specific
     * Relation between event dealership
     * @param commit
     * @param payload
     */
    fetchBrandForEvent({commit}, payload = {}) {
        const URL = `/api/events/${payload.id}/brands/dropdown`

        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setBrandsForDropDown', response.data)
            }
        })
            .catch((error) => {

            })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
