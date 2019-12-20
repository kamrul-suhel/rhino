import fn from '@/utils/function'

const defaultState = {
    appointments: [],
    selectedAppointment: {},
    date: null
}

const state = {
    ...defaultState
}

const mutations = {
    setAppointments(state, appointments){
        state.appointments = [...appointments]
    },

    setSelectedAppointment(state, appointment){
        state.selectedAppointment = {...appointment}
    },

    setAppointmentDate(state, date){
        state.date = date
    }
}

const getters = {
    getAppointments(state){
        return state.appointments
    },

    getSelectedAppointment(state){
        return state.selectedAppointment
    },

    getAppointmentDate(state){
        return state.date
    }
}

const actions = {
}

export default {
    state,
    mutations,
    getters,
    actions
}
