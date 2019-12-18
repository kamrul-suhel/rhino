<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            fixed
            :width="themeOption.drawerWidthF"
            fixed class="navigation-drawer">

            <v-layout align-center justify-center column style="height:100%">
                <v-layout align-center justify-center style="flex-grow:0">
                    <v-flex mt-5 mb-3 mx-8>
                        <v-layout align-center justify-center>
                            <v-avatar
                                :tile="tile"
                                :size="themeOption.companyIconSizeF"
                                color="grey lighten-4"
                            >
                                <img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">
                            </v-avatar>
                        </v-layout>
                    </v-flex>

                    <v-flex mr-3 ml-12 class="language-select stroke-dropdown">
                        <v-select
                            v-model="e1"
                            :items="languagesTemp"
                            menu-props="auto"
                            label="Lang"
                            hide-details
                            prepend-icon="map"
                            append-icon="expand_more"
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout column style="flex-grow:0">
                    <v-flex mx-5>
                        <h1 :style="{color:themeOption.secondaryColor}" class='font-weight-black event-title'>Vauxhall Platinum Event</h1>
                    </v-flex>
                    <v-flex my-3 mx-5>
                        <h4 :style="{color:themeOption.brandColor}" mt-4>XX.XX.XX - XX.XX.XX</h4>
                    </v-flex>
                </v-layout>

                <v-stepper vertical class="vertical-stepper mt-4 font-weight-bold">
                    <v-stepper-step step="1">Select Model</v-stepper-step>

                    <v-stepper-step class="font-weight-bold" :color="themeOption.brandColor" :complete="e6 > 2" step="2">Book your slot</v-stepper-step>

                    <v-stepper-step class="font-weight-bold" :complete="e6 > 3" step="3">Part Exchange</v-stepper-step>

                    <v-stepper-step class="font-weight-bold" step="4">Confirm your details</v-stepper-step>

                    <v-stepper-step class="font-weight-bold" step="4">Booking Confirmation</v-stepper-step>

                </v-stepper>

                <v-layout mb-3 mx-0 grow align-end justify-center>
                    <h2 class="my-1 mr-4">Jordan <v-icon medium>settings_applications</v-icon></h2>
                    <div>
                        <v-btn class="border-medium rounded-25 theme-color" depressed>LOG OUT</v-btn>
                    </div>
                </v-layout>
            </v-layout>
        </v-navigation-drawer>
    </div>
</template>



<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return {
                drawer: true,
                tile: false,
                e1: 1,
                e6: 1,
                languagesTemp: [
                    { text: 'EN'},
                    { text: 'DE' }
                ],
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
