<template>
    <div>
        <v-layout row wrap align-center justify-center class="personal-details" px-5>
            <v-flex class="xs12" align-center>
                <h4 class="display-1 mt-5 mx-2 text-xs-center">Please confirm or amend your contact details</h4>
                <h5 class="headline mt-2 mx-4 text-xs-center">Are these details still correct?</h5>
            </v-flex>
            <v-flex row nowrap mt-5 justify-center class="details-container xs12 md8">
                <v-container mt-4 grid-list-xl>
                    <v-layout row wrap justify-center>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>First name</b></h6>
                                    <v-text-field
                                        value="Test First name"
                                        outline
                                        :disabled="isEditable ? false : true"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Surname</b></h6>
                                    <v-text-field
                                        value="Test Surname"
                                        outline
                                        :disabled="isEditable ? false : true"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Phone Number</b></h6>
                                    <v-text-field
                                        value="Test Phone Number"
                                        outline
                                        :disabled="isEditable ? false : true"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1"><b>Email Address</b></h6>
                                    <v-text-field
                                        value="Test Email Address"
                                        outline
                                        :disabled="isEditable ? false : true"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                        <v-flex xs12 my-2>
                            <v-layout row justify-center>
                                <v-btn v-if="isEditable === true" class="height-40 rounded-20 blue-grey darken-4 mb-3" style="color:white; padding-right:45px; padding-left:45px" depressed>SAVE</v-btn>
                                <v-btn v-else class="border-medium height-40 rounded-25 light-grey">EDIT DETAILS</v-btn>
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
                isEditable: true
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
