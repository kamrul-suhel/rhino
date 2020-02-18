import Vue from 'vue'

Vue.filter('trans', (trans, type = null) => {
    // Replace all null to *
    let string =_.replace(trans, new RegExp("null","g"), '*')

    // For string transform
    switch(type){
        default:
    }

    if(!string || 0 === _.replace(string, " ", "").length){
        string = '*'
    }

    return string
})
