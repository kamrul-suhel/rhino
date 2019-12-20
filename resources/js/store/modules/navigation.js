const state = {
    navigation:[],
    home: ''
};

const mutations = {
    setHome(state, trans){
        state.home = trans.home
    },

    setNavigation(state, trans){
        console.log('Available translation field: ', trans);
        const navItems = [
            {
                icon: 'emoji_transportation',
                text: trans.dealerships,
                navs: [
                    {
                        icon: 'list',
                        text: trans.all_dealerships,
                        link: 'listDealerships',
                        access: ''
                    },

                    {
                        icon: 'post_add',
                        text: trans.create_dealerships,
                        link: 'addDealerships',
                        access: ''
                    },


                    {
                        icon: 'bookmarks',
                        text: trans.groups,
                        link: 'listDealershipsGroups',
                        access: ''
                    }
                ],
            },

            {
                icon: 'donut_small',
                text: trans.brands,
                navs: [
                    {
                        icon: 'list',
                        text: trans.list_of_brands,
                        link: 'listBrands',
                        access: ''
                    }
                ],
            },

            {
                icon: 'directions_car',
                text: trans.vehicles,
                navs: [
                    {
                        icon: 'list',
                        text: trans.list_of_vehicles,
                        link: 'listVehicles',
                        access: ''
                    },

                    {
                        icon: 'add',
                        text: trans.create_vehicle,
                        link: 'addVehicles',
                        access: ''
                    },

                ],
            },

            {
                icon: 'business_center',
                text: trans.companies,
                navs: [
                    {
                        icon: 'list',
                        text: trans.list_of_companies,
                        link: 'listCompanies',
                        access: ''
                    }
                ],
            },

            {
                icon: 'map',
                text: trans.countries,
                navs: [
                    {
                        icon: 'list',
                        text: trans.list_of_country,
                        link: 'listCountries',
                        access: ''
                    },

                    {
                        icon: 'add',
                        text: trans.create_country,
                        link: 'createCountries',
                        access: ''
                    }
                ],
            },

            {
                icon: 'language',
                text: trans.languages,
                navs: [
                    {
                        icon: 'list',
                        text: trans.list_of_languages,
                        link: 'listLanguages',
                        access: ''
                    }
                ],
            },

            {
                icon: 'event_note',
                text: trans.events,
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.list_of} ${trans.events}`,
                        link: 'listEvents',
                        access: ''
                    },

                    {
                        icon: 'add',
                        text: `${trans.create} ${trans.event}`,
                        link: 'createEvents',
                        access: ''
                    },

                    {
                        icon: 'emohi_events',
                        text: `${trans.types}`,
                        link: 'listEventTypes',
                        access: ''
                    }
                ],
            },

            {
                icon: 'person',
                text: trans.users,
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.list_of} ${trans.users}`,
                        link: 'listUsers',
                        access: ''
                    },

                    {
                        icon: 'person_add',
                        text: `${trans.create} ${trans.user}`,
                        link: 'createUsers',
                        access: ''
                    }
                ],
            },

            {
                icon: 'people',
                text: trans.guests,
                navs: [
                    {
                        icon: 'list',
                        text: `${trans.list_of} ${trans.guests}`,
                        link: 'listGuest',
                        access: ''
                    },

                    {
                        icon: 'person_add',
                        text: `${trans.create} ${trans.guest}`,
                        link: 'createGuest',
                        access: ''
                    }
                ],
            },
            {
                icon: 'build',
                text: `${trans.settings}`,
                navs: [
                    {
                        icon: 'keyboard_arrow_right',
                        text: 'Language/Date Demo',
                        link: 'testDateTime',
                        access: ''
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
