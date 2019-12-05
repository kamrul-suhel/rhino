const defaultState = {
    loading: false
}

const state = {
    ...defaultState
}

const mutations = {
    setButtonLoading(state, loading){
        state.loading = loading
    }
}

const getters = {
    getButtonLoading(state){
        return state.loading
    }
}

const actions ={
    setButtonLoading({commit}, payload){
        commit('setButtonLoading', payload.loading)
    }
}

export default {
    state,
    mutations,
    getters
}
