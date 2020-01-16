import * as Settings from "../../pages/settings"

const SettingsRoutes = {
    path: '/admin/settings',
    name: 'settings',
    component: Settings.Root,
    children:[
        {
            path:'list',
            name: 'listSettings',
            component: Settings.List,
        },

        {
            path:'translations',
            name: 'translationSetting',
            component: Settings.Translation,
        }
    ]
}

export default SettingsRoutes
