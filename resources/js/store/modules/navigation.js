const state = {
    navigation: [],
    home: '',
    isNavigationOpen: true
};

const mutations = {
    setHome(state, trans) {
        state.home = trans.home
    },

    setIsNavigationOpen(state) {
        state.isNavigationOpen = !state.isNavigationOpen
    },

    setNavigation(state, trans) {
        console.log('Available translation field: ', trans);
        const navItems = [

            {
                icon: 'fa-user',
                text: `${trans.manageUsers}`,
                link: 'listUsers',
                access: ['admin', 'dealership'],
                divider: false
            },


            {
                icon: 'fa-car',
                text: `${trans.manageVehicles}`,
                link: 'listVehicles',
                access: ['admin'],
                divider: false
            },


            {
                icon: 'fa-calendar-alt',
                text: `${trans.manageEvents}`,
                link: 'listEvents',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-certificate',
                text: `${trans.manageEventType}`,
                link: 'listEventTypes',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-flag',
                text: `${trans.manageLanguages}`,
                link: 'listLanguages',
                access: ['admin'],
                divider: true
            },

            {
                icon: 'fa-building',
                text: `${trans.manageCompanies}`,
                link: 'listCompanies',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-id-badge',
                text: `${trans.manageBrands}`,
                link: 'listBrands',
                access: ['admin'],
                divider: false
            },


            {
                icon: 'fa-globe',
                text: `${trans.manageCountries}`,
                link: 'listCountries',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-braille',
                text: `${trans.manageGroups}`,
                link: 'listDealershipsGroups',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-smile',
                text: `${trans.manageDealerships}`,
                link: 'listDealerships',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-users',
                text: `${trans.manageGuests}`,
                link: 'listGuest',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'fa-language',
                text: trans.translations,
                link: 'translationSetting',
                access: ['admin'],
                divider: false
            }
        ]

        state.navigation = [...navItems];
    }
};

const getters = {
    getNavigationBar(state) {
        return state.navigation;
    },

    getIsNavigationOpen(state) {
        return state.isNavigationOpen
    },

    getHomeTitle(state) {
        return state.home
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
