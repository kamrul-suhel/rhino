<template>
    <v-layout row wrap pa-5
              class="dealership-dashboard dashboard"
              justify-center>
        <v-flex xs12 sm6>
            <v-layout row wrap align-center mb-2>
                <v-flex class="text-xs-center">
                    <span class="title">{{ trans.guests.toUpperCase() }}</span>
                </v-flex>
            </v-layout>

            <v-layout row wrap>
                <v-flex xs12>
                    <v-autocomplete
                        v-model="selectedGuest"
                        :items="guests"
                        :loading="isLoading"
                        :color="themeOption.primaryColor"
                        append-icon="search"
                        :search-input.sync="search"
                        clearable
                        outline
                        small
                        hide-details
                        hide-selected
                        item-text="name"
                        item-value="symbol"
                        :placeholder="`${trans.searchGuestByEmail}`"
                        open-on-clear
                        return-object
                        class="search-user"
                        @change="onSelectGuest()"
                    >
                        <template v-slot:no-data>
                            <v-list-tile>
                                <v-list-tile-title>
                                    {{ `${trans.searchGuestByEmail}` }}
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
                                <v-list-tile-title v-html="getNameWithStatus(item)"></v-list-tile-title>
                                <v-list-tile-sub-title v-text="item.email"></v-list-tile-sub-title>
                            </v-list-tile-content>
                            <v-list-tile-action>
                                <v-icon>mdi-coin</v-icon>
                            </v-list-tile-action>
                        </template>
                    </v-autocomplete>
                </v-flex>
            </v-layout>

            <v-container grid-list-lg pa-0 pt-4>
                <v-layout row wrap>
                    <v-flex xs12 sm4>
                        <v-card flat hover
                                height="136"
                                @click="onNavigateTo('bookAGuest')"
                                class="guest-card">
                            <v-card-title class="guest-card-title pb-0">
                                <v-img width="30"
                                       contain
                                       height="30"
                                       src="/images/icons/book_a_guest.jpg"/>
                            </v-card-title>

                            <v-card-text class="text-xs-center">
                                {{ `${trans.bookAGuest}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12 sm4 v-if="checkAccessLevel('dealership')">
                        <v-card flat hover
                                height="136"
                                @click="onNavigateTo('downloadUnbookedGuest')"
                                class="guest-card">
                            <v-card-title class="guest-card-title pb-0">
                                <v-img width="30"
                                       contain
                                       height="30"
                                       src="/images/icons/download_unbooked_guest.jpg"/>
                            </v-card-title>

                            <v-card-text class="text-xs-center">
                                {{ trans.download }} <br/> {{trans.unbookedGuest}}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12 sm4 v-if="checkAccessLevel('dealership')">
                        <v-card flat hover

                                height="136"
                                @click="onNavigateTo('downloadBookedGuest')"
                                class="guest-card">
                            <v-card-title class="guest-card-title pb-0">
                                <v-img width="30"
                                       contain
                                       height="30"
                                       src="/images/icons/download_book_guest.jpg"/>
                            </v-card-title>

                            <v-card-text class="text-xs-center">
                                {{ trans.download }} <br/> {{trans.bookedGuest}}
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>

        <v-flex xs12 sm6>
            <v-layout row wrap align-center mb-2>
                <v-flex  class="text-xs-center">
                    <span class="title">{{ trans.organize.toUpperCase() }}</span>
                </v-flex>
            </v-layout>

            <v-container grid-list-lg pt-0>
                <v-layout row wrap>
                    <v-flex xs6>
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                :to="{name: 'dealershipAdminCalendar'}">
                            <v-icon :color="themeOption.dashboardIcon">fa-calendar-alt</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.calendar}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6 v-if="checkAccessLevel('dealership')">
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                hover
                                @click="onNavigateTo('editDealershipEvent')">
                            <v-icon large color="#000">access_time</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.editEvent}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6>
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                hover
                                @click="onNavigateTo('eventSales')">
                            <v-img width="36"
                                       height="36"
                                       class="mx-auto"
                                       contain
                                       src="/images/icons/country.jpg"/>
                            <v-card-text class="px-2">
                                {{ `${trans.updateSales}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6 v-if="checkAccessLevel('dealership')">
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                hover
                                @click="onNavigateTo('dealershipAnalytics')">
                            <v-icon large color="#000">bar_chart</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.analytics}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6 v-if="checkAccessLevel('dealership')">
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                hover
                                @click="onNavigateTo('editDealership')">
                            <v-icon large color="#000">contacts</v-icon>
                            <v-card-text class="px-2">
                                {{ `${trans.users}` }}
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'
    import CONST from "../../utils/const";

    export default {
        components: {},

        data() {
            return {
                isLoading: false,
                search: null,
                guests: [],
                selectedGuest: {}
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                dealership: 'getSelectedDealership',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
                selectedDealership: 'getSelectedDealership',
                authUser: 'getAuthUser',
            })
        }),

        watch: {
            search(val) {
                if (this.guests.length > 0) return
                this.isLoading = true
                // Lazily load input items
                const URL = `/api/guests/dropdown?eventId=${this.selectedEvent.id}&search=${val}`
                axios.get(URL).then((response) => {
                    if (response.data) {
                        this.guests = [...response.data.guests]
                        this.isLoading = false
                    }
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.welcomeBack}`)
            this.guests = []
        },

        methods: {
            onSelectGuest(guest) {
                this.$router.push({
                    name: 'dealershipGuestShow',
                    params: {
                        dealershipId: this.dealership.id,
                        guestId: this.selectedGuest.id
                    }
                })
            },

            onNavigateTo(type) {
                switch (type) {
                    case 'dealershipAnalytics':
                        this.$router.push({name: 'dealershipAnalytics', params: {eventId: this.selectedEvent.id}})
                        return

                    case 'eventSales':
                        this.$router.push({name: 'eventSales', params: {eventId: this.selectedEvent.id}})
                        return

                    case 'editDealershipEvent':
                        this.$router.push({
                            name: 'editDealershipsEvent',
                            params: {
                                dealershipId: this.selectedDealership.id,
                                eventId: this.selectedEvent.id
                            }
                        })
                        return

                    case 'bookAGuest':
                        this.$router.push({name: 'dealershipAdminBookAGuest'});
                        return

                    case 'downloadUnbookedGuest':
                        this.$store.commit('setDownloadUnBookGuest', true)
                        return

                    case 'downloadBookedGuest':
                        this.$store.commit('setDownloadBookGuest', true)
                        return

                    case 'editDealership':
                        this.$router.push({
                            name: 'editDealerships',
                            params: {
                                id: this.selectedDealership.id
                            }
                        })
                        return
                }
            },

            getNameWithStatus(guest){
                return fn.getGuestNameWithStatus(guest, this.trans)
            },

            checkAccessLevel(type){
                const authLevel = this.authUser.level
                switch(type){
                    case CONST.MANAGER:
                        return authLevel === type ? true : false

                    case CONST.RECEPTIONIST:
                        return authLevel === type ? true : false

                    case CONST.CALL_HANDLER:
                        return authLevel === type ? true : false
                }

            }
        }
    }
</script>
