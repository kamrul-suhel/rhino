<template>
    <div class="book-appointment px-5">
        <v-layout row wrap>
            <v-flex xs12>
                <h4 class="display-1 mt-5 text-xs-center">
                    {{ trans.nowBookYourAppointment }}
                </h4>
            </v-flex>
        </v-layout>

        <v-layout row wrap
                  mt-5
                  justify-center>
            <v-flex xs12
                    class="border-right px-4"
                    :md4="vehicleType !== 'unsure'"
                    :md6="vehicleType === 'unsure' || vehicleType === ''">
                <Calender></Calender>
            </v-flex>

            <v-flex xs12 md4
                    class="border-right px-4"
                    v-if="vehicleType !== 'unsure' && vehicleType !== ''">
                <SalePerson></SalePerson>
            </v-flex>

            <v-flex xs12
                    class="px-4"
                    :md4="vehicleType !== 'unsure'"
                    :md6="vehicleType === 'unsure' || vehicleType === ''">
                <ChooseTime></ChooseTime>
            </v-flex>

        </v-layout>

        <v-layout row wrap class="my-5">
            <v-flex xs12 class="text-xs-center">
                    <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85"
                           outline
                           @click="onContinue()"
                           :color="color"
                           depressed>{{ trans.continue }}
                    </v-btn>
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

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                dealership: 'getSelectedDealership',
                selectedVehicles: 'getBookingSelectedVehicles',
                color: 'getFrontendColor',
                selectedEvent: 'getSelectedEvent',
                vehicleType: 'getBookingVehicleType'
            })
        }),

        created(){
        },

        methods:{
            onContinue(){
                this.$store.commit('setBookingStep', 2)
            }
        }
    }
</script>
