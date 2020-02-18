function lazyLoad(view){
    return () => import(`../../pages/dealership/group/${view}.vue`)
}

const DealershipGroupsRoutes =  {
    path: '/admin/dealerships/groups',
    name: 'dealershipsGroups',
    component: lazyLoad('Root'),
    children: [
        {
            path: 'list',
            name: 'listDealershipsGroups',
            component: lazyLoad('List')
        },

        {
            path: 'create',
            name: 'addDealershipsGroups',
            component: lazyLoad('Create')
        },

        {
            path: ':id/edit',
            name: 'editDealershipsGroups',
            component: lazyLoad('Edit')
        }
    ]
}

export default DealershipGroupsRoutes
