const defaultState = {
    guest: {},
    selectedVehicles:[],
    color: '#000'
}

const state = {
    ...defaultState
}

const mutations = {
    setBookingGuest(state, guest){
        state.guest = {...guest}
    },

    setOrRemoveVehicle(state, vehicle){
        const selectedVehicles = state.selectedVehicles

    },

    setFrontendColor(state, brands){
        if(brands.length === 0){
            return
        }

        if(brands.length === 1){
            state.color = brands[0].colour
        }
    }
}

const getters = {
    getBookingGuest(state){
        return state.guest
    },

    getBookingSelectedVehicles(state){
        return state.selectedVehicles
    },

    getFrontendColor(state){
        return state.color
    }
}

const actions = {
    fetchGuestBookingData({commit, dispatch}, payload){
        const URL = `/booking`
        axios.get(URL).then((response)=>{
            if(response.data.success){
                const dataUrl = `/api/booking/${response.data.uniqueId}`
                axios.get(dataUrl).then((response) => {
                    commit('setBookingGuest', response.data.guest)
                    dispatch('setSelectedEventForFrontend', {event: response.data.event})
                    dispatch('setSelectedDealershipForFrontend', {dealership: response.data.dealership})
                    dispatch('fetchVehicleForFrontend', {vehicles: response.data.vehicles})
                    dispatch('fetchBrandForFrontend', {brands: response.data.brands})

                    // set frontend color
                    commit('setFrontendColor', response.data.brands)
                })
            }
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
