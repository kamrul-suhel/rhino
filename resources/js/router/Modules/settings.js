import * as Settings from "../../pages/settings"

const SettingsRoutes = {
    path: '/settings',
    name: 'settings',
    component: Settings.Root,
    children:[
        {
            path:'',
            name: 'listSettings',
            component: Settings.List,
        }
    ]
}

export default SettingsRoutes
