<template>
    <v-select
        :rules="[v => !!v || `${trans.select_a} ${trans.country}`]"
        :color="themeOption.inputColor"
        :label="trans.select_country"
        v-model="dealership.country"
    ></v-select>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        computed: ({
            ...mapGetters({
                countries: 'getCountries',
                trans: 'getFields',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption'
            })
        }),

        created() {
            this.$store.dispatch('fetchCountries')
        },

        methods: {}
    }
</script>
