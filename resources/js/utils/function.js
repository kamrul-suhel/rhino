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

        if(payload.languageId && typeof (payload.languageId) !== 'undefined'){
            params += `&languageId=${payload.languageId}`
        }

        if(payload.model && typeof (payload.model) !== 'undefined'){
            params += `&model=${payload.model}`
        }

        if(payload.edit && typeof (payload.edit) !== 'undefined'){
            params += `&edit=${payload.edit}`
        }

        if(payload.filterBy && typeof (payload.filterBy) !== 'undefined'){
            params += `&filterBy=${payload.filterBy}`
        }

        if(payload.id && typeof (payload.id) !== 'undefined'){
            params += `&id=${payload.id}`
        }

        if(payload.brandId && typeof (payload.brandId) !== 'undefined'){
            params += `&brandId=${payload.brandId}`
        }

        if(payload.dealershipId && typeof (payload.dealershipId) !== 'undefined'){
            params += `&dealershipId=${payload.dealershipId}`
        }

        if(payload.countryId && typeof (payload.countryId) !== 'undefined'){
            params += `&countryId=${payload.countryId}`
        }

        if(payload.vehicleType && typeof (payload.vehicleType) !== 'undefined'){
            params += `&vehicleType=${payload.vehicleType}`
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

    getStartTimeEndTime(date , dealership) {
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
     * @returns {[]}
     */
    getDates(startDate, stopDate) {
        let dateArray = [];
        let currentDate = startDate;
        while (currentDate <= stopDate) {
            dateArray.push(moment(currentDate).format('YYYY-MM-DD'))
            currentDate = moment(currentDate).add(1, 'days');
        }
        return dateArray;
    },
}
