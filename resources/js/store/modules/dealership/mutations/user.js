export default {
    setUsersByDealership(state, users){
        state.users = [...users]
    },

    setSelectedUserByDealership(state, userDealership){
        state.selectedUsers = {...userDealership}
    },

    setTotalUserByDealership(state, totalUsers){
        state.totalUsers = totalUsers
    }
}
