const state = {
    authUser: {},
    userId : null,
    userName: null,
    userEmail: null,
    admin: null,
    isLogin: false
}

const mutations = {
    setUser(state, user){
        state.userId = user.id;
        state.userName = user.name;
        state.userEmail = user.email;
        state.admin = user.role;
        state.isLogin = true;
    },

    resetUser(state){
        state.userId    = null;
        state.userName  = null;
        state.userEmail = null;
        state.admin = null;
        state.isLogin = false;
    },

    setAuthUser(state, user){
        state.authUser =  {...user}
        state.isLogin = true;
    },

    setIsLogin(state, status){
        state.isLogin = status;
    }
}

const getters = {
    getUserId(state){
        return state.userId;
    },

    getUserName(state){
        return state.userName;
    },

    getUserEmail(state){
        return state.userEmail;
    },

    getAuthUser(state){
        return state.authUser;
    },

    getUserRole(state){
        return state.admin;
    },

    getIsLogin(state){
        return state.isLogin;
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
