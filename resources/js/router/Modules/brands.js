import * as Brands from "../../pages/brands";

const brandsRoute ={
    path: '/brands',
    name: 'brands',
    component: Brands.Root,
    children:[
        {
            path:'list',
            name: 'listBrands',
            component: Brands.List,
        },

        {
            path:'create',
            name: 'createBrands',
            component: Brands.Create,
        },

        {
            path:':id/edit',
            name: 'editBrands',
            component: Brands.Edit,
        },
        
        {
            path: ':brandId/vehicle/create',
            name: 'addBrandVehicle',
            component: Brands.CreateVehicle,
        },

        {
            path: ':brandId/vehicle/:vehicleId',
            name: 'editBrandVehicle',
            component: Brands.EditVehicle,
        }

    ]
}

export default brandsRoute
