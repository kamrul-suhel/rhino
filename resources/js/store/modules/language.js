const state = {
    languages: [],
    selectedLanguage: {},
    subSelectedLanguage:{}
}

const mutations = {
    setLanguages(state, languages){
        state.languages = [...languages]
    },

    setSelectedLanguage(state, language){
        state.selectedLanguage = {...language}
    },

    setSubSelectedLanguage(state, language){
        state.subSelectedLanguage = language
    },

    setSubSelectedLanguageById(state, languageId){
        const selectedLanguage = _.find(state.languages,(language)=>{
            return language.id === languageId
        })
        console.log('selectedLangauge', selectedLanguage)
    }
}

const getters = {
    getLanguages(state){
        return state.languages
    },

    getSelectedLanguages(state){
        return state.selectedLanguage
    },

    getSubSelectedLanguage(state){
        return state.subSelectedLanguage
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
        const params = typeof(payload.type) != 'undefined' ? '?type='+payload.type : '';
        const URL = '/api/languages'+ params

        axios.get(URL).then((response)=> {
            commit('setLanguages', response.data)
        });
    },

    fetchSubLanguage({commit}, payload={}){
        const URL = `/api/languages/${payload.id}/show`
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSubSelectedLanguage', response.data.language)
            }
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
