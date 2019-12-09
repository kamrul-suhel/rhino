const defaultState = {
    loading: false,
    identifier: ''
}

const state = {
    ...defaultState
}

const mutations = {
    setButtonLoading(state, loading){
        state.loading = loading
    },

    setButtonIdentifier(state, identifier){
        state.identifier = identifier
    }
}

const getters = {
    getButtonLoading(state){
        return state.loading
    },

    getButtonIdentifier(state){
        return state.identifier
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
