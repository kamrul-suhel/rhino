const defaultState = {
    groups: [],
    selectedGroup: {}
}

const state = {
    ...defaultState
}

const mutations = {
    setGroups(state, groups = []){
        state.groups = [...groups]
    }
}

const getters = {
    getGroups(state){
        return state.groups
    }
}

const actions = {
    fetchGroups({commit}, payload){
        const URL = '/api/groups'
        axios.get(URL).then((response) => {
            commit('setGroups', response.data.groups)
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
