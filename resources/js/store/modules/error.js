const defaultState = {
    error: false,
    errorMessage: []
}

const state = {
    ...defaultState
}

const mutations = {
    setAppError(state, status){
        state.error = status
    },

    setAppErrorMessages(state, messages){

    }

}

const getters = {
    getAppError(state){
        return state.error
    },

    getAppErrorMessages(state){
        return state.errorMessage
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
