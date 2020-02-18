function lazyLoad(view){
    return () => import(`../../pages/guest/${view}.vue`)
}

const guestsRoute ={
    path: '/admin/guests',
    name: 'guests',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listGuest',
            component: lazyLoad('List'),
        },

        {
            path:'create',
            name: 'createGuest',
            component: lazyLoad('Create'),
        },

        {
            path:':id/edit',
            name: 'editGuest',
            component: lazyLoad('Edit'),
        }
    ]
}

export default guestsRoute
