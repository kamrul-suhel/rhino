const defaultState = {
    guest: {},
    selectedVehicles:[],
    allAppointments:[],
    color: '#000',
    vehicleType: '',
    allAppointmentTime:[],
    allSlot:[],
    selectedSlot:{},
    selectedDate:'',
    selectedSaleExecutive: {},
    bringGuest: {},
    partExchange:{
        vehicleExchange: false
    }
}

const state = {
    ...defaultState
}

const mutations = {
    setBookingGuest(state, guest){
        state.guest = {...guest}
    },

    setOrRemoveVehicle(state, vehicle){
        const selectedVehicles = [...state.selectedVehicles]

        const isExists = _.findIndex(selectedVehicles, (currVehicle) => {
            return currVehicle.id === vehicle.id
        })

        if(isExists === -1){
            selectedVehicles.push({...vehicle})
        }else{
            _.remove(selectedVehicles, function(currentVehicle) {
                if(vehicle.id === currentVehicle.id){
                    return currentVehicle
                }
            })
        }
        state.selectedVehicles = [...selectedVehicles]
    },

    setFrontendColor(state, brands){
        if(brands.length === 0){
            return
        }

        if(brands.length === 1){
            state.color = brands[0].colour
        }
    },

    setBookingVehicleType(state, type){
        state.vehicleType = type
    },

    setAllAppointmentTime(state, appointments){
        state.allAppointmentTime = [...appointments]
    },

    setAllAppointmentSlots(state, slots){
        state.allSlot = [...slots]
    },

    setSelectedSlot(state, slot){
        state.selectedSlot = {...slot}
    },

    setBookingSelectedDate(state, date){
        state.selectedDate = date
    },

    setBookingAppointments(state, appointments){
        state.allAppointments = [...appointments]
    },

    setBookingSelectedSaleExecutive(state, saleExecutive){
        state.selectedSaleExecutive = {...saleExecutive}
    },

    setBookingBringGuest(state, guest){
        state.bringGuest = {...guest}
    },

    setPartExchange(state, partExchange){
        state.partExchange = {...partExchange}
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
    },

    getBookingVehicleType(state){
        return state.vehicleType
    },

    getAllAppointmentSlot(state){
        return state.allSlot
    },

    getAllAppointmentTime(state){
        return state.allAppointmentTime
    },

    getSelectedSlot(state){
        return state.selectedSlot
    },

    getBookingSelectedDate(state){
        return state.selectedDate
    },

    getAllBookingAppointments(state){
        return state.allAppointments
    },

    getBookingSelectedSaleExecutive(sate){
        return sate.selectedSaleExecutive
    },

    getBookingBringGuest(state){
        return state.bringGuest
    },

    getBookingPartExchange(state){
        return state.partExchange
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
                    commit('setBookingAppointments', response.data.appointments)
                    dispatch('setSelectedEventForFrontend', {event: response.data.event})
                    dispatch('setSelectedDealershipForFrontend', {dealership: response.data.dealership})
                    dispatch('fetchVehicleForFrontend', {vehicles: response.data.vehicles})
                    dispatch('fetchBrandForFrontend', {brands: response.data.brands})
                    dispatch('fetchSaleExecutivesForBooking', {users: response.data.saleExecutives})

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
