const defaultState = {
    guest: {}
}

const state = {
    ...defaultState
}

const mutations = {
    setGuest(state, guest){
        state.guest = {...guest}
    }
}

const getters = {
    getBookingGuest(state){
        return state.guest
    }
}

const actions = {
    fetchGuestBookingData({commit, dispatch}, payload){
        const URL = `/booking`
        axios.get(URL).then((response)=>{
            if(response.data.success){
                const dataUrl = `/api/booking/${response.data.uniqueId}`
                axios.get(dataUrl).then((response) => {
                    commit('setGuest', response.data.guest)
                    dispatch('setSelectedEventForFrontend', {event: response.data.event})
                    dispatch('setSelectedDealershipForFrontend', {event: response.data.event})
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
