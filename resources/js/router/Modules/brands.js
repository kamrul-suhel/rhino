function lazyLoad(view){
    return () => import(`../../pages/brands/${view}.vue`)
}

const brandsRoute ={
    path: '/admin/brands',
    name: 'brands',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listBrands',
            component: lazyLoad('List'),
        },

        {
            path:'create',
            name: 'createBrands',
            component: lazyLoad('Create'),
        },

        {
            path:':id/edit',
            name: 'editBrand',
            component: lazyLoad('Edit'),
        },

        {
            path: ':brandId/vehicle/create',
            name: 'addBrandVehicle',
            component: lazyLoad('CreateVehicle'),
        },

        {
            path: ':brandId/vehicle/:vehicleId',
            name: 'editBrandVehicle',
            component: lazyLoad('EditVehicle'),
        }

    ]
}

export default brandsRoute
