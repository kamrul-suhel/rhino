function lazyLoad(view){
    return () => import(`../../pages/dealershipAdmin/${view}`)
}

const DealershipAdminRoutes = {
    path: '/admin',
    name:'dealershipAdmin',
    component: lazyLoad('Root'),
    children: [
        {
            path: 'bookguest',
            name: 'dealershipAdminBookAGuest',
            component: lazyLoad('BookGuest')
        },

        {
            path: 'calendar',
            name: 'dealershipAdminCalendar',
            component: lazyLoad('Calendar')
        },

        {
            path: 'events/:eventId/analytics',
            name: 'dealershipAnalytics',
            component: lazyLoad('Analytics')
        },

        {
            path: 'events/:eventId/sales',
            name: 'eventSales',
            component:lazyLoad('SaleUpdate')
        }
    ]
}

export default DealershipAdminRoutes
