const defaultState ={
    image:'',
    images:[],
    hasImage: false
}

const state = {
    ...defaultState
}

const getters = {
    getUploadedImage(state){
        return state.image
    },

    getUploadedImages(state){
        return state.images
    },

    getHasImage(state){
        return state.hasImage
    }
}


const mutations = {
    setImage(state, image){
        state.image = image
    },

    setImages(state, images){
        state.images = [...images]
    },

    resetImageUpload(state){
        state = {...defaultState}
    },

    setHasImage(state, hasImage){
        state.hasImage = hasImage
    }
}

const actions = {

}

export default {
    state,
    mutations,
    getters,
    actions
}
