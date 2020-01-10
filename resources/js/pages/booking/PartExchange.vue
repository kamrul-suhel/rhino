<template>
    <div class="part-exchange px-5">
        <v-layout row wrap>
            <v-flex xs12>
                <h4 class="display-1 mt-5 mx-3 text-xs-center">{{ trans.DoYouHaveACarToPartExchange }}</h4>
            </v-flex>
            <v-flex xs12>
                <v-layout row wrap mt-5>
                    <v-flex xs12 md6 class="exchange-details" pa-3>
                        <v-layout column nowrap fill-height pa-3>
                            <v-flex>
                                <h6 class="headline">{{ trans.enterYour }} <b>{{ trans.details }}</b></h6>
                                <v-text-field class="registration-input mt-4"
                                              :color="color"
                                              v-model="partExchange.registrationNumber"
                                              :placeholder="trans.registrationNumber"
                                ></v-text-field>

                                <v-text-field class="mt-4"
                                              :color="color"
                                              v-model="partExchange.makeAndModel"
                                              :label="trans.makeAndModel"
                                ></v-text-field>

                                <v-text-field class="mt-2"
                                              :color="color"
                                              v-model="partExchange.currentMilege"
                                              :label="trans.currentMileage"
                                ></v-text-field>

                                <v-layout row>
                                    <v-checkbox class="mt-1" style="flex-grow:0"
                                                :color="color"
                                                v-model="partExchange.termCondition"
                                    ></v-checkbox>
                                    <label class="mt-2 caption" style="white-space:normal;width:80%">{{ trans.byCheckingThisBox }}</label>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-flex>

                    <v-flex xs12 md6 class="no-part-exchange" pa-3>
                        <v-layout row wrap align-center
                                  @click="onPartExchangeVehicle()"
                                  justify-center
                                  fill-height pa-3
                                  :style="{borderColor: partExchange.vehicleExchange ? color : '#444'}">
                            <v-flex>
                                <v-icon :style="{color:color}"
                                        large
                                        class="car-icon" style="padding: 15px; border-radius: 50%; background-color: rgb(240,240,240);"
                                >directions_car
                                </v-icon>
                            </v-flex>

                            <v-flex>
                                <h2 class="headline text-lg-center mt-4">{{ trans.clickHereDoNotExchangeVehicle }}</h2>
                            </v-flex>
                        </v-layout>
                    </v-flex>

                </v-layout>
            </v-flex>

            <v-flex>
                <v-layout>
                    <v-flex align="center" justify="center">
                        <v-layout row sm4 my-5 justify-center>
                            <v-flex class="grow-0">
                                <div>
                                    <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85"
                                           depressed
                                    >{{ trans.continue }}
                                    </v-btn>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </div>
</template>



<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return {
                checkbox3: false,
            }
        },

        created(){

        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                partExchange: 'getBookingPartExchange'
            })
        }),

        methods: {
            onPartExchangeVehicle(){
                let partExchange = {
                    ...this.partExchange,
                    vehicleExchange: !this.partExchange.vehicleExchange
                }

                this.$store.commit('setPartExchange', partExchange)
            }
        }
    }
</script>
