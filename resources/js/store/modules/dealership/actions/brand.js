export default {
    fetchBrandsByDealershipId({commit}, payload){
        // Set loading is true
        commit('setBrandLoading', payload.themeOption.loadingColor)

        commit('setDealershipBrandListHeader', payload.trans)
        const URL = `/api/dealerships/${payload.dealershipId}/brands`

        axios.get(URL).then((response)=>{
            if(response.data.brands){
                commit('setBrandsByDealership', response.data.brands)
                commit('setTotalBrandByDealership', response.data.total)
                commit('setBrandLoading', false)
            }
        })
    }
}
