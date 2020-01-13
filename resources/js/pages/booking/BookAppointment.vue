<template>
    <div class="book-appointment px-5">
        <v-layout row wrap>
            <v-flex>
                <h4 class="display-1 mt-5 text-xs-center">
                    {{ trans.nowBookYourAppointment }}
                </h4>
            </v-flex>

            <v-flex>
                <v-layout row wrap mt-5>
                    <v-flex xs12 md4>
                        <Calender></Calender>
                    </v-flex>

                    <v-flex xs12 md4>
                        <SalePerson></SalePerson>
                    </v-flex>

                    <v-flex xs12 md4>
                        <ChooseTime></ChooseTime>
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
                                           outline
                                           @click="onContinue()"
                                           :color="color"
                                           depressed>{{ trans.continue }}
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
    import SalePerson from "@/components/Booking/SalePerson";
    import ChooseTime from "@/components/Booking/ChooseTime";
    import Calender from "@/components/Booking/Calender"

    export default {
        components:{
            SalePerson,
            ChooseTime,
            Calender
        },

        data(){
            return {
            }
        },

        created(){

        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                dealership: 'getSelectedDealership',
                selectedVehicles: 'getBookingSelectedVehicles',
                color: 'getFrontendColor',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        methods:{
            onContinue(){
                this.$store.commit('setBookingStep', 2)
            }
        }
    }
</script>
