<template>
    <v-flex sm12 md7 px-5>
        <v-layout row wrap class="booking-confirmed-disabled">
            <div>
                <h1>{{ trans.yourBookingIsConfirmed }}</h1>
                <p>{{ trans.sendEmailMessage }}</p>
            </div>

            <v-flex xs12>
                <v-container grid-list-lg pa-0>
                    <v-layout row wrap>
                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>access_time
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        {{ trans.time }}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        <strong :style="{color: color}">
                                            {{ slot.start|dateFormat('HH:mm', selectedLanguage.language_code) }} - {{ slot.end|dateFormat('LT', selectedLanguage.language_code)}}
                                        </strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>person
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        {{ `${trans.salesPerson}`}}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        <strong :style="{color: color}">{{ saleExecutive.firstname }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>date_range
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        {{ trans.date }}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        <strong :style="{color: color}">{{ date| dateFormat('DD/MM/YYYY', selectedLanguage.language_code) }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs6 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>compare_arrows
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="body-1 text-xs-center">
                                        {{ trans.partExchange }}
                                    </h6>
                                </v-flex>

                                <v-flex xs12>
                                    <h6 class="registration-confirmation">
                                        <strong :style="{color: color}">{{ getPartExchangeTitle() }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 sm4>
                            <v-layout justify-center row wrap>
                                <v-flex xs12 class="text-xs-center">
                                    <v-icon
                                        color="grey"
                                        medium dark>person_add
                                    </v-icon>
                                </v-flex>

                                <v-flex xs12 pa-0>
                                    <h6 class="xs12 body-1 text-xs-center">
                                        {{ trans.guests }}
                                    </h6>
                                </v-flex>

                                <v-flex mt-1>
                                    <h6 class="xs12 body-2 text-xs-center">
                                        <strong :style="{color: color}">{{ bringGuest.name }}</strong>
                                    </h6>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                vehicles: 'getBookingSelectedVehicles',
                slot: 'getSelectedSlot',
                saleExecutive: 'getBookingSelectedSaleExecutive',
                bringGuest: 'getBookingBringGuest',
                guest: 'getBookingGuest',
                partExchange: 'getBookingPartExchange',
                date: 'getBookingSelectedDate',
                event: 'getSelectedEvent',
                isDisable: 'getDisableEditing',
                selectedLanguage: 'getSubSelectedLanguage'
            })
        }),

        created() {

        },

        methods: {
            getPartExchangeTitle() {
                let title = ''
                if (this.partExchange.vehicleExchange) {
                    title = this.trans.none
                } else {
                    title = this.partExchange.registrationNumber
                }
                return title
            }
        }
    }
</script>
