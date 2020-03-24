const defaultState = {
    error: false,
    errorMessage: [],
    tokenExpired : false
}

const state = {
    ...defaultState
}

const mutations = {
    setAppError(state, status){
        state.error = status
    },

    setAppErrorMessages(state, messages){

    },

    setTokenExpired(state, status){
        state.tokenExpired = status
    },

    setAllError(state, error){
        // check token expired

    }

}

const getters = {
    getAppError(state){
        return state.error
    },

    getAppErrorMessages(state){
        return state.errorMessage
    },

    getTokenExpired(state){
        return state.tokenExpired
    }
}

const actions = {
    initializeError({state,commit}, errorObj){
        const data = errorObj.response.data
        const status = errorObj.response.status
        const headers = errorObj.response.headers

        // console.log('data is: ', data) // Enable for debug
        // console.log('status is: ', status)
        // console.log('headers is: ', headers)

        // Check is token is expired
        if(typeof data.error === "string" && data.error === 'tokenExpired') {
            commit('setTokenExpired', true)
            return
        }

    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
