import defaultState from './dealership/state'
import dealershipMutations from "./dealership/mutations";
import dealershipGetters from "./dealership/getters"
import dealershipActions from "./dealership/actions"

console.log(defaultState)
const state = {
    ...defaultState
}

const mutations = {
    ...dealershipMutations
}

const getters = {
    ...dealershipGetters
}

const actions = {
    ...dealershipActions
}

export default {
    state,
    mutations,
    getters,
    actions
}
