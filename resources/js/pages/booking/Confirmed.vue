<template>
    <v-app
        id="inspire"
        white
    >
        <v-content>
            <v-container fluid class="pa-0">
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-parallax
                            dark
                            :src="getEventBanner()"
                            :height="240"
                        >
                            <v-layout
                                align-center
                                column
                                justify-center
                            >
                                <h1 class="display-2 font-weight-thin mb-3">{{trans.hello}}</h1>
                            </v-layout>
                        </v-parallax>
                    </v-flex>
                </v-layout>

                <v-layout align-center justify-center column fill-height>
                    <v-flex xs12 class="rhino-booking">
                        <div class="confirmed">
                            <div class="confirmed-content" :style="{borderColor: color}">
                                <div :style="{color: color}" class="mb-3">
                                    <h2>{{trans.yourReservationConfirmed|capitalize}}</h2>
                                </div>

                                <v-btn outline
                                       :color="color"
                                       :to="{name: 'booking'}">
                                    Show booking
                                </v-btn>
                            </div>
                        </div>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: 'App',
        components: {},

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
