function lazyLoad(view){
    return () => import(`../../pages/event/type/${view}.vue`)
}

const EventTypesRoutes =  {
    path: '/admin/events/types',
    name: 'eventTypes',
    component: lazyLoad('Root'),
    children: [
        {
            path: 'list',
            name: 'listEventTypes',
            component: lazyLoad('List')
        }
    ]
}

export default EventTypesRoutes
