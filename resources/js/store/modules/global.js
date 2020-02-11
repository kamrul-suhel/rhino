const defaultState = {
    updateComponent: false
}

const state = {
    ...defaultState
}

const mutations = {
    setUpdateComponent(state){
        state.updateComponent = !state.updateComponent 
    }
}

const getters = {
    getUpdateComponent(state){
        return state.updateComponent
    }

}

const actions = {

}

export default  {
    state,
    mutations,
    getters,
    actions
}
