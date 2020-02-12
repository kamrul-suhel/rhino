const defaultState = {
    analyticsData : []
}

const state = {
    ...defaultState
}

const mutations = {
    setAnalyticsData(state, analyticsData){
        state.analyticstData = {...analyticsData}
    },
}

const getters = {
    getAnalyticsData(state){
        return state.analyticstData
    },

}

const actions = {
    fetchAnalytics({commit}, payload = {}) {

        const URL = `/api/events/${payload.eventId}/analytics`

        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setAnalyticsData', response.data)
                console.log(response.data);
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
