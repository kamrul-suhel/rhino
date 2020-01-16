import * as Groups from "../../pages/dealership/group";

const DealershipGroupsRoutes =  {
    path: '/admin/dealerships/groups',
    name: 'dealershipsGroups',
    component: Groups.Root,
    children: [
        {
            path: 'list',
            name: 'listDealershipsGroups',
            component: Groups.List
        },

        {
            path: 'create',
            name: 'addDealershipsGroups',
            component: Groups.Create
        },

        {
            path: ':id/edit',
            name: 'editDealershipsGroups',
            component: Groups.Edit
        }
    ]
}

export default DealershipGroupsRoutes
