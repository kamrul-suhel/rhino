<template>
    <div>
        <v-layout column>
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
                <v-flex xs12 sm6 md4 lg3 xl2 pa-5 v-for="car in cars" v-bind:key="trans.cars">
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
    </div>
</template>



<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return {
                cars: [null,null,null,null,null,null,null,null],
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
