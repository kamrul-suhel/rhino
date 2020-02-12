import fn from '../../utils/function'

const defaultState = {
    analyticsData : [],
    selectedEvent: {},
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

        const URL = `/api/events/${payload.id}/analytics`

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
