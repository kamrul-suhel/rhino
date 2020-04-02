import fn from '@/utils/function'

const defaultState = {
    disableEditing: false,
    editGuest: false,
    appointmentBooked: false,
    guest: {},
    selectedVehicles: [],
    allAppointments: [],
    color: '#000',
    vehicleType: '',
    allAppointmentTime: [],
    allSlot: [],
    selectedSlot: {},
    selectedDate: '',
    selectedSaleExecutive: {},
    bringGuest: {},
    step: 'selectModel',
    partExchange: {
    },

    confirmDetail: {}
}

const state = {
    ...defaultState
}

const mutations = {
    setAppointmentBooked(state, status) {
        state.appointmentBooked = status
    },

    setDisableEditing(state, status){
        state.disableEditing = status
    },

    setBookingGuest(state, payload) {

        const guest = {...payload.guest}
        const event = {...payload.event}

        // Update disable editing state if, guest status not 0
        if(guest.status > 0){
            state.disableEditing = true
        }

        if(guest.appointment.length > 0){
            const appointment = {...guest.appointment[0]}
            const partExchange = {
                registrationNumber:appointment.part_ex_vrm,
                makeAndModel:appointment.part_ex_vehicle,
                currentMilege:appointment.part_ex_distance,
                termCondition: true,
                noVehicleExchange:false
            }

            state.partExchange = partExchange

            if(
                (appointment.slot_id || appointment.slot_id === 0) &&
                !_.isEmpty(appointment.start) &&
                !_.isEmpty(appointment.end) &&
                appointment.user_id &&
                appointment.user_id !== 'null'
            ){
                state.selectedSlot = {
                    slotId: appointment.slot_id,
                    start: appointment.start,
                    end: appointment.end,
                    status: 'available'
                }

                state.selectedDate = moment(appointment.start).format( "YYYY-MM-DD")
            }

            // Bringing guest info
            if(!_.isEmpty(appointment.bring_guest)){
                state.bringGuest = {
                    name: appointment.bring_guest,
                    changingCar: appointment.guest_changing_car
                }
            }
        }else{
            // state.selectedDate = moment(event.start).format( "YYYY-MM-DD")
        }

        state.guest = {...guest}
    },

    setOrRemoveVehicle(state, vehicle) {
        let type = 1
        switch (state.vehicleType) {
            case 'new':
                type = 1
                break

            case 'used':
                type = 2
                break

            case 'unsure':
                type = 3
                break

        }
        const selectedVehicles = [...state.selectedVehicles]

        const isExists = _.findIndex(selectedVehicles, (currVehicle) => {
            return currVehicle.id === vehicle.id && currVehicle.condition === type
        })

        if (isExists === -1) {
            selectedVehicles.push({
                ...vehicle,
                condition: type
            })
        } else {
            _.remove(selectedVehicles, function (currentVehicle) {
                if (vehicle.id === currentVehicle.id) {
                    return currentVehicle
                }
            })
        }
        state.selectedVehicles = [...selectedVehicles]
    },

    setFrontendColor(state, brands) {
        if (brands.length === 0) {
            return
        }

        if (brands.length === 1) {
            state.color = brands[0].colour
        }
    },

    setBookingVehicleType(state, type) {
        state.vehicleType = type
    },

    setAllAppointmentTime(state, appointments) {
        state.allAppointmentTime = [...appointments]
    },

    setAllAppointmentSlots(state, slots) {
        state.allSlot = [...slots]
    },

    setSelectedSlot(state, slot) {
        state.selectedSlot = {...slot}
    },

    setBookingSelectedDate(state, date) {
        state.selectedDate = date
    },

    setBookingAppointments(state, appointments) {
        state.allAppointments = [...appointments]
    },

    setBookingSelectedSaleExecutive(state, saleExecutive) {
        state.selectedSaleExecutive = {...saleExecutive}
    },

    setBookingBringGuest(state, guest) {
        state.bringGuest = {...guest}
    },

    setPartExchange(state, partExchange) {
        state.partExchange = {...partExchange}
    },

    setBookingStep(state, step) {
        switch (step) {
            case 0:
                state.step = 'selectModel'
                break
            case 1:
                state.step = 'bookYourSlot'
                break

            case 2:
                state.step = 'partExchange'
                break

            case 3:
                state.step = 'confirmYourDetail'
                break
            case 4:
                state.step = 'bookingConfirmation'
                break
        }
    },

    updateSelectedVehicles(state, data){
        const vehicles = [...data.vehicles]
        let selectedVehicles =[]
        const guest = {...data.guest}
        if(guest.appointment.length > 0){
            const appointment = {...guest.appointment[0]}
            if(appointment.vehicles.length > 0){
                let type = ''
                switch (appointment.vehicles[0].vehicle_condition) {
                    case 0:
                    case 1:
                        type = 'new'
                        break

                    case 2:
                        type = 'used'
                        break

                    case 3:
                        type = 'unsure'
                        break
                }

                state.vehicleType = type

                _.map(vehicles, (vehicle) => {
                    _.map(appointment.vehicles, (currentVehicle) => {
                        if(currentVehicle.vehicle_id === vehicle.vehicle_id){
                            selectedVehicles.push({
                                ...vehicle,
                                appointment_vehicle_id : currentVehicle.id,
                                condition: currentVehicle.vehicle_condition
                            })
                        }
                    })
                })
            }
        }

        state.selectedVehicles = [...selectedVehicles]
    },

    updatedSelectedSaleExecutive(state, data){
        const guest = {...data.guest}
        if(guest.appointment.length > 0){
            const appointment = {...guest.appointment[0]}
            if(
                appointment.user_id &&
                appointment.user_id !== '' &&
                appointment.user_id !== 'null'
            ){
                _.map(data.saleExecutives, (currentSaleExecutive) => {
                    if(currentSaleExecutive.id === appointment.user_id){
                        state.selectedSaleExecutive = {
                            ...currentSaleExecutive,
                            selected: 'selected'
                        }
                    }
                })

                // Now generate slot
                let allSlots = []

                const time = fn.getStartTimeEndTime(
                    moment(appointment.start).format('YYYY-MM-DD'),
                    data.dealership
                )
                const slots = fn.getTimeSlotsForDay(time, data.event)
                let modifySlots = []
                _.map(slots, (slot) => {
                    if(slot.slotId === appointment.slot_id){
                        modifySlots.push({
                            ...slot,
                            status: 'selected'
                        })
                    }else{
                        modifySlots.push({
                            ...slot
                        })
                    }
                })
                state.allSlot = [...modifySlots]
            }
        }
    },

    setEditGuest(state, status){
        state.editGuest = status
    }

}

