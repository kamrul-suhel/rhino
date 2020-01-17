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
                icon: 'list',
                text: `${trans.dealership} ${trans.list}`,
                link: 'listDealerships',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'post_add',
                text: `${trans.create} ${trans.dealership}`,
                link: 'addDealerships',
                access: ['admin'],
                divider: false
            },


            {
                icon: 'bookmarks',
                text: `${trans.list_of} ${trans.groups}`,
                link: 'listDealershipsGroups',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'bookmarks',
                text: `${trans.list_of} ${trans.groups}`,
                link: 'listDealershipsGroups',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.brand} ${trans.list}`,
                link: 'listBrands',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.brand} ${trans.list}`,
                link: 'listBrands',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.vehicle} ${trans.list}`,
                link: 'listVehicles',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'add',
                text: `${trans.create} ${trans.vehicle}`,
                link: 'addVehicles',
                access: ['admin'],
                divider: false
            },
            {
                icon: 'list',
                text: `${trans.company} ${trans.list}`,
                link: 'listCompanies',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.countries} ${trans.list}`,
                link: 'listCountries',
                access: ['admin'],
                divider: true
            },

            {
                icon: 'add',
                text: `${trans.create} ${trans.country}`,
                link: 'createCountries',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.language} ${trans.list}`,
                link: 'listLanguages',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.list_of} ${trans.events}`,
                link: 'listEvents',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'add',
                text: `${trans.create} ${trans.event}`,
                link: 'createEvents',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'emohi_events',
                text: `${trans.types}`,
                link: 'listEventTypes',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'list',
                text: `${trans.list_of} ${trans.users}`,
                link: 'listUsers',
                access: ['admin', 'dealership'],
                divider: false
            },

            {
                icon: 'person_add',
                text: `${trans.create} ${trans.user}`,
                link: 'createUsers',
                access: ['admin'],
                divider: true
            },

            {
                icon: 'list',
                text: `${trans.list_of} ${trans.guests}`,
                link: 'listGuest',
                access: ['admin'],
                divider: false
            },

            {
                icon: 'person_add',
                text: `${trans.create} ${trans.guest}`,
                link: 'createGuest',
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
