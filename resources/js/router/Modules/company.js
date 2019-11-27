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
        }
    ]
}

export default CompanyRoutes


