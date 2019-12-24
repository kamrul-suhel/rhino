import * as Guest from "../../pages/guest";

const guestsRoute ={
    path: '/admin/guests',
    name: 'guests',
    component: Guest.Root,
    children:[
        {
            path:'list',
            name: 'listGuest',
            component: Guest.List,
        },

        {
            path:'create',
            name: 'createGuest',
            component: Guest.Create,
        },

        {
            path:':id/edit',
            name: 'editGuest',
            component: Guest.Edit,
        }
    ]
}

export default guestsRoute
