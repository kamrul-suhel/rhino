function lazyLoad(view){
    return () => import(`../../pages/dealership/${view}.vue`)
}

function userLazyLoad(view){
    return () => import(`../../pages/user/${view}.vue`)
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

        {
            path: ':dealershipId/users',
            name: 'dealershipUserList',
            component: userLazyLoad('List')
        },

        // Add staff member to dealership
        {
            path: ':dealershipId/users/create',
            name: 'createDealershipUser',
            component: lazyLoad('AddUser')
        },

        {
            path: ':dealershipId/users/:userId/edit',
            name: 'editDealershipUser',
            component: lazyLoad('EditUser')
        }

    ]
}

export default DealershipRoutes
