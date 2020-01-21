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
                text: `${trans.manage} ${trans.users}`,
                link: 'listUsers',
                access: ['admin', 'dealership'],
                divider: false
            },

            
            {
                icon: 'drive_eta',
                text: `${trans.manage} ${trans.vehicles}`,
                link: 'listVehicles',
                access: ['admin'],
                divider: false
            },

            
            {
                icon: 'event',
                text: `${trans.manage} ${trans.events}`,
                link: 'listEvents',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'events',
                text: `${trans.manage}  ${trans.events} ${trans.types}`,
                link: 'listEventTypes',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'flag',
                text: `${trans.manage} ${trans.languages}`,
                link: 'listLanguages',
                access: ['admin'],
                divider: true
            },

            {
                icon: 'business',
                text: `${trans.manage} ${trans.companies}`,
                link: 'listCompanies',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'assignment_ind',
                text: `${trans.manage} ${trans.brands}`,
                link: 'listBrands',
                access: ['admin'],
                divider: false
            },

            
            {
                icon: 'language',
                text: `${trans.manage} ${trans.countries}`,
                link: 'listCountries',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'blur_linear',
                text: `${trans.manage} ${trans.groups}`,
                link: 'listDealershipsGroups',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'tag_faces',
                text: `${trans.manage} ${trans.dealerships}`,
                link: 'listDealerships',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'keyboard_arrow_right',
                text: trans.translation,
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
