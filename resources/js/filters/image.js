import Vue from 'vue'

Vue.filter('image', (image, defaultImage) => {
    if(image && image !== 'undefined' && image.length > 0){
        return image
    }
    return defaultImage
})
