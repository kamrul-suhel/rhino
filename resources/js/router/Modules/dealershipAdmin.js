import * as DealershipAdmin from "@/pages/dealershipAdmin";

const DealershipAdminRoutes = {
    path: '/admin',
    name:'dealershipAdmin',
    component: DealershipAdmin.Root,
    children: [
        {
            path: 'bookguest',
            name: 'dealershipAdminBookAGuest',
            component: DealershipAdmin.BookGuest
        },

        {
            path: 'calendar',
            name: 'dealershipAdminCalendar',
            component: DealershipAdmin.Calendar
        },

        
        {
            path: 'analytics',
            name: 'dealershipAnalytics',
            component: DealershipAdmin.Analytics
        }
    ]
}

export default DealershipAdminRoutes
