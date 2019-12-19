import fn from '../../utils/function'

const defaultState = {
    users: [],
    selectedUser: {},
    listHeader: [],
    loading: 'white',
    totalUsers: 0,
    userListRowPerPage: [15, 25, 40],

    // For dropdown
    usersDropDown: [],

    levels: []
}

const state = {
    ...defaultState
}

const mutations = {
    setUsers(state, users) {
        state.users = [...users]
    },

    setLevel(state, trans) {
        const levels = [
            {
                'text': trans.admin,
                'value': 'admin'
            },

            {
                'text': trans.dealership,
                'value': 'dealership'
            },

            {
                'text': trans.group,
                'value': 'group'
            },

            {
                'text': trans.region,
                'value': 'region'
            },

            {
                'text': trans.country,
                'value': 'country'
            },

            {
                'text': trans.brand,
                'value': 'brand'
            },

            {
                'text': trans.company,
                'value': 'company'
            }
        ]

        state.levels = [...levels]
    },

    setUsersForDropDown(state, users) {
        state.usersDropDown = [...users]
    },

    setUserLoading(state, status) {
        state.loading = status
    },

    setSelectedUser(state, user) {
        state.selectedUser = {...user}
    },

    setTotalUsers(state, totalUser) {
        state.totalUsers = totalUser
    },

    resetUserstore(state) {
        state = {...defaultState}
    },

    setUserListHeader(state, options) {
        const trans = options.trans
        const subComponent = options.subComponent
        let userColumn = {}
        if (!subComponent) {
            userColumn = [
                {
                    text: trans.status,
                    value: 'status'
                },

                {
                    text: trans.role,
                    value: 'lavelAccess',
                    align: 'left',
                    sortable: false
                }
            ]
        }

        const header = [
            {
                text: trans.name,
                align: 'left',
                sortable: true,
                value: 'name'
            },

            {
                text: trans.email,
                align: 'left',
                sortable: true,
                value: 'email'
            },

            ...userColumn,

            {
                text: trans.actions,
                value: 'actions',
                sortable: false,
                align: 'right'
            }
        ]

        state.listHeader = [...header]
    }
}

const getters = {
    getUsers(state) {
        return state.users
    },

    getUserLevels(state) {
        return state.levels
    },

    getUsersForDropDown(state) {
        return state.usersDropDown
    },

    getUserListHeader(state) {
        return state.listHeader
    },

    getSelectedUserRegion(state) {
        return state.selectedUserRegion
    },

    getUserRegionListHeader(state) {
        return state.userRegionHeader
    },

    getUserLoading(state) {
        return state.loading
    },

    getUserListRowsPerPage(state) {
        return state.userListRowPerPage
    },

    getSelectedUser(state) {
        return state.selectedUser
    },

    getTotalUsers(state) {
        return state.totalUsers
    },

    getRegionByUserId(state) {
        return state.regions
    },

    getTotalRegionByUserId(state) {
        return state.totalRegions
    }

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
    fetchUsers({commit}, payload = {}) {

        // Set loading is true
        commit('setUserLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setUserListHeader', {trans: payload.trans})

        const params = fn.generateParams(payload)
        const URL = `/api/users${params}`

        axios.get(URL).then((response) => {
            if (response.data.users) {
                commit('setUsers', response.data.users)
                commit('setTotalUsers', response.data.total)
                commit('setUserLoading', false)
            }
        });
    },

    fetchUsersForEvent({commit}, payload = {}) {
        // Set loading is true
        commit('setUserLoading', payload.themeOption.loadingColor)

        // Setup header for list view
        commit('setUserListHeader', {trans: payload.trans, subComponent: payload.subComponent})

        const params = fn.generateParams(payload)
        const URL = `/api/users/events/${payload.eventId}/dealerships/${payload.dealershipId}${params}`

        axios.get(URL).then((response) => {
            if (response.data.users) {
                commit('setUsers', response.data.users)
                commit('setTotalUsers', response.data.total)
                commit('setUserLoading', false)
            }
        });
    },

    /**
     * Get Selected company
     * @param id // required
     */
    fetchUser({commit, dispatch}, payload) {
        const URL = `/api/users/${payload.id}/show${fn.generateParams(payload)}`
        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setSelectedUser', response.data.user)
            }
        }).catch((error) => {
            // Generate error message
        })
    },

    fetchUserForDropDown({commit}, payload = {}) {
        const URL = `/api/users/dropdown${fn.generateParams(payload)}`

        axios.get(URL).then((response) => {
            if (response.data) {
                commit('setUsersForDropDown', response.data)
            }
        })
            .catch((error) => {

            })
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
