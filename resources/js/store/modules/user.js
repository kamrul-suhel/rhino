const defaultState = {
    authUser: {},
    userId : null,
    userName: null,
    userEmail: null,
    admin: null,
    isLogin: false,
    themeOption:{
        theme: 'dark',
        inputColor: 'white',
        buttonPrimaryColor: 'dark',
        buttonSecondaryColor: 'success',
        buttonDangerColor: 'red',
        buttonSuccess: 'success',

        // Header setting
        textHeadingColor: 'cyan',
        loadingColor: 'white',

        // Snack bar option
        snackBarBgSuccess: 'success',
        snackBarBgError: 'red',
        snackBarTimeout : 6000
    }
}
const state = {
    ...defaultState
}

const mutations = {
    setUser(state, user){
        state.userId = user.id
        state.userName = user.name
        state.userEmail = user.email
        state.admin = user.role
        state.isLogin = true
    },

    resetUser(state){
        state = {...defaultState}
    },

    setAuthUser(state, user){
        state.authUser =  {...user}
        state.isLogin = true
    },

    setIsLogin(state, status){
        state.isLogin = status
    },

    setThemeOption(state, themeOption){
        state = {...themeOption}
    }
}

const getters = {
    getUserId(state){
        return state.userId
    },

    getUserName(state){
        return state.userName
    },

    getUserEmail(state){
        return state.userEmail
    },

    getAuthUser(state){
        return state.authUser
    },

    getUserRole(state){
        return state.admin
    },

    getIsLogin(state){
        return state.isLogin
    },

    getThemeOption(state){
        return state.themeOption
    }
}

const actions = {

}

export default {
    state,
    getters,
    mutations,
    actions
}
