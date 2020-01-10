<template>
    <div>
        <v-layout row wrap align-center justify-center class="booking-confirmation" px-5>
            <v-flex class="xs12" align-center>
                <h4 class="display-1 mt-5 mx-2 text-xs-center">Please check the following details are correct</h4>
                <h5 class="headline mt-2 mx-4 text-xs-center">Are these details still correct?</h5>
            </v-flex>
            <v-flex row nowrap mt-5 justify-center class="confirmation-container xs12">
                <v-container>
                    <v-layout row wrap justify-center>
                        <v-flex sm12 md5 d-flex child-flex pa-2>
                            <v-card>
                                <v-card-text>
                                    <v-layout row wrap pa-3>
                                        <v-flex xs12 mt-2 pa-0>
                                            <h6 class="title mx-1 text-xs-center">Your model(s) of interest:</h6>
                                        </v-flex>
                                        <v-flex xs12 mt-1 pa-0>
                                            <h6 class="xs10 mx-1 title text-xs-center">New CORSA</h6>
                                        </v-flex>
                                        <v-carousel light height="250" class="mt-2">
                                            <v-carousel-item
                                                v-for="(image,i) in carImages"
                                                :key="i"
                                                :src="image.src"
                                            ></v-carousel-item>
                                        </v-carousel>
                                        <v-flex xs12>
                                            <v-layout justify-center my-3>
                                                <v-btn class="border-medium height-40 mx-1 rounded-25 light-grey">AMEND</v-btn>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                </v-card-text>
                            </v-card>
                        </v-flex>
                        <v-flex sm12 md7 d-flex child-flex pa-2>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <v-card>
                                        <v-card-text>
                                            <v-layout row wrap justify-center pa-3>
                                                <v-flex xs3 mt-4>
                                                    <v-layout justify-center row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                    color="grey"
                                                                    medium dark>access_time
                                                            </v-icon>
                                                        </v-flex>
                                                        <v-flex xs12 mt-2>
                                                            <h6 class="xs12 body-2 text-xs-center" xs12 >Time</h6>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">11:00 to 12:00pm</h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                                <v-flex xs3 mt-4>
                                                    <v-layout justify-center row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>person
                                                            </v-icon>
                                                        </v-flex>
                                                        <v-flex xs12 mt-2>
                                                            <h6 class="xs12 body-2 text-xs-center">Sales Person</h6>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">Hayley Trevellion</h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                                <v-flex xs3 mt-4>
                                                    <v-layout justify-center row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>date_range
                                                            </v-icon>
                                                        </v-flex>
                                                        <v-flex xs12 mt-2>
                                                            <h6 class="xs12 body-2 text-xs-center">Date</h6>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <h6 class="xs12 body-1 text-xs-center">2/11/2019</h6>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                                <v-flex xs12>
                                                    <v-layout justify-center row nowrap mt-4>
                                                        <v-btn class="border-medium height-40 rounded-25 light-grey">AMEND</v-btn>
                                                    </v-layout>
                                                </v-flex>
                                            </v-layout>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                                <v-flex xs12>
                                    <v-layout row wrap class="part-exchange-and-guest">
                                        <v-flex xs12 md6 d-flex child-flex pt-4 pr-2>
                                            <v-card>
                                                <v-card-text>
                                                    <v-layout pa-3 row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>compare_arrows
                                                            </v-icon>
                                                        </v-flex>
                                                        <v-flex xs12 mt-1>
                                                            <h6 class="xs12 body-1 text-xs-center">Part Exchange</h6>
                                                        </v-flex>
                                                        <v-flex mt-1>
                                                            <h6 class="registration-confirmation">TT11 T11</h6>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <v-layout justify-center row nowrap mt-3>
                                                                <v-btn class="border-medium height-40 rounded-25 light-grey">AMEND</v-btn>
                                                            </v-layout>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                        <v-flex xs12 md6 d-flex child-flex pt-4 pl-2>
                                            <v-card>
                                                <v-card-text>
                                                    <v-layout pa-3 row wrap>
                                                        <v-flex xs12 class="text-xs-center">
                                                            <v-icon
                                                                color="grey"
                                                                medium dark>person_add
                                                            </v-icon>
                                                        </v-flex>
                                                        <v-flex xs12 mt-1>
                                                            <h6 class="xs12 body-1 text-xs-center">Guests</h6>
                                                        </v-flex>
                                                        <v-flex mt-1>
                                                            <h6 class="xs12 body-2 text-xs-center">Sandra Koning</h6>
                                                        </v-flex>
                                                        <v-flex xs12>
                                                            <v-layout justify-center row nowrap mt-3>
                                                                <v-btn class="border-medium height-40 rounded-25 light-grey">AMEND</v-btn>
                                                            </v-layout>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-card-text>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
            <v-flex xs12 my-5>
                <v-layout xs12 row justify-center>

                    <v-btn class="border-medium height-50 rounded-25 padding-l-85 padding-r-45"
                           :style="{backgroundColor: color}"
                           style="color:white"
                           depressed>
                        Confirm
                        <v-icon class="padding-l-35"
                                color="white"
                                small light>arrow_forward
                        </v-icon>
                    </v-btn>
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
                isEditable: true,

                carImages: [
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg'
                    },
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg'
                    },
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg'
                    },
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg'
                    }
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
                color: 'getFrontendColor'
            })
        }),

        methods:{

        }
    }
</script>
