export default {
    fetchUsersByDealershipId({commit}, payload){
        const URL = `/api/dealerships/${payload.dealershipId}/users`
        axios.get(URL).then((response)=>{
            if(response.data.users){
                commit('setUsersByDealership', response.data.users)
                commit('setTotalUserByDealership', response.data.total)
            }
        })
    }
}
