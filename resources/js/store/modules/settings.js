const state = {
    theme:'dark',
    fields: {},
    navigations: [],
    home:'',
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
    }
}

const actions = {
    getAllSettingFields({commit,dispatch}, payload){
        axios.get('/api/settings').then((response) => {
            commit('setFieldsItem', response.data);
            dispatch('dispatchNavigation', response.data) // Dispatch to navigation store
        });
    }
}

export default  {
    state,
    mutations,
    getters,
    actions
}
