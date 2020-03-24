import fn from '../../utils/function'

const defaultState = {
    groups: [],
    selectedGroup: {},
    listHeader:[],
    loading: 'white',
    totalGroup: 0,
    groupListRowPerPage: [15,25,40]
}

const state = {
    ...defaultState
}

const mutations = {
    setGroups(state, groups = []){
        state.groups = [...groups]
    },

    setGroupListHeader(state, trans){
        const header = [
            {
                text: trans.logo,
                align: 'left',
                sortable: false,
                value: 'logo'
            },

            {
                text: trans.name,
                align: 'left',
                sortable: false,
                value: 'name'
            },

            {
                text: trans.action,
                value: 'action',
                align: 'right'
            }
        ]

        state.listHeader = header
    },

    setGroupLoading(state, status){
        state.loading = status
    },

    setSelectedGroup(state, group){
        state.selectedGroup = {...group}
    },

    setTotalGroup(state, totalGroup){
        state.totalGroup = totalGroup
    },

    resetGroupStore(state){
        state = {...defaultState}
    }
}

const getters = {
    getGroups(state){
        return state.groups
    },

    getGroupListHeader(state){
        return state.listHeader
    },

    getGroupLoading(state){
        return state.loading
    },

    getGroupListRowsPerPage(state){
        return state.groupListRowPerPage
    },

    getSelectedGroup(state){
        return state.selectedGroup
    },

    getTotalGroup(state){
        return state.totalGroup
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
    fetchGroups({commit, dispatch}, payload = {}) {

        // Set loading is true, if not dropdown
        if (!payload.dropDown && typeof(payload.dropDown) === 'undefined') {
            commit('setGroupLoading', payload.themeOption.loadingColor)

            // Setup header for list view
            commit('setGroupListHeader', payload.trans)
        }

        const params = fn.generateParams(payload)
        const URL = '/api/groups' + params

        axios.get(URL).then((response) => {
            if (response.data.groups) {
                commit('setGroups', response.data.groups)
                commit('setTotalGroup', response.data.total)
                commit('setGroupLoading', false)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },

    fetchGroup({commit, dispatch}, payload = {}){
        const URL = `/api/groups/${payload.id}${fn.generateParams(payload)}`

        axios.get(URL).then((response)=>{
            if(response.data.group){
                commit('setSelectedGroup', response.data.group)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    },

    fetchGroupsForDropdown({commit, dispatch}, payload ={}){
        const URL = `/api/groups/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response)=>{
            if(response.data.groups){
                commit('setGroups', response.data.groups)
                commit('setTotalGroup', response.data.total)
            }
        }).catch(error => {
            dispatch('initializeError', error)
        })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
