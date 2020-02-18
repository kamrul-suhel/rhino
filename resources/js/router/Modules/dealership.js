function lazyLoad(view){
    return () => import(`../../pages/dealership/${view}.vue`)
}

const DealershipRoutes =  {
    path: '/admin/dealerships',
    name: 'dealerships',
    component: lazyLoad('Root'),
    children: [
        {
            path: 'list',
            name: 'listDealerships',
            component: lazyLoad('List')
        },

        {
            path: 'create',
            name: 'addDealerships',
            component: lazyLoad('Create')
        },

        {
            path: ':id/edit',
            name: 'editDealerships',
            component: lazyLoad('Edit')
        },

        // Edit event for dealership
        {
            path: ':dealershipId/events/:eventId/edit',
            name: 'editDealershipsEvent',
            props: true,
            component: lazyLoad('Event')
        },

        // Add staff member to dealership
        {
            path: ':dealershipId/user/create',
            name: 'createDealershipUser',
            component: lazyLoad('AddUser')
        }

    ]
}

export default DealershipRoutes
