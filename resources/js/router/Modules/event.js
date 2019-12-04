import * as Event from "../../pages/event";

const eventsRoute ={
    path: '/events',
    name: 'events',
    component: Event.Root,
    children:[
        {
            path:'',
            name: 'listEvents',
            component: Event.List,
        },

        {
            path:'create',
            name: 'createEvents',
            component: Event.Create,
        },

        {
            path:':id/edit',
            name: 'editEvents',
            component: Event.Edit,
        }
    ]
}

export default eventsRoute
