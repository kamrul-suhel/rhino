import fn from '../../utils/function'

const defaultState = {
    vehicles : [],
    selectedVehicle: {},
    listHeader:[],
    loading: 'white',
    totalVehicles: 0,
    vehicleListRowPerPage: [15,25,40],

    brands:[],
    totalBrands: 0
}

const state = {
    ...defaultState
}

const mutations = {
    setVehicles(state, vehicles){
        state.vehicles = [...vehicles]
    },

    setSelectedBrand(state, selectedBrand){
        state.selectedBrand = selectedBrand
    },

    setVehiclesByBrandId(state, brands){
        state.brands = [...brands]
    },

    setTotalVehiclesByBrandId(state, totalBrands){
        state.totalBrands = totalBrands
    },

    setVehicleLoading(state, status){
        state.loading = status
    },

    setSelectedVehicle(state, vehicle){
        state.selectedVehicle = {...vehicle}
    },

    setTotalVehicles(state, totalVehicle){
        state.totalVehicles = totalVehicle
    },

    resetVehicleStore(state){
        state = {...defaultState}
    },

    setVehicleListHeader(state, payload){

        let header = []

        if(!payload.subComponent){
            header = [
                {
                    text: payload.trans.left,
                    align: 'left',
                    value: 'left'
                },

                {
                    text: payload.trans.right,
                    align: 'left',
                    value: 'right'
                },

                {
                    text: payload.trans.brand,
                    align: 'left',
                    value: 'brand',
                    filter: true
                },

                {
                    text: payload.trans.vehicle,
                    align: 'left',
                    value: 'vehicle'
                },

                {
                    text: payload.trans.actions,
                    value: 'actions',
                    align:'right'
                }
            ]
        }else{
            header = [
                {
                    text: payload.trans.vehicle,
                    align: 'left',
                    value: 'vehicle'
                },
                {
                    text: payload.trans.actions,
                    value: 'actions',
                    align:'right'
                }
            ]
        }

        state.listHeader = [...header]
    },
}

const getters = {
    getVehicles(state){
        return state.vehicles
    },

    getVehicleListHeader(state){
        return state.listHeader
    },

    getSelectedVehicle(state){
        return state.selectedVehicle
    },

    getVehicleBrandListHeader(state){
      return state.brandListHeader
    },

    getVehicleLoading(state){
        return state.loading
    },

    getVehicleListRowsPerPage(state){
        return state.vehicleListRowPerPage
    },

    getTotalVehicles(state){
        return state.totalVehicles
    },

    // getBrandByVehicleId(state){
    //     return state.regions
    // },

    // getTotalRegionByBrandId(state){
    //     return state.totalRegions
    // }

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
    fetchVehicles({commit, dispatch}, payload = {}) {
        // Set loading is true
        commit('setVehicleLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setVehicleListHeader', {
            trans: payload.trans,
            subComponent:  payload.subComponent
        })

        const params = fn.generateParams(payload)
        const URL = `/api/vehicles${params}`

        axios.get(URL).then((response) => {
            if (response.data.vehicles) {
                commit('setVehicles', response.data.vehicles)
                commit('setTotalVehicles', response.data.total)
                commit('setVehicleLoading', false)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },

    /**
     * Get Selected Dealership
     * @param id // required
     */
    fetchVehicle({commit, dispatch}, payload){
        const URL = `/api/vehicles/${payload.id}/show${fn.generateParams(payload)}`
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedVehicle', response.data.vehicle)
                dispatch('fetchBrands', {id: response.data.brand.id})
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
