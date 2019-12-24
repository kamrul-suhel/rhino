import * as Company from "../../pages/company";

const CompanyRoutes = {
    path: '/admin/companies',
    name: 'companies',
    component: Company.Root,
    children: [
        {
            path: 'list',
            name: 'listCompanies',
            component: Company.List,
        }
    ]
}

export default CompanyRoutes


