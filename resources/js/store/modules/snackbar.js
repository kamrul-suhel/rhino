const defaultState = {
    openDialog: false,
    message: '',
    bgColor: '',
    timeOut: 6000,
    positionX: 'right',
    positionY:  'top'
}

const state = {
    ...defaultState
}

const mutations = {
    setSnackbarMessage(state, option={}){

        if(option.bgColor && typeof(option.bgColor) != 'undefined'){
            state.bgColor = option.bgColor
        }
        if(option.timeOut && typeof(option.timeOut) != 'undefined'){
            state.timeOut = option.timeOut
        }

        if(option.message && typeof(option.message) != 'undefined'){
            state.message = option.message
        }

        if(option.positionX && typeof(option.positionX) != 'undefined'){
            state.positionX = option.positionX
        }

        if(option.positionY && typeof(option.positionY) != 'undefined'){
            state.positionY = option.positionY
        }

        state.openDialog = option.openMessage
    }
}

const getters = {
    getOpenMessage(state){
        return state.openDialog
    },

    getSnackBarMessage(state){
        return state.message
    },

    getSnackBarTimeOut(state){
        return state.timeOut
    },

    getPositionX(state) {
        return state.positionX
    },

    getPositionY(state){
        return state.positionY
    },

    getSnackBarBgColor(state){
        return state.bgColor
    }
}

export default {
    state,
    mutations,
    getters
}
