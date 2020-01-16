import * as Dealership from "../../pages/dealership";

const DealershipRoutes =  {
    path: '/admin/dealerships',
    name: 'dealerships',
    component: Dealership.Root,
    children: [
        {
            path: 'list',
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
        },

        // Edit event for dealership
        {
            path: ':dealershipId/events/:eventId/edit',
            name: 'editDealershipsEvent',
            component: Dealership.Event
        },
        
        // Add staff member to dealership
        {
            path: ':dealershipId/user/create',
            name: 'createDealershipUser',
            component: Dealership.AddUser
        }

    ]
}

export default DealershipRoutes
