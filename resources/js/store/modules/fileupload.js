const defaultState = {
    file: null,
    files: []

}

const state = {
    ...defaultState
}

const mutations = {
    setFile(state, file){
        state.file = file
    },

    setFiles(state, files) {
        state.files = [...files]
    }
}

const getters = {
    getFile(file){
        return state.file
    },

    getFiles(state){
        return state.files
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
