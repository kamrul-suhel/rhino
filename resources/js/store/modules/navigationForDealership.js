const state = {
    dealershipNavigation: [],
    dealershipDashboard: '',
    isDealershipNavigationOpen: true
};

const mutations = {
    setDealershipDashboard(state, trans) {
        state.dealershipDashboard = trans.dashboard
    },

    setDealershipNavigationOpen(state) {
        state.isDealershipNavigationOpen = !state.isNavigationOpen
    },

    setDealershipNavigation(state, trans) {
        console.log('Available translation field: ', trans);
        const navGroup = [
            {
                icon: 'list',
                text: `${trans.guest} ${trans.services}`,
                access: ['dealership'],
                subGroups:[
                    {
                        icon: 'list',
                        text: `${trans.book} ${trans.a} ${trans.guest}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    },

                    {
                        icon: 'list',
                        text: `${trans.download} ${trans.booked} ${trans.guests}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    },

                    {
                        icon: 'list',
                        text: `${trans.download} ${trans.unbooked} ${trans.guests}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    }
                ]
            },

            {
                icon: 'list',
                text: `${trans.organize}`,
                access: ['dealership'],
                subGroups:[
                    {
                        icon: 'list',
                        text: `${trans.calendar}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    },

                    {
                        icon: 'list',
                        text: `${trans.edit} ${trans.event}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    },

                    {
                        icon: 'list',
                        text: `${trans.update} ${trans.sales}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    },

                    {
                        icon: 'list',
                        text: `${trans.analytics}`,
                        link: 'listDealerships',
                        access: ['dealership'],
                    }
                ]
            }
        ]

        state.dealershipNavigation = [...navGroup]
    }
};

const getters = {
    getDealershipNavigation(state) {
        return state.dealershipNavigation
    },

    getDealershipIsNavigationOpen(state) {
        return state.isDealershipNavigationOpen
    },

    getDealershipDashboardTitle(state) {
        return state.dealershipDashboard
    }
};

const actions = {
    dispatchNavigation({commit}, trans) {
        commit('setNavigation', trans)
        commit('setHome', trans)
    }
}

export default {
    state,
    mutations,
    getters,
    actions
}
