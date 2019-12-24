import fn from '../../utils/function'

const defaultState = {
    companies : [],
    selectedCompany: {},
    listHeader:[],
    loading: 'white',
    totalCompanies: 0,
    companyListRowPerPage: [15,25,40]
}

const state = {
    ...defaultState
}

const mutations = {
    setCompanies(state, companies){
        state.companies = [...companies]
    },

    setCompanyLoading(state, status){
        state.loading = status
    },

    setSelectedCompany(state, company){
        state.selectedCompany = {...company}
    },

    setTotalCompanies(state, totalCompany){
        state.totalCompanies = totalCompany
    },

    resetCompanyStore(state){
        state = {...defaultState}
    },

    setCompanyListHeader(state, trans){
        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.status,
                value: 'status'
            },

            {
                text: trans.actions,
                value: 'actions'
            }
        ]

        state.listHeader = header
    }
}

const getters = {
    getCompanies(state){
        return state.companies
    },

    getCompanyListHeader(state){
        return state.listHeader
    },

    getCompanyLoading(state){
        return state.loading
    },

    getCompanyListRowsPerPage(state){
        return state.companyListRowPerPage
    },

    getSelectedCompany(state){
        return state.selectedCompany
    },

    getTotalCompanies(state){
        return state.totalCompanies
    },

}

const actions = {
    /**
     * You can filter by status
     * sent type= 'active' | 'inactive'
     * ...this.pagination // Default pagination object
     * trans: translation object, // Important
     * paginate: true, // If you want all record, do not sent
     * search: optional | if search by any text
     * @param commit
     * @param payload
     */
    fetchCompanies({commit}, payload = {}) {

        // Set loading is true
        commit('setCompanyLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setCompanyListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = '/api/companies' + params

        axios.get(URL).then((response) => {
            if (response.data.companies) {
                commit('setCompanies', response.data.companies)
                commit('setTotalCompanies', response.data.total)
                commit('setCompanyLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchCompany({commit, dispatch}, payload){
        const URL = `/api/companies/${payload.id}/show`+ fn.generateParams(payload)
        axios.get(URL).then((response) => {
            if(response.data){
                commit('setSelectedCompany', response.data.company)
            }
        }).catch((error)=>{
            // Generate error message
        })
    },

    fetchCompanyForDropdown({commit}, payload ={}){
        const URL = `/api/companies/dropdown${fn.generateParams(payload)}`
        axios.get(URL).then((response) => {
            if(response.data.companies){
                commit('setCompanies', response.data.companies)
                commit('setTotalCompanies', response.data.total)
            }
        }).catch((error)=>{
            // Generate error message
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
