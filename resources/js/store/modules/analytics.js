const defaultState = {
    analytics : {},
    totalGuest: 0,
    guestInfo: {}

}

const state = {
    ...defaultState
}

const mutations = {
    setAnalyticsData(state, analytics){
        state.analytics = {...analytics}
    },

    setAnalyticsTotalGuest(state, totalGuest){
        state.totalGuest = totalGuest
    },

    setAnalyticsGuestInfo(state, guestInfo){
        state.guestInfo = {...guestInfo}
    }
}

const getters = {
    getAnalyticsData(state){
        return state.analytics
    },

    getAnalyticsTotalGuest(state){
        return state.totalGuest
    },

    getAnalyticsTotalInfo(state){
        return state.guestInfo
    }

}

const actions = {
    fetchAnalytics({commit}, payload = {}) {

        const URL = `/api/events/${payload.eventId}/analytics`

        axios.get(URL).then((response) => {
            if (response.data.success) {
                commit('setAnalyticsData', response.data.analytics)
                commit('setAnalyticsTotalGuest', response.data.total_guest)
                commit('setAnalyticsGuestInfo', response.data.guest_info)

            }
        });
    },
}

export default {
    state,
    mutations,
    getters,
    actions
}
