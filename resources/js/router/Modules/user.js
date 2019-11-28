import * as User from "../../pages/user";

const brandsRoute ={
    path: '/users',
    name: 'users',
    component: User.Root,
    children:[
        {
            path:'/list',
            name: 'listUser',
            component: User.List,
        }
    ]
}

export default brandsRoute
