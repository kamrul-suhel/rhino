function lazyLoad(view){
    return () => import(`../../pages/vehicles/${view}.vue`)
}
const vehiclesRoute ={
    path: '/admin/vehicles',
    name: 'vehicles',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listVehicles',
            component: lazyLoad('List')
        },

        {
            path:'create',
            name: 'addVehicles',
            component: lazyLoad('Create')
        },

        {
            path:':id/edit',
            name: 'editVehicles',
            component: lazyLoad('Edit')
        },
    ]
}

export default vehiclesRoute
