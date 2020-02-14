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

    levels: [],

    //Tab option
    tabColor: 'dark',
    tabSliderColor: 'white'
}
const state = {
    ...defaultState
}

const mutations = {
    setUsers(state, users) {
        state.users = [...users]
    },

    addUserToUserList(state, user){
        let users = [...state.users]
        users.push({...user})

        state.users = [...users]
    },

    removeUserFromUserList(state, user){
        const currentUser = _.filter(state.users, function(curUser){
            return curUser.id !== user.id
        })

        state.users = [...currentUser]
    },

    updateUserForBooking(state, selectedUser){
        const updatedUsers = _.map(state.users, (currentUser)=>{

            let user = {
                ...currentUser,
                selected: ''
            }

            if(selectedUser.id === user.id){
                user = {
                    ...user,
                    selected: 'selected'
                }
            }

            return user
        })

        state.users = [...updatedUsers]
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
            },

            {
                'text': trans.sales_executive,
                'value': 'sales_executive'
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

    resetUserStore(state) {
        state = {...defaultState}
    },

    setUserListHeader(state, options) {
        const trans = {...options.trans}
        const subComponent = options.subComponent


        let header = []
        if (!subComponent) {
            header = [
                {
                    text: trans.firstName,
                    align: 'left',
                    sortable: true,
                    value: 'first name'
                },

                {
                    text: trans.surName,
                    align: 'left',
                    sortable: true,
                    value: 'surname'
                },

                {
                    text: trans.email,
                    align: 'left',
                    sortable: true,
                    value: 'email'
                },

                {
                    text: trans.role,
                    value: 'lavelAccess',
                    align: 'left',
                    sortable: false
                },

                {
                    text: trans.actions,
                    value: 'actions',
                    sortable: false,
                    align: 'right'
                }
            ]
        }else{
            header = [
                {
                    text: trans.firstName,
                    align: 'left',
                    sortable: true,
                    value: 'first name'
                },

                {
                    text: trans.surName,
                    align: 'left',
                    sortable: true,
                    value: 'surname'
                },


                {
                    text: trans.email,
                    align: 'left',
                    sortable: true,
                    value: 'email'
                },

                {
                    text: trans.actions,
                    value: 'actions',
                    sortable: false,
                    align: 'right'
                }
            ]
        }

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
    },

    fetchSaleExecutivesForBooking({commit}, payload){
        const guest = {...payload.data.guest}
        let saleExecutive = null
        if(guest.appointment.length > 0){
            const appointment = {...guest.appointment[0]}
            if(
                appointment.user_id &&
                appointment.user_id !== '' &&
                appointment.user_id !== 'null'
            ){
                _.map(payload.users, (currentSaleExecutive) => {
                    if(currentSaleExecutive.id === appointment.user_id){
                        saleExecutive = appointment.user_id
                    }
                })
            }
        }

        const users = _.map(payload.users, (user) => {
            if(saleExecutive !== null){
                 if(saleExecutive === user.id){
                     return {
                         ...user,
                         availability: true,
                         selected: 'selected'
                     }
                 }else{
                     return {
                         ...user,
                         availability: true,
                         selected: ''
                     }
                 }
            }else{
                return {
                    ...user,
                    availability: true,
                    selected: ''
                }
            }

        })

        commit('setUsers', users)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
