const state = {
    theme:'dark',
    fields: []
};

const mutations = {
    setTheme(state, theme){
        state.theme = theme;
    },

    setFieldsItem(state, fields){
        state.fields = [...fields]
    }
}

const getters = {
    getTheme(state){
       return state.theme;
    },
    getFields(state){
        return state.fields
    }
}

const actions = {
    getAllSettingFields({commit}, payload){
        axios.get('/api/settings').then((response) => {
            console.log(response.data);
            commit('setFieldsItem', response.data);
        });
    }
}

export default  {
    state,
    mutations,
    getters,
    actions
}
