<template>
    <v-container fluid px-5>
        <h1>Analytics</h1>

    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
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
                this.$store.dispatch('fetchAnalytics', {
                    eventId: this.$route.params.eventId
                });
            }
        }

    }
</script>
