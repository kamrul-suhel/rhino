<template>
    <v-container fluid px-5>
        <v-layout row wrap px-4>
            <v-flex xs6>
                <h2>{{ `${trans.book} ${trans.a} ${trans.guest}`}}</h2>
            </v-flex>

            <v-flex xs 6align-self-end>
                <v-layout row wrap justify-end>
                    <v-btn outline round
                           @click="onGoBack()"
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        <v-icon left dark>reply</v-icon>
                        {{ `${trans.back}` }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout mt-4 v-if="showNav">
            <v-flex xs12 sm4>
                <v-card class="r-border-round">
                    <v-list>
                        <v-list-tile
                            avatar
                            @click="onUniqueCode()"
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                    :color="themeOption.adminNavIconColor">more_horiz
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.with} ${trans.a} ${trans.uniqueCode}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile
                            avatar
                            @click="onWithoutUniqueCode()"
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                    :color="themeOption.adminNavIconColor">close
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.without} ${trans.a} ${trans.uniqueCode}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap mt-5 v-if="withUnique">
            <div class="r-tab open">
                <div class="r-tab-title">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">more_horiz
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.with} ${trans.a} ${trans.uniqueCode}` }}
                    </div>
                    <div class="r-tab-title-close">
                        <v-icon
                            :color="themeOption.adminNavIconColor">close
                        </v-icon>
                    </div>
                </div>

                <div class="r-tab-content open">
                    <v-container fluid pa-0 grid-list-xl>
                        <v-layout row wrap>
                            <v-flex xs12 sm8>
                                <v-layout row wrap>
                                    <v-flex xs12 sm6>
                                        <v-select
                                            v-model="selectedSource"
                                            :color="themeOption.inputColor"
                                            :items="sources"
                                            item-text="text"
                                            item-value="value"
                                            flat
                                            box
                                            :label="`${trans.select} ${trans.source}`"
                                        ></v-select>
                                    </v-flex>

                                    <v-flex xs12 sm6>
                                        <v-autocomplete
                                            v-model="selectedGuest"
                                            :items="guests"
                                            :loading="isLoading"
                                            :color="themeOption.primaryColor"
                                            :search-input.sync="search"
                                            clearable
                                            solo
                                            box
                                            hide-details
                                            hide-selected
                                            item-text="name"
                                            item-value="symbol"
                                            :label="`${trans.searchBy} ${trans.guest}`"
                                            open-on-clear
                                            return-object
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
                            </v-flex>

                            <v-flex xs12 class="text-xs-center">
                                <v-btn round
                                       @click="onGuestBookingSubmit()"
                                       :color="themeOption.adminNavIconColor"
                                       class="ma-0">
                                    <span style="color:#fff;">{{ `${trans.submit}` }}</span>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </div>
            </div>
        </v-layout>

        <v-layout row wrap mt-5 v-if="withoutUnique">
            <CreateGuest @dialogStatus="onDialogStatusChange" @guest="onCreateGuest"></CreateGuest>
        </v-layout>

        <v-dialog
            v-model="dialog"
            hide-overlay
            persistent
            width="300"
        >
            <v-card
                :color="themeOption.dialogBoxColor"
                dark
            >
                <v-card-text>
                    Please stand by
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import CreateGuest from '@/pages/guest/Create'
    import fn from '@/utils/function'

    export default {

        components: {
            CreateGuest
        },

        data() {
            return {
                dialog: false,
                selectedGuest: null,
                guests: [],
                selectedSource: null,
                sources: [],
                select: null,
                withUnique: false,
                withoutUnique: false,
                showNav: true,
                isLoading: false,
                search: null
            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        watch: {
            selectedEvent() {
                this.generateSource()
            },

            search(val) {
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
        },

        created() {
            this.generateSource()
            this.$store.commit('setHeaderTitle', `${this.trans.welcome} ${this.trans.back}`)
        },

        methods: {
            async generateSource() {
                let sources = fn.getBookGuestOptions(this.trans)

                this.sources = [...sources]
            },

            onGoBack() {
                this.withUnique = false
                this.withoutUnique = false
                this.showNav = true
            },

            onUniqueCode() {
                this.withUnique = true
                this.showNav = false
                this.withoutUnique = false
            },

            onWithoutUniqueCode() {
                this.withUnique = false
                this.showNav = false
                this.withoutUnique = true
            },

            onGuestBookingSubmit() {
                // validate form
                if (this.selectedSource === '' || this.selectedSource === null) {
                    return
                }
                if (!this.selectedGuest.id) {
                    return
                }

                this.dialog = true

                let guestFormData = new FormData()
                guestFormData.append('event_id', this.selectedEvent.id)
                _.forOwn(this.selectedGuest, (value, key) => {
                    guestFormData.append(key, value)
                })

                guestFormData.append('method', this.selectedSource)
                guestFormData.append('_method', 'PUT')

                // submit for appointment
                axios.post(`/api/guests/${this.selectedGuest.id}`, guestFormData).then((response) => {
                    if (response.data.success) {
                        this.onRedirectToBooking(this.selectedGuest)
                    }
                })
            },

            onDialogStatusChange(status) {
                this.dialog = status
            },

            onCreateGuest(guest) {
                this.onRedirectToBooking(guest)
            },

            onRedirectToBooking(guest) {
                axios.get('/refresh_csrf_token').then((csrfResponse) => {
                    let csrfToken = csrfResponse.data.csrfToken

                    let guestLogin = new FormData()
                    guestLogin.append('uniqueId', guest.unique)
                    // login guest into frontend
                    axios.post('/guests/login', guestLogin, {
                        'X-CSRF-TOKEN': csrfToken
                    }).then((loginResponse) => {
                        if (loginResponse.data.success) {
                            this.dialog = false
                            this.$router.push({name: 'booking'})
                        }
                    })
                })
            }
        }
    }
</script>
