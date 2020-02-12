<template>
    <v-container fluid px-5>
        <h1>Analytics</h1>

    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import {Chrome} from 'vue-color'
    
    export default {
    
        data() {
            return {
                analyticsData: {},
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
            })
        }),

        created() {
            this.fetchAnalytics()
        },

        mounted() {
        },

        methods: {
            fetchAnalytics() {
                this.$store.dispatch('fetchAnalytics', { id: this.selectedEvent.id } );
            },

            // Initialize data when first render
            initialize() {

                this.$store.dispatch('fetchAnalytics', { id: this.selectedEvent.id })
            },
        }
    
    }
</script>
