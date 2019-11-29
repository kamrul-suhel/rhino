import * as Frontend from "../../pages/frontend";
import * as Brands from "../../pages/brands";

const frontendRoute ={
    path: '/frontend',
    name: 'frontend',
    component: Frontend.Root,
    children:[
        {
            path:'',
            name: 'frontendIndex',
            component: Frontend.Frontend,
        }
    ]
}

export default frontendRoute
