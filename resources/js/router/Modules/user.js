function lazyLoad(view){
    return () => import(`../../pages/user/${view}.vue`)
}

const brandsRoute ={
    path: '/admin/users',
    name: 'users',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listUsers',
            component: lazyLoad('List'),
        },

        {
            path:'create',
            name: 'createUsers',
            component: lazyLoad('Create'),
        },

        {
            path:':id/edit',
            name: 'editUsers',
            component: lazyLoad('Edit'),
        }
    ]
}

export default brandsRoute
