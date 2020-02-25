const defaultState = {
    headerTitle : '',
    navTitle: ''
}

const state = {
    ...defaultState
}

const mutations = {
    setHeaderTitle(state, title){
        state.headerTitle = title
    },

    setNavTitle(state, navTitle){
        state.navTitle = navTitle
    }
}

const getters = {
    getHeaderTitle(state){
        return state.headerTitle
    },

    getNavTitle(state){
        return state.navTitle
    }
}

export default {
    state,
    mutations,
    getters
}
