function lazyLoad(view){
    return () => import(`../../pages/company/${view}.vue`)
}
const CompanyRoutes = {
    path: '/admin/companies',
    name: 'companies',
    component: lazyLoad('Root'),
    children: [
        {
            path: 'list',
            name: 'listCompanies',
            component: lazyLoad('List')
        }
    ]
}

export default CompanyRoutes


