import * as User from "../../pages/user";

const brandsRoute ={
    path: '/users',
    name: 'users',
    component: User.Root,
    children:[
        {
            path:'list',
            name: 'listUsers',
            component: User.List,
        },

        {
            path:'create',
            name: 'createUsers',
            component: User.Create,
        },

        {
            path:'{id}/edit',
            name: 'editUsers',
            component: User.Edit,
        }
    ]
}

export default brandsRoute
