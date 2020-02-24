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
                            :src="getEventBanner()"
                            alt=""
                            height="240">
                            <v-layout align-center justify-end class="text-center" cols="12">
                                <v-flex align-self-center>
                                    <h1 class="display-1 font-weight-thin text-lg-right">{{trans.hello}}</h1>
                                </v-flex>
                            </v-layout>
                        </v-parallax>
                    </v-flex>

                    <v-flex xs12 class="rhino-booking">
                        <div class="disabled-state" v-if="isDisable">
                        </div>

                        <v-tabs-items
                            v-model="step"
                            color="black"
                            light
                        >
                            <v-tab-item
                                key="selectModel"
                                value="selectModel"
                            >
                                <FSelectModel></FSelectModel>
                            </v-tab-item>

                            <v-tab-item
                                key="bookYourSlot"
                                value="bookYourSlot"
                            >
                                <FBookAppointment></FBookAppointment>
                            </v-tab-item>

                            <v-tab-item
                                key="partExchange"
                                value="partExchange"
                            >
                                <FPartExchange></FPartExchange>
                            </v-tab-item>

                            <v-tab-item
                                key="confirmYourDetail"
                                value="confirmYourDetail"
                            >
                                <FPersonalDetails></FPersonalDetails>
                            </v-tab-item>

                            <v-tab-item
                                key="bookingConfirmation"
                                value="bookingConfirmation"
                            >

                                <FBookingConfirmation></FBookingConfirmation>
                            </v-tab-item>
                        </v-tabs-items>
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
            currentStep: ''
        }),

        computed: {
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading',
                themeOption: 'getThemeOption',
                isAdmin: 'getIsAdmin',
                trans: 'getFields',
                step: 'getBookingStep',
                isDisable: 'getDisableEditing',
                selectedEvent: 'getSelectedEvent',
                color: 'getFrontendColor',
                selectedLanguage: 'getSubSelectedLanguage'
            })
        },

        watch: {
            themeOption(value) {
                this.$vuetify.theme = this.themeOption.theme
            },
            selectedLanguage(){
                this.initialize()
            }
        },

        created() {
            this.initialize()
        },

        methods: {

            initialize(){
                this.$store.commit('setUserRole', false)
                this.$store.dispatch('fetchGuestBookingData', {languageId: this.selectedLanguage.id})
                this.$store.dispatch('fetchSettingFields', {languageId: this.selectedLanguage.id})
            },

            /**
             * Get event banner image
             * @returns {string|*}
             */
            getEventBanner() {
                const defaultBanner = this.themeOption.eventDefaultImage
                if (
                    this.selectedEvent.banner_image &&
                    this.selectedEvent.banner_image !== 'null' &&
                    this.selectedEvent.banner_image !== 'undefined'
                ) {
                    return this.selectedEvent.banner_image
                }

                return defaultBanner
            }
        }
    }

</script>
