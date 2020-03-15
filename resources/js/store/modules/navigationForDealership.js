const state = {
    dealershipNavigation: [],
    dealershipDashboard: '',
    isDealershipNavigationOpen: true,
    downloadBookGuest: false,
    downloadUnBookGuest: false
};

const mutations = {
    setDealershipDashboard(state, trans) {
        state.dealershipDashboard = trans.dashboard
    },

    setDealershipNavigationOpen(state) {
        state.isDealershipNavigationOpen = !state.isNavigationOpen
    },

    setDownloadBookGuest(state, status){
        state.downloadBookGuest = status
    },

    setDownloadUnBookGuest(state, status){
        state.downloadUnBookGuest = status
    },

    setDealershipNavigation(state, trans) {
        const navGroup = [
            {
                icon: 'list',
                text: `${trans.guestServices}`,
                access: ['dealership'],
                subGroups:[
                    {
                        icon: 'person',
                        text: `${trans.bookAGuest}`,
                        link: 'dealershipAdminBookAGuest',
                        access: ['dealership'],
                    },

                    {
                        icon: 'cloud_download',
                        text: `${trans.downloadBookedGuests}`,
                        link: 'bookedGuest',
                        access: ['dealership', 'sales_executive'],
                        isDialog: true
                    },

                    {
                        icon: 'cloud_download',
                        text: `${trans.downloadUnbookedGuests}`,
                        link: 'unbookedGuest',
                        access: ['dealership', 'sales_executive'],
                        isDialog: true
                    }
                ]
            },

            {
                icon: 'list',
                text: `${trans.organize}`,
                access: ['dealership'],
                subGroups:[
                    {
                        icon: 'date_range',
                        text: `${trans.calendar}`,
                        link: 'dealershipAdminCalendar',
                        access: ['dealership', 'sales_executive'],
                    },

                    {
                        icon: 'directions_car',
                        text: `${trans.editEvent}`,
                        link: 'editDealershipsEvent',
                        access: ['dealership'],
                    },

                    {
                        icon: 'add',
                        text: `${trans.updateSales}`,
                        link: 'saleUpdate',
                        access: ['dealership', 'sales_executive'],
                    },

                    {
                        icon: 'insert_chart_outlined',
                        text: `${trans.analytics}`,
                        link: 'dealershipAnalytics',
                        access: ['dealership'],
                    },

                    {
                        icon: 'business',
                        text: `${trans.editDealership}`,
                        link: 'editDealership',
                        access: ['dealership'],
                    }
                ]
            }
        ]

        state.dealershipNavigation = [...navGroup]
    }
};

const getters = {
    getDownloadBookGuest(state){
            return state.downloadBookGuest
    },

    getDownloadUnBookGuest(state){
        return state.downloadUnBookGuest
    },

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
