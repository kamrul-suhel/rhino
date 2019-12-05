<template>
    <div>

        <v-navigation-drawer
            v-model="drawer"
            permanent
            v-if="1 == 0"
            :width="themeOption.drawerWidthF"
            fixed class="navigation-drawer">

            <v-layout align-center justify-center>
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
                        label="EN"
                        hide-details
                        prepend-icon="map"
                        append-icon="expand_more"
                    ></v-select>
                </v-flex>
            </v-layout>

            <v-layout column>
                <v-flex mx-5>
                    <h1 :style="{color:themeOption.secondaryColor}" class='font-weight-black event-title'>Vauxhall Platinum Event</h1>
                </v-flex>
                <v-flex my-3 mx-5>
                    <h4 :style="{color:themeOption.brandColor}" mt-4>XX.XX.XX - XX.XX.XX</h4>
                </v-flex>
            </v-layout>

            <v-stepper vertical class="vertical-stepper mt-4 font-weight-bold">
                <v-stepper-step step="1">Select an app</v-stepper-step>

                <v-stepper-step class="font-weight-bold" :complete="e6 > 2" step="2">Configure analytics for this app</v-stepper-step>

                <v-stepper-step class="font-weight-bold" :complete="e6 > 3" step="3">Select an ad format and name ad unit</v-stepper-step>

                <v-stepper-step class="font-weight-bold" step="4">View setup instructions</v-stepper-step>

                <v-stepper-step class="font-weight-bold" step="4">View setup instructions</v-stepper-step>

            </v-stepper>
        </v-navigation-drawer>

        <v-layout column v-if="1 == 0">
            <v-flex>
                <v-parallax :src="`https://cdn2.buyacar.co.uk/sites/buyacar/files/styles/w860/public/alfa-romeo-giulia67-1_0.jpg?itok=cM6fGydG`" alt="" height="240">
                    <v-flex align="center" justify="center" class="text-center" cols="12">
                        <h1 class="display-1 font-weight-thin text-lg-right">{{trans.greeting_f}}</h1>
                    </v-flex>
                </v-parallax>
            </v-flex>
            <v-flex>
                <h5 class="headline mt-5 text-lg-center">{{trans.greeting_f}}</h5>
                <v-flex align="center" justify="center">
                    <v-layout row sm4 mt-4 justify-center>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey" depressed>New</v-btn>
                            </div>
                        </v-flex>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey" depressed>Used</v-btn>
                            </div>
                        </v-flex>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 light-grey" depressed>Unsure</v-btn>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-flex>

            <v-layout row wrap>
                <v-flex xs3 pa-5 v-for="car in cars" v-bind:key="trans.cars">
                    <v-layout column>
                        <v-flex>
                            <img style="width:100%" src="https://www.enterprise.co.uk/content/dam/global-vehicle-images/cars/OPEL_INSI_2014.png" alt="">
                            <h6 class="title mt-2 font-weight-light text-md-center">Corsa</h6>
                        </v-flex>
                    </v-layout>
                </v-flex>

            </v-layout>

            <v-layout>
                <v-flex align="center" justify="center">
                    <v-layout row sm4 my-5 justify-center>
                        <v-flex class="grow-0">
                            <div>
                                <v-btn class="border-medium height-50 rounded-25 theme-color padding-l-85 padding-r-45" depressed>Skip this step <v-icon class="padding-l-35" small dark>arrow_forward</v-icon></v-btn>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-layout>

        <v-layout column>
            <v-flex>
                <v-parallax :src="`https://cdn2.buyacar.co.uk/sites/buyacar/files/styles/w860/public/alfa-romeo-giulia67-1_0.jpg?itok=cM6fGydG`" alt="" height="240">
                    <v-flex align="center" justify="center" class="text-center" cols="12">
                        <h1 class="display-1 font-weight-thin text-lg-right">{{trans.greeting_f}}</h1>
                    </v-flex>
                </v-parallax>
            </v-flex>
            <v-flex>
                <h4 class="headline mt-5 text-lg-center">Now book your appo</h4>
            </v-flex>
