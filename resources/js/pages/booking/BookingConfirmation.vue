<template>
    <div>
        <v-container grid-list-l>
            <v-layout row wrap align-center justify-center class="booking-confirmation">
                <v-flex class="xs12" align-center>
                    <h4 class="display-1 mt-5 mx-2 text-xs-center">Please check the following details are correct</h4>
                    <h5 class="headline mt-2 mx-4 text-xs-center">Are these details still correct?</h5>
                </v-flex>
                <v-flex row nowrap mt-5 justify-center class="confirmation-container xs11 md8">
                    <v-container mt-4>
                        <v-layout row wrap justify-center>
                            <v-flex xs12 md5>
                                <v-layout>
                                    <h6>Your model(s) of interest:</h6>
                                    <h6>New CORSA</h6>
                                    <v-btn v-else class="border-medium height-40 rounded-25 light-grey">ADMIN</v-btn>
                                </v-layout>
                            </v-flex>
                            <v-flex xs12 md7>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout>
                                            <v-flex>
                                                <v-layout>
                                                    <v-icon
                                                            color="cccccc"
                                                            large dark>access_time
                                                    </v-icon>
                                                    <label>Time</label>
                                                    <h6>11:00 to 12:00pm</h6>
                                                </v-layout>
                                                <v-layout>
                                                    <v-icon
                                                        color="cccccc"
                                                        large dark>person
                                                    </v-icon>
                                                    <label>Sales Person</label>
                                                    <h6>Hayley Trevellion</h6>
                                                </v-layout>
                                                <v-layout>
                                                    <v-icon
                                                        color="cccccc"
                                                        large dark>date_range
                                                    </v-icon>
                                                    <label>Date</label>
                                                    <h6>2/11/2019</h6>
                                                </v-layout>
                                            </v-flex>
                                            <v-btn v-else class="border-medium height-40 rounded-25 light-grey">AMEND</v-btn>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12 md6>
                                        <v-layout>
                                            <v-icon
                                                color="cccccc"
                                                large dark>compare_arrows
                                            </v-icon>
                                            <label>Part Exchange</label>
                                            <h6 class="registration-confirmation"></h6>
                                            <v-btn v-else class="border-medium height-40 rounded-25 light-grey">AMEND</v-btn>
                                        </v-layout>
                                    </v-flex>
                                    <v-flex xs12 md6>
                                        <v-layout>
                                            <v-icon
                                                color="cccccc"
                                                large dark>person_add
                                            </v-icon>
                                            <label>Jordan Dinsdale</label>
                                            <label>Sandra Koning</label>
                                            <v-btn v-else class="border-medium height-40 rounded-25 light-grey">AMEND</v-btn>
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
                               :color="light"
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
        </v-container>
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
                color: 'getFrontendColor'
            })
        }),

        methods:{

        }
    }
</script>
