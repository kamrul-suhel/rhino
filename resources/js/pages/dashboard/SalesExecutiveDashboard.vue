<template>
    <v-layout row wrap pa-5
              class="dealership-dashboard"
              justify-center>
        <v-flex xs12 sm6>
            <h2>Sale executive dashboard</h2>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        components: {},

        data() {
            return {}
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
                selectedDealership: 'getSelectedDealership'
            })
        }),

        watch: {},

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.welcome} ${this.trans.back}`)
        },

        methods: {
            onNavigateTo(type){
                switch(type) {
                    case 'dealershipAnalytics':
                        this.$router.push({name: 'dealershipAnalytics', params:{eventId: this.selectedEvent.id}})
                        break

                    case 'eventSales':
                        this.$router.push({name: 'eventSales', params:{eventId: this.selectedEvent.id}})
                        break

                    case 'editDealershipEvent':
                        this.$router.push({
                            name: 'editDealershipsEvent',
                            params: {
                                dealershipId: this.selectedDealership.id,
                                eventId: this.selectedEvent.id
                            }
                        })
                }
            }
        }
    }
</script>
