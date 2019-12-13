import * as Type from "../../pages/event/type/index";

const EventTypesRoutes =  {
    path: '/events/types',
    name: 'eventTypes',
    component: Type.Root,
    children: [
        {
            path: 'list',
            name: 'listEventTypes',
            component: Type.List
        }
    ]
}

export default EventTypesRoutes
