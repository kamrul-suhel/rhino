<template>
    <v-navigation-drawer
        fixed
        clipped
        v-model="drawer"
        app
        width="300"
    >

        <v-layout row wrap align-content-center>
            <v-flex xs12>
                <v-img
                    src="/images/rhino-events-logo.png"
                    aspect-ratio="1"
                    max-width="70%"
                    max-height="30px"
                    contain
                    class="py-5 mx-auto">
                </v-img>
            </v-flex>
        </v-layout>

        <v-divider class="my-2"></v-divider>

        <v-list>
            <v-list-tile @click="onPageChange({link: 'dashboard'})">
                <v-list-tile-action>
                    <v-icon :color="themeOption.dealershipAdminNavColor">home</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>{{ trans.dashboard }}</v-list-tile-title>
            </v-list-tile>

            <div v-for="(navGroup, i) in navs" :key="i">
                <h2 class="px-3 mt-3">{{ navGroup.text }}</h2>

                <template v-for="(nav, i) in navGroup.subGroups">
                    <v-list-tile
                        :key="i"
                        v-if="onCheckAccessLevel(nav)"
                        @click="onPageChange(nav)"
                    >
                        <v-list-tile-action>
                            <v-icon v-text="nav.icon" :color="themeOption.dealershipAdminNavColor"></v-icon>
                        </v-list-tile-action>

                        <v-list-tile-title>{{ nav.text| trans}}</v-list-tile-title>
                    </v-list-tile>

                    <v-divider v-if="nav.divider"></v-divider>
                </template>
            </div>

            <v-list-tile @click="onLogout">
                <v-list-tile-action>
                    <v-icon :color="themeOption.dealershipAdminNavColor">power_settings_new
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-title>{{ trans.logOut }}</v-list-tile-title>
            </v-list-tile>
        </v-list>

        <v-dialog
            v-model="downloadGuest"
            max-width="250"
        >
            <v-card>
                <v-card-title class="headline">
                    <h4>{{ trans.download }}</h4>
                    <h5>{{ `${trans.booked} ${trans.guest}` }}</h5>
                </v-card-title>

                <v-card-text>
                    It is a long established fact that a reader will be distracted by the readable content of a page
                    when looking at its layout.
                </v-card-text>

                <v-card-actions>
                    <v-btn outline round
                           @click="onDownloadGuest()"
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        {{ `${trans.download}` }}
                    </v-btn>

                    <v-btn outline round
                           @click="downloadGuest = false"
                           :color="themeOption.adminNavIconColor"
                           class="ma-0 ml-2">
                        {{ `${trans.cancel}` }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-navigation-drawer>
</template>

<script>
    import {mapGetters} from 'vuex';
    import fn from '@/utils/function'

    export default {
        computed: {
            ...mapGetters({
                themeOption: 'getThemeOption',
                trans: 'getFields',
                languages: 'getLanguages',
                openNavigation: 'getDealershipIsNavigationOpen',
                navs: 'getDealershipNavigation',
                authUser: 'getAuthUser',
                title: 'getNavTitle',
                selectedEvent: 'getSelectedEvent',
                selectedDealership: 'getSelectedDealership',
                eventsForDropDown: 'getEventsForDropDown'
            })
        },

        data() {
            return {
                drawer: true,
                downloadGuest: false,
                downloadType: null
            }
        },
        created() {
            this.$store.commit('setDealershipNavigation', this.trans) // set dealership navigation
        },

        watch: {
            openNavigation() {
                this.drawer = this.openNavigation
            },

            trans(){
                this.$store.commit('setDealershipNavigation', this.trans)
            }
        },

        methods: {
            async onPageChange(item) {
                if(this.$route.name === item.link){
                    return
                }

                if (item.link === 'dealershipUserList') {
                    this.$router.push({
                        name: 'dealershipUserList',
                        params: {
                            dealershipId: this.selectedDealership.id
                        }
                    })
                    return
                }

                if (item.link === 'editDealership') {
                    this.$router.push({
                        name: 'editDealerships',
                        params: {
                            id: this.selectedDealership.id
                        }
                    })
                    return
                }

                // Analytics route
                if (item.link === 'dealershipAnalytics') {
                    this.$router.push({
                        name: 'dealershipAnalytics',
                        params: {
                            eventId: this.selectedEvent.id
                        }
                    })
                    return
                }

                // Check is dialog box
                if (item.isDialog) {
                    this.downloadGuest = true
                    // check type
                    this.downloadType = item.link
                    return
                }

                // Check is edit event
                if (item.link === 'editDealershipsEvent') {
                    const dealershipId = this.authUser.dealership_id
                    const eventId = +this.selectedEvent.id
                    const index = _.findIndex(this.eventsForDropDown, (event) => {
                        return event.id === eventId
                    })

                    if (index < 0) {
                        return // do not have permission to edit this event
                    }

                    this.$router.push({
                        name: 'editDealershipsEvent',
                        params: {
                            dealershipId: dealershipId,
                            eventId: eventId
                        }
                    })
                    return
                }

                // Sale update route
                if(item.link === 'saleUpdate'){
                    this.$router.push({
                        name: 'eventSales',
                        params: {
                            eventId: this.selectedEvent.id
                        }
                    })
                    return
                }

                this.$router.push({name: item.link});
            },

            /**
             * Language change render all translation
             * @param value
             */
            selectedLanguage(value) {
                this.$store.commit('setSelectedLanguage', value)
                this.$store.dispatch('fetchSettingFields', {languageId: value.id})
            },

            onLogout() {
                axios.post('/logout').then((response) => {

                    if (response.data.success) {
                        window.location = '/admin'
                        // reset auth user
                        // this.$store.commit('setAuthUser', {})
                    }
                })
            },

            onCheckAccessLevel(nav) {
                let accessLevel = [...nav.access]
                const authUserRole = this.authUser.level
                const canAccess = _.findIndex(accessLevel, function (level) {
                    return level === authUserRole
                })

                if (canAccess === -1) {
                    return false
                } else {
                    return true
                }
            },

            onDownloadGuest() {
                const URL = `/api/csv/guests/download?downloadType=${this.downloadType}&eventId=${this.selectedEvent.id}`
                const fileName = `${this.trans.booked}${this.trans.guest}`

                axios.get(URL).then((response) => {
                    // Check response success & have some data
                    if (
                        response.data.success &&
                        response.data.guests.length > 0
                    ) {
                        return fn.downloadCSV(response.data.guests, fileName)
                    }
                })
            }
        }
    }
</script>
