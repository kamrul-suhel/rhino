import fn from '../../utils/function'

const defaultState = {
    types: [],
    selectedType: {},
    listHeader:[],
    loading: 'white',
    totalType: 0,
    typeListRowPerPage: [15,25,40]
}

const state = {
    ...defaultState
}

const mutations = {
    setTypes(state, types = []){
        state.types = [...types]
    },

    setTypeListHeader(state, trans){
        const header = [
            {
                text: trans.icon,
                align: 'left',
                sortable: false,
                value: 'icon'
            },

            {
                text: trans.displayName,
                align: 'left',
                sortable: false,
                value: 'Display Name'
            },

            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.description,
                align: 'left',
                sortable: false,
                value: 'description'
            },

            {
                text: trans.action,
                value: 'action',
                align: 'right'
            }
        ]

        state.listHeader = header
    },

    setTypeLoading(state, status){
        state.loading = status
    },

    setSelectedType(state, type){
        state.selectedType = {...type}
    },

    setTotalType(state, totalType){
        state.totalType = totalType
    },

    resetTypeStore(state){
        state = {...defaultState}
    }
}

const getters = {
    getTypes(state){
        return state.types
    },

    getTypeListHeader(state){
        return state.listHeader
    },

    getTypeLoading(state){
        return state.loading
    },

    getTypeListRowsPerPage(state){
        return state.typeListRowPerPage
    },

    getSelectedType(state){
        return state.selectedType
    },

    getTotalType(state){
        return state.totalType
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
    fetchTypes({commit}, payload = {}) {

        // Check is dropdown or no
        if (!payload.dropDown || typeof (payload.dropDown) === 'undefined') {
            commit('setTypeLoading', payload.themeOption.loadingColor)
            // Setup header for list view
            commit('setTypeListHeader', payload.trans)
        }

        const params = fn.generateParams(payload)
        const URL = `/api/events/types/list${params}`

        axios.get(URL).then((response) => {
            if (response.data.types) {
                commit('setTypes', response.data.types)
                commit('setTotalType', response.data.total)
                commit('setTypeLoading', false)
            }
        });
    },

    fetchType({commit}, payload = {}){
        const URL = `/api/events/types/${payload.id}${fn.generateParams(payload)}`

        axios.get(URL).then((response)=>{
            if(response.data.type){
                commit('setSelectedType', response.data.type)
            }
        })
    },

    /**
     * Get all active event type
     * @param commit
     * @param payload
     */
    fetchTypesForDropdown({commit}, payload = {}) {
        const URL = '/api/events/types/dropdown'

        axios.get(URL).then((response) => {
            if (response.data.types) {
                commit('setTypes', response.data.types)
                commit('setTotalType', response.data.total)
            }
        });
    },
}

export default {
    state,
    mutations,
    getters,
    actions
}
