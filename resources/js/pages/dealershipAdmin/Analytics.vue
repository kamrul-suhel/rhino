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
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
                analyticsData: 'getAnalyticsData',
                analyticsTotalGuest: 'getAnalyticsTotalGuest',
                analyticGuestInfo: 'getAnalyticsTotalInfo'
            })
        }),

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.analytics}`)
            this.$store.commit('setNavTitle', `${this.trans.analytics}`)
            this.fetchAnalytics()
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
