<template>
    <div>
        <v-layout row wrap align-center justify-center class="personal-details">
            <v-flex class="xs12" align-center>
                <h4 class="display-1 mt-5 mx-2 text-xs-center">Your Account Details</h4>
            </v-flex>
            <v-flex row nowrap mt-5 justify-center class="details-container xs11 md8">
                <v-container mt-4 grid-list-xl>
                    <v-layout row wrap justify-center>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>First name</b></h6>
                                    <v-text-field
                                        label="First name"
                                        outline
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Surname</b></h6>
                                    <v-text-field
                                        label="Surname"
                                        outline
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Phone Number</b></h6>
                                    <v-text-field
                                        label="Phone Number"
                                        outline
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Email Address</b></h6>
                                    <v-text-field
                                        label="Email Address"
                                        outline
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Mailing Address</b></h6>
                                    <v-textarea
                                        outline
                                        labebl="Mailing Address"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Postcode</b></h6>
                                    <v-text-field
                                        label="Postcode"
                                        outline
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 md8>
                            <v-layout row wrap justify-start>
                                <v-flex column class="mr-5">
                                    <label>Mailing</label>
                                    <v-checkbox class="mt-1"
                                                v-model="checkbox1"
                                    ></v-checkbox>
                                </v-flex>
                                <v-flex column class="mr-5">
                                    <label>Email</label>
                                    <v-checkbox class="mt-1"
                                                v-model="checkbox2"
                                    ></v-checkbox>
                                </v-flex>
                                <v-flex column class="mr-5">
                                    <label>SMS</label>
                                    <v-checkbox class="mt-1"
                                                v-model="checkbox3"
                                    ></v-checkbox>
                                </v-flex>
                                <v-flex column class="mr-5">
                                    <label>Phone</label>
                                    <v-checkbox class="mt-1"
                                                v-model="checkbox4"
                                    ></v-checkbox>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12 my-2>
                            <v-layout row justify-center>
                                <v-btn class="height-40 rounded-20 blue-grey darken-4 mb-3" style="color:white; padding-right:45px; padding-left:45px" depressed>SAVE</v-btn>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
            <v-flex xs12 my-5>
                <v-layout xs12 row justify-center>
                    <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85" depressed>Continue</v-btn>
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
                checkbox1: false,
                checkbox2: false,
                checkbox3: false,
                checkbox4: false,
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
