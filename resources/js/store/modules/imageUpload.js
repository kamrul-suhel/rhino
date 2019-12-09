const defaultState ={
    image:'',
    image2:'',
    images:[],
    hasImage: false,
    identifier: '',
    identifier2: ''
}

const state = {
    ...defaultState
}

const getters = {
    getUploadedImage(state){
        return state.image
    },

    getUploadedImage2(state){
        return state.image2
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

    setImage2(state, image){
        state.image2 = image
    },

    setImages(state, images){
        state.images = [...images]
    },

    resetImageUpload(state){
        _.forEach(defaultState, (key, value) =>{
            state[value] = key
        })
    },


    setIdentifier(state, identfier){
        state.identfier = identfier
    },

    setIdentifier2(state, identfier){
        state.identifier2 = identfier
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
