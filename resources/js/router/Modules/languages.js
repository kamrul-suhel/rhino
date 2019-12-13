import * as Language from "../../pages/language"

const LanguageRoutes = {
    path: '/languages',
    name: 'languages',
    component: Language.Root,
    children:[
        {
            path:'list',
            name: 'listLanguages',
            component: Language.List,
        }
    ]
}

export default LanguageRoutes