<!--            <v-layout row no-wrap>-->
<!--                <v-layout column>-->
<!--                    <v-layout row>-->
<!--                        <h6 class="display-1 mt-5 text-lg-center">July <b>2019</b></h6>-->
<!--                        <label class="body-2 mt-5 text-lg-center">12th - 18th March</label>-->
<!--                        <v-layout row>-->
<!--                            <label class="body-2">Available Dates</label>-->
<!--                            <label class="body-2">No available times</label>-->
<!--                            <button>Clear</button>-->
<!--                        </v-layout>-->
<!--                        <v-layout row>-->
<!--                            <label class="body-2">M</label>-->
<!--                            <label class="body-2">T</label>-->
<!--                            <label class="body-2">W</label>-->
<!--                            <label class="body-2">T</label>-->
<!--                            <label class="body-2">F</label>-->
<!--                            <label class="body-2">S</label>-->
<!--                            <label class="body-2">S</label>-->
<!--                            <v-spacer></v-spacer>-->
<!--                            <v-spacer></v-spacer>-->
<!--                            <v-spacer></v-spacer>-->
<!--                            <v-spacer></v-spacer>-->
<!--                            <v-spacer></v-spacer>-->
<!--                            <button>30</button>-->
<!--                            <button>01</button>-->
<!--                            <button>02</button>-->
<!--                            <button>03</button>-->
<!--                            <button>04</button>-->
<!--                            <button>05</button>-->
<!--                            <button>06</button>-->
<!--                            <button>07</button>-->
<!--                            <button>08</button>-->
<!--                            <button>09</button>-->
<!--                            <button>10</button>-->
<!--                            <button>11</button>-->
<!--                            <button class="border-brandcolor">12</button>-->
<!--                            <button class="border-brandcolor">13</button>-->
<!--                            <button class="border-brandcolor">14</button>-->
<!--                            <button class="border-brandcolor">15</button>-->
<!--                            <button class="border-brandcolor">16</button>-->
<!--                            <button class="bcolor-supportcolor">17</button>-->
<!--                            <button>18</button>-->
<!--                            <button>19</button>-->
<!--                            <button>20</button>-->
<!--                            <button>21</button>-->
<!--                            <button>22</button>-->
<!--                            <button>23</button>-->
<!--                            <button>24</button>-->
<!--                            <button>25</button>-->
<!--                            <button>26</button>-->
<!--                            <button>27</button>-->
<!--                            <button>28</button>-->
<!--                            <button>29</button>-->
<!--                        </v-layout>-->
<!--                    </v-layout>-->
<!--                </v-layout>-->

<!--                <v-layout column>-->
<!--                    <v-layout row>-->
<!--                        <h6 class="display-1 mt-5 text-lg-center">Choose a <b>sales person</b></h6>-->
<!--                        <v-layout row>-->
<!--                            <button>Clear</button>-->
<!--                        </v-layout>-->
<!--                        <v-layout>-->
<!--                            <v-flex v-for="agent in agents" v-bind:key="trans.agents">-->
<!--                                <v-avatar-->
<!--                                    :tile="tile"-->
<!--                                    size="2" &lt;!&ndash; make this dynamic &ndash;&gt;-->
<!--                                    color="grey lighten-4">-->
<!--                                    <img src="https://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar">-->
<!--                                </v-avatar>-->
<!--                                <h6 class="headline">I don't mind</h6>-->
<!--                            </v-flex>-->
<!--                        </v-layout>-->
<!--                    </v-layout>-->
<!--                </v-layout>-->

<!--                <v-layout column>-->
<!--                    <v-layout row>-->
<!--                        <h6 class="display-1 mt-5 text-lg-center">Choose a <b>time</b></h6>-->
<!--                        <v-layout row>-->
<!--                            <button>Clear</button>-->
<!--                        </v-layout>-->
<!--                        <v-layout>-->
<!--                            <button>-->
<!--                                <h6 class="headline">08:00-<br>09:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">09:00-<br>10:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">10:00-<br>11:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">11:00-<br>12:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">12:00-<br>13:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">13:00-<br>14:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">14:00-<br>15:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">15:00-<br>16:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">16:00-<br>17:00</h6>-->
<!--                            </button>-->
<!--                            <button>-->
<!--                                <h6 class="headline">17:00-<br>18:00</h6>-->
<!--                            </button>-->
<!--                        </v-layout>-->
<!--                        <v-layout>-->
<!--                            <h6 class="body-2">Would you like to bring guest?</h6>-->
<!--                            <v-text-field-->
<!--                                label="Outline"-->
<!--                                outline-->
<!--                            ></v-text-field>-->
<!--                            <h6 class="body-2">Might your guest also be interested in changing their car?</h6>-->
<!--                            <v-checkbox-->
<!--                                v-model="checkbox"-->
<!--                                :label="`Checkbox 1: ${checkbox.toString()}`"-->
<!--                            ></v-checkbox>-->
<!--                            <label class="body-2">Yes</label>-->
<!--                            <v-checkbox-->
<!--                                v-model="checkbox"-->
<!--                                :label="`Checkbox 1: ${checkbox.toString()}`"-->
<!--                            ></v-checkbox>-->
<!--                            <label class="body-2">No</label>-->
<!--                        </v-layout>-->
<!--                    </v-layout>-->
<!--                </v-layout>-->

<!--            </v-layout>-->
        </v-layout>

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
                cars: [null,null,null,null,null,null,null,null],
                agents: [null,null,null,null,null,null,null,null]
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
