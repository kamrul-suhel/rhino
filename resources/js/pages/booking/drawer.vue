<template>
    <div>
        <v-navigation-drawer
            v-model="drawer"
            :width="themeOption.drawerWidthF"
            fixed
            class="navigation-drawer">

            <v-layout align-center justify-center column style="height:100%">
                <v-layout align-center justify-center style="flex-grow:0">
                    <v-flex mt-5 mb-3 mx-8>
                        <v-layout align-center justify-center>
                            <v-avatar
                                :tile="tile"
                                :size="themeOption.companyIconSizeF"
                                color="grey lighten-4"
                            >
                                <v-img src="http://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar"></v-img>
                            </v-avatar>
                        </v-layout>
                    </v-flex>

                    <v-flex mr-3 ml-12 class="language-select stroke-dropdown">
                        <v-select
                            v-model="e1"
                            :items="languages"
                            menu-props="auto"
                            :label="trans.language"
                            hide-details
                            prepend-icon="map"
                            append-icon="expand_more"
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout column style="flex-grow:0">
                    <v-flex mx-5>
                        <h1 :style="{color:themeOption.secondaryColor}"
                            class='font-weight-black event-title'>Vauxhall Platinum Event
                        </h1>
                    </v-flex>

                    <v-flex my-3 mx-5>
                        <h4 :style="{color:themeOption.brandColor}">XX.XX.XX - XX.XX.XX</h4>
                    </v-flex>
                </v-layout>

                <v-stepper vertical
                           class="vertical-stepper mt-4 font-weight-bold">
                    <v-stepper-step step="1">{{ `${trans.select} ${trans.model}` }}</v-stepper-step>

                    <v-stepper-step class="font-weight-bold"
                                    :color="themeOption.brandColor"
                                    :complete="e6 > 2"
                                    step="2">Book your slot
                    </v-stepper-step>

                    <v-stepper-step class="font-weight-bold" :complete="e6 > 3" step="3">Part Exchange</v-stepper-step>

                    <v-stepper-step class="font-weight-bold" step="4">Confirm your details</v-stepper-step>

                    <v-stepper-step class="font-weight-bold" step="4">Booking Confirmation</v-stepper-step>
                </v-stepper>

                <v-layout row wrap>
                    <v-flex>
                        <v-tabs
                            v-model="model"
                            class="rhinoNavigationStepper"
                        >
                            <v-tab
                                key="selectModel"
                            >
                              <v-avatar>1</v-avatar> {{ `${trans.bookYourSlot}` }}
                            </v-tab>

                            <v-tab
                                key="partExchange"
                            >
                                <v-avatar>2</v-avatar>  {{ `${trans.partExchange}` }}
                            </v-tab>

                            <v-tab
                                key="confirmYourDetail"
                            >
                                <v-avatar>3</v-avatar> {{ `${trans.confirmYourDetails}` }}
                            </v-tab>

                            <v-tab
                                key="BookingConfirmation"
                            >
                                <v-avatar>4</v-avatar> {{ `${trans.bookingConfirmation}` }}
                            </v-tab>
                        </v-tabs>
                    </v-flex>
                </v-layout>

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
                model: 'tab-2',

                items: [
                    { title: 'Book your slot', icon: 'dashboard' },
                    { title: 'Part exchange', icon: 'question_answer' },
                    { title: 'Confirm your details', icon: 'question_answer' },
                    { title: 'Booking confirmation', icon: 'question_answer' }
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
