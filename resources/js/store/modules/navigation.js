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
                        link: 'dealerships',
                        access: ''
                    },

                    {
                        icon: 'history',
                        text: trans.create_dealerships,
                        link: 'addDealership',
                        access: ''
                    },


                    {
                        icon: 'subscriptions',
                        text: trans.groups,
                        link: 'groups',
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
