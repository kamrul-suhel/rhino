import * as Language from "../../pages/test";

const testRoute ={
    path: '/test',
    name: 'test',
    component: Language.Root,
    children:[
        {
            path:'datetime',
            name: 'testDateTime',
            component: Language.Language,
        }
    ]
}

export default testRoute
