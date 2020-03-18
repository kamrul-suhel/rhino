import fn from "../../utils/function";

const state = {
    theme:'dark',
    fields: {},
    navigations: [],
    home:'',
    isLoading: false,
    isLoaded: false,
    loadSettingLanguage: false
};

const mutations = {
    setTheme(state, theme){
        state.theme = theme;
    },

    setIsSettingLoaded(state, status){
        state.isLoaded = status
    },

    setFieldsItem(state, fields){
        state.fields = {...fields}
    },

    setHome(state, home){
        state.home = home.translation;
    },

    setIsLoading(state, loading){
        state.isLoading = loading
    },

    setLoadSettingLanguage(state, status){
        state.loadSettingLanguage = status
    }

}

const getters = {
    getIsSettingLoaded(state){
        return state.isLoaded
    },

    getTheme(state){
       return state.theme
    },

    getFields(state){
        return state.fields
    },


    getHome(state){
        return state.home
    },

    getIsLoading(state){
        return state.isLoading
    },

    getSettingLanguage(state){
        return state.loadSettingLanguage
    }
}

const actions = {
    fetchSettingFields({commit,dispatch}, payload = null){
        return new Promise((resolve, reject) => {
            const URL = `/api/settings${fn.generateParams(payload)}`
            commit('setIsLoading', true)
            axios.get(URL).then((response) => {
                commit('setFieldsItem', response.data);
                commit('setIsLoading', false)
                resolve()
            });
        })
    }
}

export default  {
    state,
    mutations,
    getters,
    actions
}
