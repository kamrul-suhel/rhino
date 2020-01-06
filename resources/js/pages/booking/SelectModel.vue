<template>
    <div class="model-section">
        <v-layout column>
            <v-flex>
                <h5 class="headline mt-5 text-lg-center">{{trans.greeting_f}}</h5>
                <v-flex align="center" justify="center">
                    <v-layout row sm4 mt-4 justify-center>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey" depressed>
                                    {{ trans.new }}
                                </v-btn>
                            </div>
                        </v-flex>

                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey" depressed>
                                    {{ trans.used }}
                                </v-btn>
                            </div>
                        </v-flex>

                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey" depressed>
                                    {{ trans.unsure }}
                                </v-btn>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-flex>

            <v-layout row wrap pa-5>
                <v-flex xs12 sm6 md4 lg3 xl2 pa-3
                        v-for="vehicle in vehicles"
                        :key="vehicle.id">

                    <div class="vehicle"
                         :style="{borderColor: onVehicleSelected(vehicle)}">
                        <v-card
                            @click="onSelectVehicle(vehicle)"
                            flat
                        >
                            <v-img
                                contain
                                :aspect-ratio="16/12"
                                :src="vehicle.driver_seating_position_left_image"
                            ></v-img>
                            <v-card-text class="text-xs-center">
                                {{ vehicle.model }}
                            </v-card-text>
                        </v-card>
                    </div>

                </v-flex>

            </v-layout>

            <v-layout>
                <v-flex align="center" justify="center">
                    <v-layout row sm4 my-5 justify-center>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 theme-color padding-l-85 padding-r-45"
                                       outline
                                       :color="color"
                                       depressed>
                                    {{ trans.SkipThisStep }}
                                    <v-icon class="padding-l-35"
                                            :color="color"
                                            small dark>arrow_forward
                                    </v-icon>
                                </v-btn>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-layout>
    </div>
</template>


<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
            }
        },

        created() {

        },

        watch: {
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                vehicles: 'getVehicles',
                dealership: 'getSelectedDealership',
                selectedVehicles: 'getBookingSelectedVehicles',
                color: 'getFrontendColor'
            })
        }),

        methods: {
            onSelectVehicle(vehicle) {
                console.log('set selected vehicle')
            },

            onVehicleSelected(vehicle) {
                return this.color
            }
        }
    }
</script>
