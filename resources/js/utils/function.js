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

        return params
    }
}