const getters = {
    getAppointmentBooked() {

    },

    getDisableEditing(state){
        return state.disableEditing
    },

    getBookingGuest(state) {
        return state.guest
    },

    getBookingSelectedVehicles(state) {
        return state.selectedVehicles
    },

    getFrontendColor(state) {
        return state.color
    },

    getBookingVehicleType(state) {
        return state.vehicleType
    },

    getAllAppointmentSlot(state) {
        return state.allSlot
    },

    getAllAppointmentTime(state) {
        return state.allAppointmentTime
    },

    getSelectedSlot(state) {
        return state.selectedSlot
    },

    getBookingSelectedDate(state) {
        return state.selectedDate
    },

    getAllBookingAppointments(state) {
        return state.allAppointments
    },

    getBookingSelectedSaleExecutive(sate) {
        return sate.selectedSaleExecutive
    },

    getBookingBringGuest(state) {
        return state.bringGuest
    },

    getBookingPartExchange(state) {
        return state.partExchange
    },

    getBookingStep(state) {
        return state.step
    },

    getEditGuest(state){
        return state.editGuest
    }
}

const actions = {
    fetchGuestBookingData({commit, dispatch}, payload) {
        const URL = `/booking`
        axios.get(URL).then((response) => {
            if (response.data.success) {

                if(
                    payload.languageId == null &&
                    typeof payload.languageId === 'undefined'
                ){
                    payload = {
                        ...payload,
                        languageId: response.data.language.id
                    }
                    dispatch('fetchSettingFields', {...payload})
                }

                const dataUrl = `/api/booking/${response.data.uniqueId}${fn.generateParams(payload)}`
                axios.get(dataUrl).then((response) => {
                    commit('setBookingGuest', {guest : response.data.guest, event: response.data.event})
                    commit('setBookingAppointments', response.data.appointments)
                    commit('updateSelectedVehicles', response.data)
                    commit('updatedSelectedSaleExecutive', response.data)
                    dispatch('setSelectedEventForFrontend', {event: response.data.event})
                    dispatch('setSelectedDealershipForFrontend', {dealership: response.data.dealership})
                    dispatch('fetchVehicleForFrontend', {vehicles: response.data.vehicles})
                    dispatch('fetchBrandForFrontend', {brands: response.data.brands})
                    dispatch('fetchSaleExecutivesForBooking', {users: response.data.saleExecutives, data: response.data})

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
