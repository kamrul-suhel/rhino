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
        }
    ]
}

export default DealershipAdminRoutes
