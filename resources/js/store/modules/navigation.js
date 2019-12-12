const state = {
    navigation:[],
    home: ''
};

const mutations = {
    setHome(state, trans){
        state.home = trans.home
    },

    setNavigation(state, trans){
        console.log('navigation', trans);
        const navItems = [
            {
                icon: 'add_shopping_cart',
                text: trans.dealerships,
                navs: [
                    {
                        icon: 'history',
                        text: trans.all_dealerships,
                        link: 'listDealerships',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: trans.create_dealerships,
                        link: 'addDealerships',
                        access: ''
                    },


                    {
                        icon: 'subscriptions',
                        text: trans.groups,
                        link: 'listDealershipsGroups',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.brands,
                navs: [
                    {
                        icon: 'history',
                        text: trans.list_of_brands,
                        link: 'listBrands',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.vehicles,
                navs: [
                    {
                        icon: 'history',
                        text: trans.list_of_vehicles,
                        link: 'listVehicles',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: trans.create_vehicle,
                        link: 'addVehicles',
                        access: ''
                    },

                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.companies,
                navs: [
                    {
                        icon: 'history',
                        text: trans.list_of_companies,
                        link: 'listCompanies',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.countries,
                navs: [
                    {
                        icon: 'history',
                        text: trans.list_of_country,
                        link: 'listCountries',
                        access: ''
                    },

                    {
                        icon: 'map',
                        text: trans.create_country,
                        link: 'createCountries',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.languages,
                navs: [
                    {
                        icon: 'history',
                        text: trans.list_of_languages,
                        link: 'listLanguages',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.events,
                navs: [
                    {
                        icon: 'history',
                        text: `${trans.list_of} ${trans.events}`,
                        link: 'listEvents',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: `${trans.create} ${trans.event}`,
                        link: 'createEvents',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: `${trans.types}`,
                        link: 'listEventTypes',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.users,
                navs: [
                    {
                        icon: 'history',
                        text: `${trans.list_of} ${trans.users}`,
                        link: 'listUsers',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: `${trans.create} ${trans.user}`,
                        link: 'createUsers',
                        access: ''
                    }
                ],
            },

            {
                icon: 'add_shopping_cart',
                text: trans.guests,
                navs: [
                    {
                        icon: 'history',
                        text: `${trans.list_of} ${trans.guests}`,
                        link: 'listGuest',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: `${trans.create} ${trans.guest}`,
                        link: 'createGuest',
                        access: ''
                    }
                ],
            }
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
