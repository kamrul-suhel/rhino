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
                            <v-autocomplete
                                v-model="selectedGuest"
                                :items="guests"
                                :loading="isLoading"
                                :color="themeOption.primaryColor"
                                :search-input.sync="search"
                                clearable
                                hide-details
                                hide-selected
                                item-text="name"
                                item-value="symbol"
                                :label="`${trans.searchBy} ${trans.guest}`"
                                open-on-clear
                                return-object
                                @change="onSelectGuest()"
                            >
                                <template v-slot:no-data>
                                    <v-list-tile>
                                        <v-list-tile-title>
                                            {{ `${trans.searchBy} ${trans.guest}` }}
                                        </v-list-tile-title>
                                    </v-list-tile>
                                </template>
                                <template v-slot:selection="{ item, selected }">
                                    <span :selected="selected" v-text="item.name"></span>
                                </template>
                                <template v-slot:item="{ item }">
                                    <v-list-tile-avatar
                                        :color="themeOption.primaryColor"
                                        class="headline font-weight-light white--text"
                                    >
                                        {{ item.name.charAt(0) }}
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-text="item.name"></v-list-tile-title>
                                        <v-list-tile-sub-title v-text="item.email"></v-list-tile-sub-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-icon>mdi-coin</v-icon>
                                    </v-list-tile-action>
                                </template>
                            </v-autocomplete>
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
            return {
                isLoading: false,
                search: null,
                guests:[]
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
                    this.guests = []
                    this.$store.commit('setSelectedGuest', selectedGuest)
                }
            }
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
            },

            search (val) {
                // Lazily load guest items
                if (this.guests.length > 0) return
                this.isLoading = true
                // Lazily load input items
                const URL = `/api/guests/dropdown?eventId=${this.selectedEvent.id}&search=${val}`
                axios.get(URL).then((response) => {
                    if (response.data) {
                        this.guests = [...response.data.guests]
                        this.isLoading = false
                    }
                })

            },

            dropdownGuests(){
                this.isLoading = false
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
                // If selected guest has no id then return to dashboard
                if(!this.selectedGuest.id){
                    this.$router.push({name: 'dashboard'})
                }
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
