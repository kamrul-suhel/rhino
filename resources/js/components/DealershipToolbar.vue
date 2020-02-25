<template>
    <v-layout pl-5 pr-5 class="dealershipAdminToolbar">
        <v-flex xs12>
            <v-card elevation="20"
                    class="toolbar"
            >
                <v-card-text class="toolbar-content">
                    <v-layout row wrap fill-height align-center>
                        <v-flex xs12 sm8>
                            <v-layout row wrap fill-height align-center>
                                <v-flex xs12 sm4>
                                    VIP Event
                                </v-flex>

                                <v-flex xs12 sm4>
                                    <v-autocomplete
                                        :items="events"
                                        class="eventDropdown"
                                        :color="themeOption.inputColor"
                                        append-icon="keyboard_arrow_down"
                                        :item-text="selectedEvent.event ? 'event': 'name'"
                                        v-model="selectedEvent"
                                        @change="onEventChange()"
                                        return-object
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12 sm4>
                                    {{ selectedEvent.start | dateFormat('DD')}} - {{ selectedEvent.end |
                                    dateFormat('DD')}} {{ selectedEvent.end | dateFormat('MMMM')}} {{ selectedEvent.end
                                    | dateFormat('YYYY') }}
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 sm4>
                            <v-select
                                :items="dropdownGuests"
                                :color="themeOption.inputColor"
                                :label="`${trans.searchBy} ${trans.guest}`"
                                item-text="name"
                                item-value="id"
                                return-object
                                v-model="selectedGuest"
                                @change="onSelectGuest()"
                            ></v-select>
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        watch: {
            selectedEvent() {
                if (this.selectedEvent) {
                    this.$store.dispatch('fetchBrandsByEventId', {
                        themeOption: this.themeOption,
                        trans: this.trans,
                        eventId: this.selectedEvent.id
                    })
                }
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                isLogin: 'getIsLogin',
                dealership: 'getSelectedDealership',
                events: 'getEventsForDropDown',
                dropdownGuests: 'getGuestsForDropDown',
                totalGuest: 'getTotalGuests'
            }),

            selectedEvent: {
                get: function () {
                    return this.$store.getters.getSelectedEvent
                },
                set: function (value) {
                    this.$store.commit('setSelectedEvent', value)
                }
            },

            selectedGuest: {
                get: function () {
                    return this.$store.getters.getSelectedGuest
                },

                set: function (selectedGuest) {
                    this.$store.commit('setSelectedGuest', selectedGuest)
                }
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchEventForDropDown', {
                    dealershipId: this.dealership.id,
                    selectFirst: true
                })
            },

            onNavigationToggle() {
                this.$store.commit('setIsNavigationOpen')
            },

            onEventChange() {
                this.$store.commit('setUpdateComponent')
                this.$store.dispatch('fetchGuestForDropDown', {eventId: this.selectedEvent.id})
            },

            onSelectGuest() {
                if (this.$route.params.guestId === this.selectedGuest.id) {
                    return
                }

                this.$router.push({
                    name: 'dealershipGuestShow',
                    params: {
                        dealershipId: this.dealership.id,
                        guestId: this.selectedGuest.id
                    }
                })
            }
        }
    }
</script>
