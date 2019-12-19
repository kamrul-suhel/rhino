import * as Vehicles from "../../pages/vehicles";

const vehiclesRoute ={
    path: '/vehicles',
    name: 'vehicles',
    component: Vehicles.Root,
    children:[
        {
            path:'list',
            name: 'listVehicles',
            component: Vehicles.List,
        },

        {
            path:'create',
            name: 'addVehicles',
            component: Vehicles.Create,
        },

        {
            path:':id/edit',
            name: 'editVehicles',
            component: Vehicles.Edit,
        },
    ]
}

export default vehiclesRoute
