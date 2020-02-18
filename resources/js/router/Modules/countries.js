function lazyLoad(view){
    return () => import(`../../pages/country/${view}.vue`)
}
const CountriesRoutes = {
    path: '/admin/countries',
    name: 'countries',
    component: lazyLoad('Root'),
    children: [
        {
            path: 'list',
            name: 'listCountries',
            component: lazyLoad('List')
        },

        {
            path: 'create',
            name: 'createCountries',
            component: lazyLoad('Create')
        },

        {
            path: ':id/edit',
            name: 'editCountries',
            component: lazyLoad('Edit')
        }
    ]
}

export default CountriesRoutes


