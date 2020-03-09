<template>
    <v-app
        id="rhinoFrontend"
        white
        class="rhinoFrontend"
    >
        <FDrawer></FDrawer>
        <v-content class="rhinoFrontend">
            <v-container class="content">
                <v-layout justify-end class="banner" row wrap :style="{backgroundImage: `url(${getEventBanner()})`}">
                    <v-flex xs12 md5 align-self-center class="mt-5 mr-5">
                        <h1 class="font-weight-thin text-md-right text-right px-4 mr-4">
                            <span v-if="selectedEvent.greeting == 1">{{trans.hello}}</span> <span v-if="selectedEvent.greeting == 0">{{trans.hi}}</span>
                            {{  guest.first_name}} {{ trans.greetingFrontend }} {{ selectedEvent.name }}
                        </h1>
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 class="rhino-booking">
                        <v-tabs-items
                            touchless
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

        <ConfirmDialog></ConfirmDialog>
    </v-app>
</template>

<script>
    import FDrawer from './Drawer'
    import FSelectModel from './SelectModel'
    import FBookAppointment from './BookAppointment'
    import FPartExchange from './PartExchange'
    import FPersonalDetails from './PersonalDetails'
    import FBookingConfirmation from './BookingConfirmation'
    import ConfirmDialog from "@/components/Booking/ConfirmDialog";
    import {mapGetters} from 'vuex';

    export default {
        name: 'App',
        components: {
            FDrawer,
            FSelectModel,
            FBookAppointment,
            FPartExchange,
            FPersonalDetails,
            FBookingConfirmation,
            ConfirmDialog
        },

        data: () => ({
            currentStep: '',
            informal: false,
            formal: false,
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
                selectedLanguage: 'getSubSelectedLanguage',
                guest: 'getBookingGuest'

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
                let defaultBanner = this.themeOption.eventDefaultImage
                if (
                    this.selectedEvent.banner_image &&
                    this.selectedEvent.banner_image !== 'null' &&
                    this.selectedEvent.banner_image !== 'undefined'
                ) {
                    defaultBanner = this.selectedEvent.banner_image
                }

                return defaultBanner
            }
        }
    }

</script>

<style  scoped>
h1 {
    font-size: 30px!important;
}
.banner{
    min-height: 200px;
    background-size: cover;
    color: #fff;
}
</style>
