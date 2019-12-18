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
            <v-flex align-center>
                <h4 class="display-1 mt-5 text-lg-center">Your Account Details</h4>
            </v-flex>
            <v-layout row no-wrap xs12 mt-5 justify-center>
                <v-layout class="confirmation-step">
                    <v-layout row wrap class="mt-4 ml-4" justify-center>
                        <v-flex style="width:25%; flex-grow:0; margin-left:20%; margin-right:5%" class="mt-2">
                            <h6 class="body-1"><b>First name</b></h6>
                            <v-text-field
                                label="First name"
                                outline
                            ></v-text-field>
                        </v-flex>
                        <v-flex style="width:25%; flex-grow:0; margin-right:20%; margin-left:5%" class="mt-2">
                            <h6 class="body-1"><b>Surname</b></h6>
                            <v-text-field
                                label="Surname"
                                outline
                            ></v-text-field>
                        </v-flex>
                        <v-flex style="width:25%; flex-grow:0; margin-left:20%; margin-right:5%" class="mt-2">
                            <h6 class="body-1"><b>Phone Number</b></h6>
                            <v-text-field
                                label="Phone Number"
                                outline
                            ></v-text-field>
                        </v-flex>
                        <v-flex style="width:25%; flex-grow:0; margin-right:20%; margin-left:5%" class="mt-2">
                            <h6 class="body-1"><b>Email Address</b></h6>
                            <v-text-field
                                label="Email Address"
                                outline
                            ></v-text-field>
                        </v-flex>
                        <v-flex style="width:25%; flex-grow:0; margin-left:20%; margin-right:5%" class="mt-2">
                            <h6 class="body-1"><b>Mailing Address</b></h6>
                            <v-textarea
                                outline
                                labebl="Mailing Address"
                            ></v-textarea>
                        </v-flex>
                        <v-flex style="width:25%; flex-grow:0; margin-right:20%; margin-left:5%" class="mt-2">
                            <h6 class="body-1"><b>Postcode</b></h6>
                            <v-text-field
                                label="Postcode"
                                outline
                            ></v-text-field>
                        </v-flex>
                        <v-layout row style="width:60%; flex-grow:0; margin-left:20%; margin-right:20%" class="mt-2">
                            <v-layout column style="flex-grow:0" class="mr-5">
                                <label>Mailing</label>
                                <v-checkbox class="mt-1" style="flex-grow:0"
                                            v-model="checkbox"
                                ></v-checkbox>
                            </v-layout>
                            <v-layout column style="flex-grow:0" class="mr-5">
                                <label>Email</label>
                                <v-checkbox class="mt-1" style="flex-grow:0"
                                            v-model="checkbox"
                                ></v-checkbox>
                            </v-layout>
                            <v-layout column style="flex-grow:0" class="mr-5">
                                <label>SMS</label>
                                <v-checkbox class="mt-1" style="flex-grow:0"
                                            v-model="checkbox"
                                ></v-checkbox>
                            </v-layout>
                            <v-layout column style="flex-grow:0" class="mr-5">
                                <label>Phone</label>
                                <v-checkbox class="mt-1" style="flex-grow:0"
                                            v-model="checkbox"
                                ></v-checkbox>
                            </v-layout>
                        </v-layout>
                    </v-layout>
                </v-layout>
            </v-layout>
            <v-layout column align-center my-3>
                <v-btn class="height-40 rounded-20 blue-grey darken-4 mb-5" style="color:white; padding-right:45px; padding-left:45px" depressed>SAVE</v-btn>
            </v-layout>
        </v-layout>
    </div>
</template>



<script>
    import {mapGetters} from 'vuex'

    export default {
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
            })
        }),

        methods:{

        }
    }
</script>
