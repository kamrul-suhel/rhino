const state = {
    languages: [],
    selectedLanguage: {}
}

const mutations = {
    setLanguages(state, languages){
        state.languages = [...languages]
    },

    setSelectedLanguage(state, language){
        state.selectedLanguage = {...language}
    }
}

const getters = {
    getLanguages(state){
        return state.languages
    },

    getSelectedLanguages(state){
        return state.selectedLanguage
    }
}

const actions = {
    /**
     * You can filter by status
     * sent type= 'active' | 'inactive'
     * @param commit
     * @param payload
     */
    fetchLanguages({commit}, payload = {}){
        const params = typeof(payload.type) != 'undefined' ? 'type='+payload.type : '';
        const URL = '/api/languages?type='+ params

        axios.get(URL).then((response)=>{
            commit('setLanguages', response.data)
        });
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
