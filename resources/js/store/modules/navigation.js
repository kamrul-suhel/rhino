const state = {
    navigation:[],
    home: '',
    isNavigationOpen: true
};

const mutations = {
    setHome(state, trans){
        state.home = trans.home
    },

    setIsNavigationOpen(state){
        state.isNavigationOpen = !state.isNavigationOpen
    },

    setNavigation(state, trans){
        console.log('Available translation field: ', trans);
        const navItems = [
            {
                icon: 'emoji_transportation',
                text: trans.dealerships,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.dealership} ${trans.list}`,
                        link: 'listDealerships',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'post_add',
                        text: `${trans.create} ${trans.dealership}`,
                        link: 'addDealerships',
                        access: ['admin', 'dealership']
                    },


                    {
                        icon: 'bookmarks',
                        text: `${trans.list_of} ${trans.groups}`,
                        link: 'listDealershipsGroups',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'donut_small',
                text: trans.brands,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.brand} ${trans.list}`,
                        link: 'listBrands',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'directions_car',
                text: trans.vehicles,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.vehicle} ${trans.list}`,
                        link: 'listVehicles',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'add',
                        text: `${trans.create} ${trans.vehicle}`,
                        link: 'addVehicles',
                        access: ['admin', 'dealership']
                    },

                ],
            },

            {
                icon: 'business_center',
                text: trans.companies,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.company} ${trans.list}`,
                        link: 'listCompanies',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'map',
                text: trans.countries,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.countries} ${trans.list}`,
                        link: 'listCountries',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'add',
                        text: `${trans.create} ${trans.country}`,
                        link: 'createCountries',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'language',
                text: trans.languages,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.language} ${trans.list}`,
                        link: 'listLanguages',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'event_note',
                text: trans.events,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.list_of} ${trans.events}`,
                        link: 'listEvents',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'add',
                        text: `${trans.create} ${trans.event}`,
                        link: 'createEvents',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'emohi_events',
                        text: `${trans.types}`,
                        link: 'listEventTypes',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'person',
                text: trans.users,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.list_of} ${trans.users}`,
                        link: 'listUsers',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'person_add',
                        text: `${trans.create} ${trans.user}`,
                        link: 'createUsers',
                        access: ['admin', 'dealership']
                    }
                ],
            },

            {
                icon: 'people',
                text: trans.guests,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.list_of} ${trans.guests}`,
                        link: 'listGuest',
                        access: ['admin', 'dealership']
                    },

                    {
                        icon: 'person_add',
                        text: `${trans.create} ${trans.guest}`,
                        link: 'createGuest',
                        access: ['admin', 'dealership']
                    }
                ],
            },
            {
                icon: 'build',
                text: `${trans.settings}`,
                access: ['admin', 'dealership'],
                navs: [
                    {
                        icon: 'keyboard_arrow_right',
                        text: trans.translation,
                        link: 'translationSetting',
                        access: ['admin', 'dealership']
                    },
                ],
            },


        ]

        state.navigation = [...navItems];
    }
};

const getters = {
    getNavigationBar(state){
        return state.navigation;
    },

    getIsNavigationOpen(state){
        return state.isNavigationOpen
    },

    getHomeTitle(state){
        return state.home
    }
};

const actions = {
    dispatchNavigation({commit}, trans){
        commit('setNavigation', trans)
        commit('setHome', trans)
    }
}

export  default {
    state,
    mutations,
    getters,
    actions
}
