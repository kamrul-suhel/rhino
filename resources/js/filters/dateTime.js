import Vue from 'vue'

Vue.filter('dateFormat', (date, format, locale='en') => {
    if(date === 'undefined' && date === 'null'){
        let todayDate = new moment()
        return todayDate.format('MMM do YYYY')
    }

    let newMoment = new moment(date)
    newMoment.locale(locale)

    let filterDate = null
    switch(format){
        case 'LT':
            filterDate = newMoment.format('LT')   // 18:15
            break

        case 'LTS':
            filterDate = newMoment.format('LTS')
            break

        case 'L':
            filterDate =  newMoment.format('L')
            break

        case 'l':
            newMoment.format('l')   // 12.12.2019
            break

        case 'LL':
            filterDate = newMoment.format('LL')   // December 23, 2019 9:57 AM
            break

        case 'll':
            filterDate = newMoment.format('ll')   // Dec 23, 2019
            break

        case 'LLL':
            filterDate = newMoment.format('LLL')  // December 23, 2019 9:57 AM
            break

        case 'lll':
            filterDate = newMoment.format('lll')  // Dec 23, 2019 9:57 AM
            break

        case 'LLLL':
            filterDate = newMoment.format('LLLL') // Monday, December 23, 2019 9:57 AM
            break

        case 'llll':
            filterDate = newMoment.format('llll') // Mon, Dec 23, 2019 9:57 AM
            break

        default:
            filterDate = newMoment.format('MMMM Do YYYY, h:mm:ss a')  // December 23rd 2019, 9:59:26 am
    }

    return filterDate
})
