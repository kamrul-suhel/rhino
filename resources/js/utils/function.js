export default {
    getPaginationParam(pagination) {
        const shopId = this.selectedShop.id
        let params = '';
        params += '?query_type=productPage';
        if (shopId) {
            params += '&shopId=' + shopId + '&allSerial=true'
        }

        if (this.selectedCategory && this.selectedCategory !== null) {
            params += '&category_id=' + this.selectedCategory
        }

        _.map(this.pagination, (value, key) => {
            params += `&${key}=${value}`
        })
        return params;
    },

    /**
     * helper function to generate params
     * @param payload
     * @returns {string}
     */
    generateParams(payload) {
        if(payload === null){
            return ''
        }

        let params = '?'
        if (payload.type && typeof (payload.type) != 'undefined') {
            params += `type=${payload.type}`
        }

        if (payload.rowsPerPage && typeof (payload.rowsPerPage) != 'undefined') {
            params += `&rowsPerPage=${payload.rowsPerPage}`
        }

        if (payload.paginate && typeof (payload.paginate) != 'undefined') {
            params += `&paginate=true`
        }

        if (payload.page && typeof (payload.page) != 'undefined') {
            params += `&page=${payload.page}`
        }

        if (payload.sortBy && typeof (payload.sortBy) != 'undefined') {
            params += `&sortBy=${payload.sortBy}`
        }

        if (payload.search && typeof (payload.search) != 'undefined') {
            params += `&search=${payload.search}`
        }

        if (payload.languageId && typeof (payload.languageId) !== 'undefined') {
            params += `&languageId=${payload.languageId}`
        }

        if (payload.model && typeof (payload.model) !== 'undefined') {
            params += `&model=${payload.model}`
        }

        if (payload.edit && typeof (payload.edit) !== 'undefined') {
            params += `&edit=${payload.edit}`
        }

        if (payload.filterBy && typeof (payload.filterBy) !== 'undefined') {
            params += `&filterBy=${payload.filterBy}`
        }

        if (payload.id && typeof (payload.id) !== 'undefined') {
            params += `&id=${payload.id}`
        }

        if (payload.brandId && typeof (payload.brandId) !== 'undefined') {
            params += `&brandId=${payload.brandId}`
        }

        if (payload.dealershipId && typeof (payload.dealershipId) !== 'undefined') {
            params += `&dealershipId=${payload.dealershipId}`
        }

        if (payload.countryId && typeof (payload.countryId) !== 'undefined') {
            params += `&countryId=${payload.countryId}`
        }

        if (payload.vehicleType && typeof (payload.vehicleType) !== 'undefined') {
            params += `&vehicleType=${payload.vehicleType}`
        }

        if (payload.eventId && typeof (payload.eventId) !== 'undefined') {
            params += `&eventId=${payload.eventId}`
        }

        if (payload.saleExecutiveId && typeof (payload.saleExecutiveId) !== 'undefined') {
            params += `&saleExecutiveId=${payload.saleExecutiveId}`
        }

        if (payload.date && typeof (payload.date) !== 'undefined') {
            params += `&date=${payload.date}`
        }

        if (payload.ascending && typeof (payload.ascending) !== 'undefined') {
            params += `&ascending=${payload.ascending}`
        }

        if (payload.descending && typeof (payload.descending) !== 'undefined') {
            params += `&descending=${payload.descending}`
        }

        return params
    },


    /**
     *
     * @param time
     * @param event
     * @returns {*[]}
     */
    getTimeSlotsForDay(time, event) {
        const appointmentDuration = event.appointment_duration
        const breakTime = event.break_time

        let timeSlots = []
        let dayStart = moment(time.start)
        let dayEnd = moment(time.end)

        do {
            let newDate = moment(dayStart).add(appointmentDuration, 'minutes')
            const times = {
                start: dayStart.format('YYYY-MM-DD HH:mm:ss'),
                end: newDate.format('YYYY-MM-DD HH:mm:ss'),
                slotId: timeSlots.length
            }

            dayStart.add(appointmentDuration, 'minutes')
            timeSlots.push(times)
        } while (dayStart <= dayEnd);

        return [...timeSlots]
    },

    getStartTimeEndTime(date, dealership) {
        const startTime = `${moment(date).format('dddd').toLowerCase()}_start`
        const endTime = `${moment(date).format('dddd').toLowerCase()}_end`

        return {
            start: `${date} ${dealership[startTime]}`,
            end: `${date} ${dealership[endTime]}`
        }
    },


    /**
     * Generate dates between start date & end dates
     * @param startDate
     * @param stopDate
     * @param dealership
     * @returns {[]}
     */
    getDates(startDate, stopDate, dealership = null) {
        let dateArray = []
        let currentDate = startDate
        while (currentDate <= stopDate) {
            if (dealership) {
                // Check day dealership is closed or not
                const day = `${moment(currentDate).format('dddd').toLowerCase()}_start`

                if (dealership[day] === '00:00:00') {
                    currentDate = moment(currentDate).add(1, 'days')
                    continue
                }

                dateArray.push(moment(currentDate).format('YYYY-MM-DD'))
                currentDate = moment(currentDate).add(1, 'days')
            } else {
                dateArray.push(moment(currentDate).format('YYYY-MM-DD'))
                currentDate = moment(currentDate).add(1, 'days')
            }
        }
        return dateArray
    },

    downloadCSV(data, fileName){
        const {Parser} = require('json2csv')
        const json2csvParser = new Parser()
        const csv = json2csvParser.parse(data)
        let blob = new Blob([csv], {type: "text/csv;charset=utf-8;"});

        if (window.navigator.msSaveBlob) { // IE 10+
            window.navigator.msSaveBlob(blob, `${fileName}.csv`)
        } else {
            let link = document.createElement("a");
            if (link.download !== undefined) { // feature detection
                // Browsers that support HTML5 download attribute
                let url = window.URL.createObjectURL(blob);
                link.setAttribute("href", url);
                link.setAttribute("download", `${fileName}.csv`);
                link.style = "visibility:hidden";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }
    },

    allowedDates(event, dealership) {
        let start = moment(event.start)
        let end = moment(event.end)
        const dates = this.getDates(start, end, dealership)

        return dates
    },

    appointmentStatusString(appointment, trans){
        switch(appointment.status){
            case 0:
                return trans.pending

            case 1:
                return trans.confirmed

            case 3:
                return `${trans.not} ${trns.available}`
            case 4:
                return `${trans.breakTime}`
            case 6:
                return `${trans.cancel}`
        }
    },

    getBookGuestOptions(trans){
        return  [
            {
                'text': trans.email,
                'value': 'email'
            },

            {
                'text': trans.phone,
                'value': 'phone'
            },

            {
                'text': trans.walkIn,
                'value': 'walkIn'
            },

            {
                'text': trans.online,
                'value': 'online'
            }
        ]
    },

    /**
     * Function will generate guest name with status
     * @param guest
     * @returns {string}
     */
    getGuestNameWithStatus(guest, trans){
        let name = guest.name
        switch(guest.status){
            case 0:
                name = `${name} <strong>(${trans.pending}</strong>)`
                break
            case 1:
                name = `${name} <strong>(${trans.confirmed}</strong>)`
                break
            case 2:
                name = `${name} <strong>(${trans.arrived}</strong>)`
                break
            case 3:
                name = `${name} <strong>(${trans.completedNoShow}</strong>)`
                break
            case 4:
                name = `${name} <strong>(${trans.saleMade}</strong>)`
                break
            case 5:
                name = `${name} <strong>(${trans.noShow}</strong>)`
                break
            default:
                name = `${name}`
        }
        return name
    }
}
