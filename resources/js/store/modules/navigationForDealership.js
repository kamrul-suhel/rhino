import CONST from "../../utils/const";

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
                access: [
                    CONST.MANAGER
                ],
                subGroups:[
                    {
                        icon: 'fa-user',
                        text: `${trans.bookAGuest}`,
                        link: 'dealershipAdminBookAGuest',
                        access: [
                            CONST.MANAGER
                        ]
                    },

                    {
                        icon: 'fa-cloud-download-alt',
                        text: `${trans.downloadBookedGuests}`,
                        link: 'bookedGuest',
                        access: [
                            CONST.MANAGER,
                            CONST.SALE_EXECUTIVE,
                        ],
                        isDialog: true
                    },

                    {
                        icon: 'fa-cloud-download-alt',
                        text: `${trans.downloadUnbookedGuests}`,
                        link: 'unbookedGuest',
                        access: [
                            CONST.MANAGER,
                            CONST.SALE_EXECUTIVE
                        ],
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
                        icon: 'fa-calendar-alt',
                        text: `${trans.calendar}`,
                        link: 'dealershipAdminCalendar',
                        access: [
                            CONST.MANAGER,
                            CONST.SALE_EXECUTIVE,
                            CONST.RECEPTIONIST,
                            CONST.CALL_HANDLER
                        ],
                    },

                    {
                        icon: 'fa-car',
                        text: `${trans.editEvent}`,
                        link: 'editDealershipsEvent',
                        access: [
                            CONST.MANAGER
                        ],
                    },

                    {
                        icon: 'fa-plus',
                        text: `${trans.updateSales}`,
                        link: 'saleUpdate',
                        access: [
                            CONST.MANAGER,
                            CONST.SALE_EXECUTIVE,
                            CONST.CALL_HANDLER,
                            CONST.RECEPTIONIST
                        ],
                    },

                    {
                        icon: 'fa-chart-bar',
                        text: `${trans.analytics}`,
                        link: 'dealershipAnalytics',
                        access: [
                            CONST.MANAGER
                        ],
                    },

                    {
                        icon: 'fa-building',
                        text: `${trans.editDealership}`,
                        link: 'editDealership',
                        access: [
                            CONST.MANAGER
                        ]
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
