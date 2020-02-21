
function lazyLoad(view){
    return () => import(`../../pages/booking/${view}`)
}
const booking ={
    path: '/booking',
    component: lazyLoad('Root'),
    children:[
        {
            path: '/',
            name: 'booking',
            component: lazyLoad('Frontend')
        },
        {
            path: 'confirmed',
            name: 'bookingConfirmed',
            component: lazyLoad('Confirmed')
        }
    ]
}

export default booking
