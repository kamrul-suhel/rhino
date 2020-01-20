<template>
    <div class="model-section" px-5>
        <v-layout column>
            <v-flex>
                <h5 class="headline mt-5 text-lg-center"
                    :style="{color: color}">{{trans.greeting_f}}
                </h5>

                <v-flex justify="center">
                    <v-layout row sm4 mt-4 justify-center>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey"
                                       @click="onFilterVehicle('new')"
                                       :class="{selected: vehicleType === 'new'} "
                                       depressed>
                                    {{ trans.new }}
                                </v-btn>
                            </div>
                        </v-flex>

                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey"
                                       :class="{selected: vehicleType === 'used'} "
                                       @click="onFilterVehicle('used')"
                                       depressed>
                                    {{ trans.used }}
                                </v-btn>
                            </div>
                        </v-flex>

                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey"
                                       :class="{selected: vehicleType === 'unsure'} "
                                       @click="onFilterVehicle('unsure')"
                                       depressed>
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
                            hover
                            :disabled="vehicleType === ''"
                            :class="{disabled: vehicleType === ''}"
                            raised
                            @click="onSelectVehicle(vehicle)"
                            flat
                        >
                            <v-img
                                contain
                                :aspect-ratio="16/12"
                                :src="renderVehicleImage(vehicle)"
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
                                       @click="onContinue"
                                       :color="color"
                                       depressed>
                                    {{ skipStep ? trans.continue : trans.skipThisStep }}
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
                skipStep: false
            }
        },

        created() {

        },

        watch: {
            selectedVehicles() {
                if (this.vehicles.length > 0) {
                    this.skipStep = true
                } else {
                    this.skipStep = false
                }
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                vehicles: 'getEventVehicles',
                dealership: 'getSelectedDealership',
                selectedVehicles: 'getBookingSelectedVehicles',
                color: 'getFrontendColor',
                selectedEvent: 'getSelectedEvent',
                vehicleType: 'getBookingVehicleType'
            })
        }),

        methods: {
            onSelectVehicle(vehicle) {
                // If vehicle type not select then do not add into vehicle list
                if(this.vehicleType === ''){
                    return
                }

                this.$store.commit('setOrRemoveVehicle', vehicle)
            },

            onVehicleSelected(vehicle) {
                if(this.vehicleType === ''){
                    return;
                }

                let selected = ''
                _.map(this.selectedVehicles, (currentVehicle) => {
                    if (vehicle.id === currentVehicle.id) {
                        selected = this.color
                    }
                })

                return selected
            },

            onFilterVehicle(type) {
                this.$store.commit('setBookingVehicleType', type)
                this.$store.dispatch('fetchEventVehicles', {
                    id: this.selectedEvent.id,
                    vehicleType: type,
                    themeOption: this.themeOption,
                    trans: this.trans
                })
            },

            onContinue() {
                this.$store.commit('setBookingStep', 1)
            },

            renderVehicleImage(vehicle) {
                if (vehicle.image !== null) {
                    return vehicle.image
                }

                const dealershipSeatingPosition = this.dealership.driver_seating_position

                switch (dealershipSeatingPosition) {
                    case 'right':
                        return vehicle.driver_seating_position_right_image

                    case 'left':
                        return vehicle.driver_seating_position_left_image

                    default:
                        return this.themeOption.brandDefaultImage
                }
            }
        }
    }
</script>
