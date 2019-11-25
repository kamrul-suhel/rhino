import * as Dealership from "../../pages/dealership";

const DealershipRoutes =  {
    path: '/dealerships',
    name: 'dealerships',
    component: Dealership.Root,
    children: [
        {
            path: '',
            name: 'listDealerships',
            component: Dealership.List
        },

        {
            path: 'create',
            name: 'addDealerships',
            component: Dealership.Create
        },

        {
            path: ':id/edit',
            name: 'editDealerships',
            component: Dealership.Edit
        }
    ]
}

export default DealershipRoutes
