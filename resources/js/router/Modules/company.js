import * as Company from "../../pages/company";

const CompanyRoutes = {
    path: '/companies',
    name: 'companies',
    component: Company.Root,
    children: [
        {
            path: '',
            name: 'listCompanies',
            component: Company.List,
        },

        {
            path: 'create',
            name: 'createCompanies',
            component: Company.Create,
        },

        {
            path: ':id/edit',
            name: 'editCompanies',
            component: Company.Edit,
        }
    ]
}

export default CompanyRoutes


