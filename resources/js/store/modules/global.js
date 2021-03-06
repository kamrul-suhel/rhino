const defaultState = {
    updateComponent: false,
    appointmentDialog: false,
    bookAGuestDialog: false,
    appointmentAvailable: false,
    appointmentUnavailable: false,
    appointmentDialogSlot:{}
}

const state = {
    ...defaultState
}

const mutations = {
    setUpdateComponent(state){
        state.updateComponent = !state.updateComponent
    },

    setAppointmentDialog(state, status){
        state.appointmentDialog = status
    },

    setBookAGuestDialog(state, status){
        state.bookAGuestDialog = status
    },

    setAppointmentAvailable(state, status){
        state.appointmentAvailable = status
    },

    setAppointmentUnavailable(state, status){
        state.appointmentUnavailable = status
    },

    setAppointmentDialogSlot(state, slot){
        state.appointmentDialogSlot = {...slot}
    }
}

const getters = {
    getUpdateComponent(state){
        return state.updateComponent
    },

    getAppointmentDialog(state){
        return state.appointmentDialog
    },

    getBookAGuestDialog(state){
        return state.bookAGuestDialog
    },

    getAppointmentAvailable(state){
        return state.appointmentAvailable
    },

    getAppointmentUnavailable(state){
        return state.appointmentUnavailable
    },

    getAppointmentDialogSlot(state){
        return state.appointmentDialogSlot
    }

}

const actions = {

}

export default  {
    state,
    mutations,
    getters,
    actions
}
