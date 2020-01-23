import fn from "../../utils/function";

const state = {
    theme:'dark',
    fields: {},
    navigations: [],
    home:'',
    isLoading: false,
    isLoaded: false
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
    }
}

const actions = {
    fetchSettingFields({commit,dispatch}, payload = null){
        const URL = `/api/settings${fn.generateParams(payload)}`
        commit('setIsLoading', true)
        axios.get(URL).then((response) => {
            commit('setFieldsItem', response.data);
            commit('setIsLoading', false)
            commit('setIsSettingLoaded', true)
        });
    }
}

export default  {
    state,
    mutations,
    getters,
    actions
}
