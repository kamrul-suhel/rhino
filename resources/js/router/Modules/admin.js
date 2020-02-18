function lazyLoad(view){
    return () => import(`../../pages/admin/${view}.vue`)
}
const admin ={
    path: '/admin',
    name: 'adminLogin',
    component: lazyLoad('Root')

}

export default admin
