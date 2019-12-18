<template>
    <div>
        <v-layout column>
            <v-flex>
                <v-parallax :src="`https://cdn2.buyacar.co.uk/sites/buyacar/files/styles/w860/public/alfa-romeo-giulia67-1_0.jpg?itok=cM6fGydG`" alt="" height="240">
                    <v-layout align-center justify-end class="text-center" cols="12">
                        <v-flex align-self-center>
                            <h1 class="display-1 font-weight-thin text-lg-right">{{trans.greeting_f}}</h1>
                        </v-flex>
                    </v-layout>
                </v-parallax>
            </v-flex>
            <v-flex>
                <h4 class="display-1 mt-5 text-lg-center">Do you have a car to part exchange?</h4>
            </v-flex>
            <v-layout row no-wrap xs12 mt-5>
                <v-layout column style="width: calc(50% - 20px); margin: 10px; border: 1px solid rgb(240,240,240)">
                    <v-layout class="mt-4 ml-4">
                        <h6 class="headline">Enter your <b>Details</b></h6>
                    </v-layout>
                    <v-layout column style="width: calc(100% - 40px); margin:20px">
                        <input class="registration-input mt-4" placeholder="Registration Number" style="width: 330px; height: 70px; background-color: rgb(255,180,0); border: 1px solid rgb(160,120,0); border-radius: 7px; text-transform: uppercase; color: black; font-size: 25px; line-height: 25px; padding: 22.5px;">
                        <v-text-field class="mt-4" label="Make and Model"></v-text-field>
                        <v-text-field class="mt-2" label="Current Mileage"></v-text-field>
                        <v-layout row>
                            <v-checkbox class="mt-1" style="flex-grow:0"
                                        v-model="checkbox3"
                            ></v-checkbox>
                            <label class="mt-2 caption" style="white-space:normal;width:80%">By checking this box, you agree to us obtaining a settlement figure for your part exchange vehicle</label>
                        </v-layout>
                    </v-layout>
                </v-layout>

                <v-layout column align-center justify-center style="width: calc(50% - 20px); margin: 10px; border: 1px solid rgb(240,240,240)">
                    <v-icon :style="{color:themeOption.brandColor}" large class="car-icon">directions_car</v-icon>
                    <h2 class="headline text-lg-center mt-4" style="width:50%; white-space:normal; text-align:center">Click here if you don't have a part exchange vehicle</h2>
                </v-layout>

            </v-layout>

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
            })
        }),

        methods:{

        }
    }
</script>
