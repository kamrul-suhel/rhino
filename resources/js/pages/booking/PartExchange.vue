<template>
    <div class="part-exchange">
        <v-layout row wrap>
            <v-flex xs12>
                <h4 class="display-1 mt-5 mx-3 text-xs-center">Do you have a car to part exchange?</h4>
            </v-flex>
            <v-flex xs12>
                <v-layout row wrap mt-5>
                    <v-flex xs12 md6 class="exchange-details" pa-3>
                        <v-layout column nowrap fill-height pa-3>
                            <v-flex>
                                <h6 class="headline">Enter your <b>Details</b></h6>
                                <input class="registration-input mt-4" placeholder="Registration Number">
                                <v-text-field class="mt-4" label="Make and Model"></v-text-field>
                                <v-text-field class="mt-2" label="Current Mileage"></v-text-field>
                                <v-layout row>
                                    <v-checkbox class="mt-1" style="flex-grow:0"
                                                v-model="checkbox3"
                                    ></v-checkbox>
                                    <label class="mt-2 caption" style="white-space:normal;width:80%">By checking this box, you agree to us obtaining a settlement figure for your part exchange vehicle</label>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-flex>

                    <v-flex xs12 md6 class="no-part-exchange" pa-3>
                        <v-layout column nowrap align-center justify-center fill-height pa-3
                                  :style="{border: `4px solid` + color}">
                            <v-flex>
                                <v-icon :style="{color:color}" large class="car-icon" style="padding: 15px; border-radius: 50%; background-color: rgb(240,240,240);">directions_car</v-icon>
                            </v-flex>
                            <v-flex>
                                <h2 class="headline text-lg-center mt-4">Click here if you don't have a part exchange vehicle</h2>
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
                                    <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85" depressed>Continue</v-btn>
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
            })
        }),

        methods: {

        }
    }
</script>
