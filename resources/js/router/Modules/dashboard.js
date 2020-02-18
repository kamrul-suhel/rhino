function lazyLoad(view){
    return () => import(`../../pages/dashboard/${view}.vue`)
}
const dashboard ={
    path: '/admin/dashboard',
    name: 'dashboard',
    component: lazyLoad('Root')
}

export default dashboard

