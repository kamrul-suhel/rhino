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
                icon: 'person',
                text: `${trans.manageUsers}`,
                link: 'listUsers',
                access: ['admin', 'dealership'],
                divider: false
            },


            {
                icon: 'drive_eta',
                text: `${trans.manageVehicles}`,
                link: 'listVehicles',
                access: ['admin'],
                divider: false
            },


            {
                icon: 'event',
                text: `${trans.manageEvents}`,
                link: 'listEvents',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'grade',
                text: `${trans.manageEventType}`,
                link: 'listEventTypes',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'flag',
                text: `${trans.manageLanguages}`,
                link: 'listLanguages',
                access: ['admin'],
                divider: true
            },

            {
                icon: 'business',
                text: `${trans.manageCompanies}`,
                link: 'listCompanies',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'assignment_ind',
                text: `${trans.manageBrands}`,
                link: 'listBrands',
                access: ['admin'],
                divider: false
            },


            {
                icon: 'language',
                text: `${trans.manageCountries}`,
                link: 'listCountries',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'blur_linear',
                text: `${trans.manageGroups}`,
                link: 'listDealershipsGroups',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'tag_faces',
                text: `${trans.manageDealerships}`,
                link: 'listDealerships',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'people',
                text: `${trans.manageGuests}`,
                link: 'listGuest',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'keyboard_arrow_right',
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
