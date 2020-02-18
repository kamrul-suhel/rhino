function lazyLoad(view){
    return () => import(`../../pages/test/${view}.vue`)
}

const testRoute ={
    path: '/test',
    name: 'test',
    component: lazyLoad('Root'),
    children:[
        {
            path:'datetime',
            name: 'testDateTime',
            component: lazyLoad('Language'),
        }
    ]
}

export default testRoute
