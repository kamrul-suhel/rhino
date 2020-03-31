import Vue from 'vue'

Vue.filter('trans', (trans, options = {}) => {
    // Replace all null to *
    let string = _.replace(trans, new RegExp("null", "g"), '*')
     string = _.replace(string, new RegExp("undefined", "g"), '')

    // For string transform
    if (options.type) {
        switch (option.type) {
            default:
        }
    }

    if (!string || 0 === _.replace(string, " ", "").length) {
        string = '*'
    }

    return string
})
