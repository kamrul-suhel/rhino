import Vue from 'vue'

Vue.filter('trans', (trans, type = null) => {
    // Replace all null to *
    let string =_.replace(trans, new RegExp("null","g"), '*')

    switch(type){
        default:
    }

    if(!string){
        string = '*'
    }
    return string
})
