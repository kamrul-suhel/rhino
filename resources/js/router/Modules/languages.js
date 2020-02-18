function lazyLoad(view){
    return () => import(`../../pages/language/${view}.vue`)
}

const LanguageRoutes = {
    path: '/admin/languages',
    name: 'languages',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listLanguages',
            component: lazyLoad('List'),
        }
    ]
}

export default LanguageRoutes
