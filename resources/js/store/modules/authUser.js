const defaultState = {
    authUser: {},
    userId : null,
    userName: null,
    userEmail: null,
    admin: false,
    isLogin: true,
    themeOption:{
        primaryColor: '',
        secondaryColor: '#444',
        textColor:'',
        theme: 'dark',
        inputColor: 'dark',
        buttonPrimaryColor: 'success',
        buttonSecondaryColor: '#333',
        buttonDangerColor: '#E20000',
        buttonSuccess: 'success',
        buttonLoading: false,
        buttonLoadingStyle: 'loading',
        switchOnColor: '#212729',

        adminHeader: '#31393C',
        adminHeaderHeight: 150,

        // Header setting
        textHeadingColor: '#e20000',
        loadingColor: 'white',
        dealerShipLanguagePickerColor: '#fff',

        // Snack bar option
        snackBarBgSuccess: 'success',
        snackBarBgDanger: '#E20000',
        snackBarBgError: '#E20000',
        snackBarTimeout : 6000,

        // Toolbar backgroun color
        toolbarColor: '#424242',


        //Tab option
        tabColor: '#cecece',
        tabSliderColor: '#E20000',

        // Default image
        brandDefaultImage : '/images/brandPlaceholder.jpg',

        // Frontend
        drawerWidthF: '280',
        companyIconSizeF: '100',
        titleWidthF: '400px',
        brandColor: '#cc0000',

        adminNavIconColor: '#e20000',

        // Dealership admin
        dealershipAdminNavColor: '#000',

        dialogBoxColor: '#e20000'

    },
    initialize: false
}
const state = {
    ...defaultState
}

const mutations = {
    setInitialize(state, status){
        state.initialize = status
    },

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
    },

    setIsLogin(state, status){
        state.isLogin = status
    },

    setThemeOption(state, themeOption){
        state.themeOption = {
            ...state.themeOption,
            ...themeOption
        }
    },

    setUserRole(state, role){
        state.admin = role
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
    },

    getIsAdmin(state){
        return state.admin
    },

    getInitializeApp(state){
        return state.initialize
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
