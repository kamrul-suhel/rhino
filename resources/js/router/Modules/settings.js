function lazyLoad(view){
    return () => import(`../../pages/settings/${view}.vue`)
}

const SettingsRoutes = {
    path: '/admin/settings',
    name: 'settings',
    component: lazyLoad('Root'),
    children:[
        {
            path:'list',
            name: 'listSettings',
            component: lazyLoad('List'),
        },

        {
            path:'translations',
            name: 'translationSetting',
            component: lazyLoad('Translation'),
        }
    ]
}

export default SettingsRoutes
