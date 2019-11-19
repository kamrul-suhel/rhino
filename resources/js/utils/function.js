export default {
    getPaginationParam(pagination){
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
    }
}