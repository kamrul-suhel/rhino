import fn from '../../utils/function'

const defaultState = {
    specializeBrands: [],
    listHeader: [],
    loading: 'white',
    totalSpecializeBrand: 0,
    specializeListRowPerPage: [15, 25, 40]
}
const state = {
    ...defaultState
}

const mutations = {
    setSpecializeBrands(state, specializeBrands) {
        state.specializeBrands = [...specializeBrands]
    },

    addSpecializeBrand(state, specializeBrand) {
        state.specializeBrands.push(specializeBrand)
    },

    removeSpecializeBrand(state, specializeBrand){
        const newUserBrand = _.filter(state.specializeBrands, (brand) => {
            return brand.id != specializeBrand.id
        })
        state.specializeBrands = [...newUserBrand]
    },

    setSpecializeBrandLoading(state, status) {
        state.loading = status
    },

    setSpecializeTotalBrand(state, totalBrands){
        state.totalSpecializeBrand = totalBrands
    },

    setTotalSpecializeBrands(state, totalSpecializeBrands) {
        state.totalSpecializeBrand = totalSpecializeBrands
    },

    setSpecializeBrandListHeader(state, trans) {
        const header = [
            {
                text: trans.brand,
                align: 'left',
                sortable: true,
                value: 'brand'
            },

            {
                text: trans.new,
                align: 'center',
                sortable: false,
                value: 'new'
            },

            {
                text: trans.used,
                value: 'used',
                sortable: false,
                align: 'center'
            },

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
    getSpecializeBrands(state) {
        return state.specializeBrands
    },

    getSpecializeBrandListHeader(state) {
        return state.listHeader
    },

    getSpecializeBrandLoading(state) {
        return state.loading
    },

    getSpecializeBrandListRowsPerPage(state) {
        return state.specializeListRowPerPage
    },

    getTotalSpecializeBrand(state) {
        return state.totalSpecializeBrand
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
    fetchSpecializeBrandByDealershipId({commit}, payload = {}) {
        // Set loading is true
        commit('setSpecializeBrandLoading', payload.themeOption.loadingColor)
        commit('setSpecializeBrandListHeader', payload.trans)

        const params = fn.generateParams(payload)
        const URL = `/api/users/${payload.userId}/brands${params}`

        axios.get(URL).then((response) => {
            if (response.data.brands) {
                commit('setSpecializeBrands', response.data.brands)
                commit('setSpecializeTotalBrand', response.data.total)
                commit('setSpecializeBrandLoading', false)
            }
        });
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
