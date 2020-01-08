import * as Admin from "../../pages/admin"

const admin ={
    path: '/admin',
    name: 'adminLogin',
    component: Admin.Root,
    children:[
        {
            path:'dashboard',
            name: 'adminDashboard',
            component: Admin.Dashboard,
        }, 
    ]

}

export default admin
