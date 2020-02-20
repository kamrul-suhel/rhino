const defaultState = {
    dialog: false,
    appointment: {}

}

const state = {
    ...defaultState
}

const mutations = {
    setAssignToSaleExecutiveDialog(state, status) {
        state.dialog = status
    },
    setAssignToSaleExecutiveAppointment(state, appointment) {
        state.appointment = {...appointment}
    }
}

const getters = {
    getAssignToSaleExecutiveDialog(state) {
        return state.dialog
    },

    getAssignToSaleExecutiveAppointment(state) {
        return state.appointment
    }
}


export default {
    state,
    mutations,
    getters
}
