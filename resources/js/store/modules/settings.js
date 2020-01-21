import fn from "../../utils/function";

const state = {
    theme:'dark',
    fields: {},
    navigations: [],
    home:'',
    isLoading: false
};

const mutations = {
    setTheme(state, theme){
        state.theme = theme;
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
        });
    }
}

export default  {
    state,
    mutations,
    getters,
    actions
}
