import * as Countries from "../../pages/country";

const CountriesRoutes = {
    path: '/admin/countries',
    name: 'countries',
    component: Countries.Root,
    children: [
        {
            path: 'list',
            name: 'listCountries',
            component: Countries.List,
        },

        {
            path: 'create',
            name: 'createCountries',
            component: Countries.Create,
        },

        {
            path: ':id/edit',
            name: 'editCountries',
            component: Countries.Edit,
        }
    ]
}

export default CountriesRoutes


