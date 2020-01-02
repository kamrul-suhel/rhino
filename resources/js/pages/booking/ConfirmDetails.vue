<template>
    <div>
        <v-layout row wrap>
            <v-flex align-center>
                <h4 class="display-1 mt-5 text-lg-center">Please confirm or amend your contact details</h4>
                <h5 class="headline mt-2 text-lg-center">Are these details still correct?</h5>
            </v-flex>
            <v-layout row no-wrap xs12 mt-5 justify-center>
                <v-layout style="width: 70%; flex-grow: 0; border: 1px solid rgb(240,240,240);">
                    <v-layout row wrap class="mt-4 ml-4" justify-center>
                        <v-flex style="width:20%; flex-shrink:0; margin-left:30%" class="mt-5">
                            <h6 class="body-1"><b>First name</b></h6>
                            <h6 class="body-1 mt-3">Jenny</h6>
                        </v-flex>
                        <v-flex style="width:30%; flex-shrink:0; margin-right:10%" class="mt-5">
                            <h6 class="body-1"><b>Surname</b></h6>
                            <h6 class="body-1 mt-3">Smith</h6>
                        </v-flex>
                        <v-flex style="width:20%; flex-shrink:0; margin-left:30%" class="my-5">
                            <h6 class="body-1"><b>Phone Number</b></h6>
                            <h6 class="body-1 mt-3">0800 123 4567</h6>
                        </v-flex>
                        <v-flex style="width:30%; flex-shrink:0; margin-right:10%" class="my-5">
                            <h6 class="body-1"><b>Email Address</b></h6>
                            <h6 class="body-1 mt-3">jennysmith@email.co.uk</h6>
                        </v-flex>
                        <v-btn class="border-medium height-40 rounded-20 light-grey mb-5" depressed>EDIT DETAILS</v-btn>
                    </v-layout>
                </v-layout>
            </v-layout>
            <v-layout column align-center>
                <v-btn class="border-medium height-50 rounded-25 theme-fill light padding-l-85 padding-r-45 my-5" style="color:white; width:250px; border:none" depressed>Skip this step <v-icon class="padding-l-35" small light style="color:white">arrow_forward</v-icon></v-btn>
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
