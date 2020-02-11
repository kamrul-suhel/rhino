import fn from '@/utils/function'

const defaultState = {
    appointments: [],
    totalAppointment:0,
    selectedAppointment: {},
    date: null,
    appointmentUsers:[],

}

const state = {
    ...defaultState
}

const mutations = {
    setAppointments(state, appointments){
        state.appointments = [...appointments]
    },

    setTotalAppointment(state, totalAppointment){
      state.totalAppointment = totalAppointment
    },

    setSelectedAppointment(state, appointment){
        state.selectedAppointment = {...appointment}
    },

    setAppointmentDate(state, date){
        state.date = date
    },

    setAppointmentUsers(state, users){
        state.appointmentUsers = [...users]
    }
}

const getters = {
    getAppointments(state){
        return state.appointments
    },

    getTotalAppointment(state){
        return state.totalAppointment
    },

    getSelectedAppointment(state){
        return state.selectedAppointment
    },

    getAppointmentDate(state){
        return state.date
    },

    getAppointmentUsers(state){
        return state.appointmentUsers
    }
}

const actions = {
    fetchAppointmentByEventId({commit}, payload){
        const params = fn.generateParams(payload)
        const URL = `/api/appointments/${payload.eventId}${params}`

        axios.get(URL).then((response) => {
            if (response.data.appointments) {
                commit('setAppointments', response.data.appointments)
                commit('setTotalAppointment', response.data.total)
            }
        });
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
