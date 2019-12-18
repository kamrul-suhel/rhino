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
                <h4 class="display-1 mt-5 text-lg-center">Now book your appointment</h4>
            </v-flex>
            <v-layout row no-wrap xs12 mt-5>
                <v-flex md4 xs12>
                    <v-layout column class="book-step" align-center style="border-right: 1px solid rgb(240,240,240)">
                        <v-layout style="flex-grow:0">
                            <h6 class="headline text-lg-center">July <b>2019</b></h6>
                            <label class="caption text-lg-center font-weight-bold ml-2 mt-1" :style="{color:themeOption.brandColor}">12th - 18th March</label>
                        </v-layout>
                        <v-layout row style="width:70%; flex-grow:0" class="mt-4">
                            <label class="body-2">Available Dates</label>
                            <div style="width:12px;height:12px;border:1px solid rgb(100,0,0); border-radius:6px; margin:4px"></div>
                            <label class="body-2 ml-2">No available times</label>
                            <div style="width:12px;height:12px; background-color:rgb(160,160,160); border-radius:6px; margin:4px"></div>
                            <v-layout justify-end>
                                <button :style="{color:themeOption.brandColor}" style="opacity:0.7">Clear</button>
                            </v-layout>
                        </v-layout>
                        <v-sheet width="70%" class="mt-4">
                            <v-calendar
                                ref="calendar"
                                v-model="start"
                                :type="type"
                                :end="end"
                                color="primary"
                            ></v-calendar>
                        </v-sheet>
                    </v-layout>
                </v-flex>

                <v-flex md4 xs12 ml-4>
                    <v-layout column class="book-step" align-center style="border-right: 1px solid rgb(240,240,240)">
                        <v-layout>
                            <h6 class="headline text-lg-center">Choose a <b>sales person</b></h6>
                        </v-layout>
                        <v-layout row justify-end style="width:70%" class="mt-4">
                            <button :style="{color:themeOption.brandColor}" style="opacity:0.7">Clear</button>
                        </v-layout>
                        <v-layout column style="width:70%" class="mt-2" align-center>
                            <v-layout mt-3 row v-for="agent in agents" v-bind:key="trans.agents">
                                <v-avatar :tile="tile2" size="28" color="grey lighten-4">
                                    <img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">
                                </v-avatar>
                                <h6 ml-4 class="body-3 font-weight-thin ml-3 mb-4">Test Name</h6>
                            </v-layout>
                        </v-layout>
                    </v-layout>
                </v-flex>

                <v-flex md4 xs12 mx-4>
                    <v-layout column class="book-step" align-center>
                        <h6 class="headline text-lg-center">Choose a <b>time</b></h6>
                        <v-layout row justify-end style="width:70%" class="mt-4">
                            <button :style="{color:themeOption.brandColor}" style="opacity:0.7">Clear</button>
                        </v-layout>
                        <v-layout row wrap style="width:100%; flex-grow:0" mx-1>
                            <v-responsive :aspect-ratio="1/1" v-for="time in times" v-bind:key="trans.times" style="margin:8px; width: calc(25% - 16px); border: 1px solid rgb(220,220,220)">
                                <v-layout align-center justify-center style="height:100%;width:100%">
                                    <h6 class="body-2">08:00-<br>09:00</h6>
                                </v-layout>
                            </v-responsive>
                        </v-layout>
                        <v-layout row wrap mx-2>
                            <h6 class="body-2 mt-4 mb-2" style="width:100%">Would you like to bring guest?</h6>
                            <v-text-field
                                label="Guest Name"
                                outline style="width:100%"
                            ></v-text-field>
                            <h6 class="body-2" style="width:100%">Might your guest also be interested in changing their car?</h6>
                            <v-checkbox class="mt-1" style="flex-grow:0"
                                v-model="checkbox"
                            ></v-checkbox>
                            <label class="body-2 mt-2 mr-5">Yes</label>
                            <v-checkbox class="mt-1" style="flex-grow:0"
                                v-model="checkbox2"
                            ></v-checkbox>
                            <label class="body-2 mt-2 mr-4">No</label>
                        </v-layout>
                    </v-layout>
                </v-flex>

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
                tile2: false,

                agents: [null,null,null,null,null,null,null,null],
                times: [null,null,null,null,null,null,null,null],

                checkbox: false,
                checkbox2: false,

                type: 'month',
                start: '2019-01-01',
                end: '2019-01-06',
                typeOptions: [
                    { text: 'Day', value: 'day' },
                    { text: '4 Day', value: '4day' },
                    { text: 'Week', value: 'week' },
                    { text: 'Month', value: 'month' },
                    { text: 'Custom Daily', value: 'custom-daily' },
                    { text: 'Custom Weekly', value: 'custom-weekly' }
                ]
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
