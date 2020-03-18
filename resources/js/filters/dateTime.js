import Vue from 'vue'

Vue.filter('dateFormat', (date, format, locale='en') => {
    if(date === 'undefined' && date === 'null'){
        let todayDate = new moment()
        return todayDate.format('MMM do YYYY')
    }

    let newMoment = new moment(date)
    newMoment.locale(locale.toLowerCase())

    let filterDate = null
    switch(format){
        case 'LT':
            filterDate = newMoment.format('LT')   // 18:15
            break

        case 'LTS':
            filterDate = newMoment.format('LTS')
            break

        case 'HH:mm':
            filterDate = newMoment.format('HH:mm')
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

        case 'DD/MM/YYYY':
            filterDate = newMoment.format('DD/MM/YYYY')   // December 23, 2019 9:57 AM
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

        case 'HH':
            filterDate = newMoment.format('HH:mm') // 0..23:0..60
            break

        case 'YYYY':
            filterDate = newMoment.format('YYYY') // 2014
            break

        case 'DD':
            filterDate = newMoment.format('DD') // Jan..December
            break

        case 'MMMM':
            filterDate = newMoment.format('MMMM') // Jan..December
            break

        case 'dddd':
            filterDate = newMoment.format('dddd') // Jan..December
            break

        case 'Do':
            filterDate = newMoment.format('Do') // 1st..31st
            break

        case 'MMMM Do':
            filterDate = newMoment.format('MMMM Do') // 1st..31st
            break

        default:
            filterDate = newMoment.format('MMMM Do YYYY, h:mm:ss a')  // December 23rd 2019, 9:59:26 am
    }

    return filterDate
})
