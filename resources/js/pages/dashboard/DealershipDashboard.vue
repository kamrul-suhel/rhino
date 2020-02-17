<template>
    <v-layout row wrap pa-5
              class="dealership-dashboard"
              justify-center>
        <v-flex xs12 sm6>
            <v-layout row wrap align-center mb-2>
                <v-flex>
                    <h2 class="text-xs-center">{{ trans.guests.toUpperCase() }}</h2>
                </v-flex>
            </v-layout>

            <v-layout row wrap>
                <v-flex xs12>
                    <v-text-field
                        outline
                        small
                        :color="themeOption.inputColor"
                        :label="`${trans.search} ${trans.guests}`"
                        append-icon="search"
                    ></v-text-field>

                </v-flex>
            </v-layout>

            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12 sm4>
                        <v-card flat class="guest-card">
                            <v-card-title class="guest-card-title pb-0">
                                <v-img width="30"
                                       contain
                                       height="30"
                                       src="/images/icons/book_a_guest.jpg"/>
                            </v-card-title>

                            <v-card-text>
                                Book a guest
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12 sm4>
                        <v-card flat class="guest-card">
                            <v-card-title class="guest-card-title pb-0">
                                <v-img width="30"
                                       contain
                                       height="30"
                                       src="/images/icons/download_unbooked_guest.jpg"/>
                            </v-card-title>

                            <v-card-text>
                                Book a guest
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12 sm4>
                        <v-card flat class="guest-card">
                            <v-card-title class="guest-card-title pb-0">
                                <v-img width="30"
                                       contain
                                       height="30"
                                       src="/images/icons/download_book_guest.jpg"/>
                            </v-card-title>

                            <v-card-text>
                                Book a guest
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>

        <v-flex xs12 sm6>
            <v-layout row wrap align-center mb-2>
                <v-flex>
                    <h2 class="text-xs-center">{{ trans.organize.toUpperCase() }}</h2>
                </v-flex>
            </v-layout>

            <v-container grid-list-lg pt-0>
                <v-layout row wrap>
                    <v-flex xs6>
                        <v-card class="elevation-12 py-4 text-xs-center"
                                :to="{name: 'dealershipAdminCalendar'}">
                            <v-icon color="#000">business</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.calendar}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6>
                        <v-card class="elevation-12 py-4 text-xs-center"
                                :to="{
                            name: 'editDealershipsEvent',
                            params:{
                                dealershipId: selectedDealership.id,
                                eventId: selectedEvent.id
                            }
                        }">
                            <v-icon color="#000">access_time</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.edit} ${trans.event}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6>
                        <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'eventSales', params:{eventId: selectedEvent.id}}">
                            <v-icon color="#000">languages</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.update} ${trans.sales}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6>
                        <v-card class="elevation-12 py-4 text-xs-center"
                                :to="{name: 'dealershipAnalytics',
                                params:{
                                    eventId: selectedEvent.id
                                }}">
                            <v-icon color="#000">bar_chart</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.analytics}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6>
                        <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listDealershipsGroups'}">
                            <v-icon color="#000">contacts</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.users}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
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
        },

        methods: {}
    }
</script>
