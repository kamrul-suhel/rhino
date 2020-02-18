function lazyLoad(view){
    return () => import(`../../pages/event/${view}.vue`)
}

const eventsRoute ={
    path: '/admin/events',
    name: 'events',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listEvents',
            component: lazyLoad('List'),
        },

        {
            path:'create',
            name: 'createEvents',
            component: lazyLoad('Create'),
        },

        {
            path:':id/edit',
            name: 'editEvents',
            component: lazyLoad('Edit')
        }
    ]
}

export default eventsRoute
