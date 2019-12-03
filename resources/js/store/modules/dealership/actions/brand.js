export default {
    fetchBrandsByDealershipId({commit}, payload){
        const URL = `/api/dealerships/${payload.dealershipId}/brands`

        axios.get(URL).then((response)=>{
            if(response.data.brands){
                commit('getBrandsByDealership', response.data.brands)

            }
        })
    }
}
