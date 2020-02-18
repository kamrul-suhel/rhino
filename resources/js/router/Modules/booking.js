
function lazyLoad(view){
    return () => import(`../../pages/booking/${view}`)
}
const booking ={
    path: '/booking',
    name: 'booking',
    component: lazyLoad('Frontend')
}

export default booking
