<template>
    <v-app
        id="inspire"
        white
        class="rhinoFrontend"
    >
        <FDrawer></FDrawer>
        <v-content class="rhinoFrontend">
            <v-container class="content">
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-parallax
                            :src="`https://cdn2.buyacar.co.uk/sites/buyacar/files/styles/w860/public/alfa-romeo-giulia67-1_0.jpg?itok=cM6fGydG`"
                            alt="" height="240">
                            <v-layout align-center justify-end class="text-center" cols="12">
                                <v-flex align-self-center>
                                    <h1 class="display-1 font-weight-thin text-lg-right">{{trans.hello}}</h1>
                                </v-flex>
                            </v-layout>
                        </v-parallax>
                    </v-flex>

                    <v-flex xs12>
                        <v-tabs
                            v-model="active"
                            @change="onChangeTab(active)"
                            color="black"
                            dark
                            slider-color="yellow"
                        >
                            <v-tab
                                key="selectModel"
                                ripple
                            >
                                Select Model
                            </v-tab>

                            <v-tab
                                key="appointment"
                                ripple
                            >
                                Book your Slot
                            </v-tab>

                            <v-tab
                                key="partExchange"
                                ripple
                            >
                                Part Exchange
                            </v-tab>

                            <v-tab
                                key="personalDetail"
                                ripple
                            >
                                Confirm your Details
                            </v-tab>

                            <v-tab
                                key="confirmDetail"
                                ripple
                            >
                                Booking Confirmation
                            </v-tab>

                            <v-tab-item
                                key="selectModel"
                            >
                                <FSelectModel></FSelectModel>
                            </v-tab-item>

                            <v-tab-item
                                key="appointment"
                            >
                                <FBookAppointment></FBookAppointment>
                            </v-tab-item>

                            <v-tab-item
                                key="partExchange"
                            >
                                <FPartExchange></FPartExchange>
                            </v-tab-item>

                            <v-tab-item
                                key="personalDetail"
                            >
                                <FPersonalDetails></FPersonalDetails>
                            </v-tab-item>

                            <v-tab-item
                                key="confirmDetail"
                            >
                                <FBookingConfirmation></FBookingConfirmation>
                            </v-tab-item>
                        </v-tabs>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import FDrawer from './Drawer'
    import FSelectModel from './SelectModel'
    import FBookAppointment from './BookAppointment'
    import FPartExchange from './PartExchange'
    import FPersonalDetails from './PersonalDetails'
    import FBookingConfirmation from './BookingConfirmation'
    import {mapGetters} from 'vuex';

    export default {
        name: 'App',
        components: {
            FDrawer,
            FSelectModel,
            FBookAppointment,
            FPartExchange,
            FPersonalDetails,
            FBookingConfirmation
        },

        data: () => ({
            model: 'tab-1',
            active: null
        }),

        computed: {
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading',
                themeOption: 'getThemeOption',
                isAdmin: 'getIsAdmin',
                trans: 'getFields'
            })
        },

        watch: {
            themeOption(value) {
                this.$vuetify.theme = this.themeOption.theme
            }
        },

        created() {
            this.$store.commit('setUserRole', false)
            this.$store.dispatch('fetchGuestBookingData')
        },

        methods: {
            onChangeTab(key){

            }
        }
    }

</script>
