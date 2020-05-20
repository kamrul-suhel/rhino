<template>
    <v-dialog
        v-model="dialog"
        :width="existingGuest ? 500 : 800"
    >
        <v-card>
            <v-card-title
                class="headline"
                :style="{backgroundColor: themeOption.primaryColor, color: themeOption.primaryTextColor}"
                primary-title
            >
                <span :style="{color: themeOption.primaryTextColor}">
                    {{ `${trans.bookAGuest}` }}
                </span>
            </v-card-title>

            <v-card-text>
                <v-container grid-list-md pa-0 v-if="existingGuest">
                    <v-layout row wrap>
                        <v-flex xs6>
                            <v-select
                                v-model="selectedSource"
                                :color="themeOption.inputColor"
                                :items="sources"
                                item-text="text"
                                item-value="value"
                                :label="`${trans.selectSource}`"
                            ></v-select>
                        </v-flex>

                        <v-flex xs6>
                            <v-autocomplete
                                v-model="selectedGuest"
                                :items="guests"
                                :loading="isLoading"
                                :color="themeOption.primaryColor"
                                :search-input.sync="search"
                                clearable
                                hide-details
                                hide-selected
                                item-text="unique"
                                item-value="unique"
                                :label="`${trans.searchByUniqueCode}`"
                                open-on-clear
                                return-object
                                @change="onSelectGuest()"
                            >
                                <template v-slot:no-data>
                                    <v-list-tile>
                                        <v-list-tile-title>
                                            {{ `${trans.searchByUniqueCode}` }}
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
                                        {{ getStatus(item) }}
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="getNameWithStatus(item)">
                                        </v-list-tile-title>
                                        <v-list-tile-sub-title v-text="item.email"></v-list-tile-sub-title>
                                    </v-list-tile-content>
                                    <v-list-tile-action>
                                        <v-icon>mdi-coin</v-icon>
                                    </v-list-tile-action>
                                </template>
                            </v-autocomplete>
                        </v-flex>
                    </v-layout>
                </v-container>

                <CreateGuest v-else
                             :subComponent="true"
                             type="saleExecutive"
                             @dialogStatus="onDialogStatusChange"
                             @guest="onCreateGuest">
                </CreateGuest>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    v-if="selectedGuest && selectedGuest.id && selectedSource"
                    :color="themeOption.primaryColor"
                    @click="onBookAppointment()"
                >
                    <span :style="{color: themeOption.primaryTextColor}">{{ trans.book }}</span>
                </v-btn>

                <v-btn
                    @color="themeOption.primaryColor"
                    flat
                    @click="onCancel()"
                >
                    {{ trans.cancel }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'
    import CreateGuest from '@/pages/guest/Create'

    export default {
        components: {
            CreateGuest
        },

        data() {
            return {
                isLoading: false,
                search: null,
                guests: [],
                selectedGuest: {},
                selectedSource: null,
                sources: [],
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                selectedEvent: 'getSelectedEvent'
            }),

            dialog: {
                get: function () {
                    return this.$store.getters.getBookAGuestDialog
                }, set: function (value) {
                    this.$store.commit('setBookAGuestDialog', value)
                    if(!value){
                        this.guests = []
                    }
                }
            }
        }),

        props: {
            appointment: {
                type: Object,
                required: true
            },

            existingGuest: {
                type: Boolean,
                default: true
            }
        },

        watch: {
            search(val) {
                if (this.guests.length > 0) return
                this.isLoading = true
                // Lazily load input items
                const URL = `/api/guests/dropdown?type=uniqueId&eventId=${this.selectedEvent.id}&search=${val}`
                axios.get(URL).then((response) => {
                    if (response.data) {
                        this.guests = [...response.data.guests]
                        this.isLoading = false
                    }
                })
            }
        },

        created() {
            this.generateSource()
        },

        methods: {

            onSelectGuest(guest){
            },

            onBookAppointment() {
                let guestForm = new FormData()
                _.forOwn(this.selectedGuest, (value, key) => {
                    guestForm.append(key, value)
                })

                guestForm.append('method', this.selectedSource)
                guestForm.append('status', 0)
                guestForm.append('_method', 'PUT')

                // submit for appointment
                axios.post(`/api/guests/${this.selectedGuest.id}`, guestForm).then((response) => {
                    if (response.data.success) {
                        let appointmentForm = new FormData()
                        _.forOwn(this.appointment, (value, key) => {
                            if (key === 'slotId') {
                                appointmentForm.append('slot_id', value)
                                return
                            }

                            appointmentForm.append(key, value)
                        })
                        appointmentForm.append('event_id', this.selectedEvent.id)
                        appointmentForm.append('user_id', this.selectedUser.id)
                        appointmentForm.append('guest_id', this.selectedGuest.id)
                        appointmentForm.append('status', 0)
                        appointmentForm.append('type', 'pending')

                        const URL = `/api/booking`
                        axios.post(URL, appointmentForm).then((response) => {
                            if (response.data.success) {
                                this.onRedirectToBooking()
                            }
                        })
                    }
                })
            },

            onCreateGuest(guest) {
                this.selectedGuest = {...guest}
                this.onBookAppointment()
            },

            onDialogStatusChange() {

            },

            onRedirectToBooking() {
                axios.get('/refresh_csrf_token').then((csrfResponse) => {
                    let csrfToken = csrfResponse.data.csrfToken

                    let guestLogin = new FormData()
                    guestLogin.append('uniqueId', this.selectedGuest.unique)
                    // login guest into frontend
                    axios.post('/guests/login', guestLogin, {
                        'X-CSRF-TOKEN': csrfToken
                    }).then((loginResponse) => {
                        if (loginResponse.data.success) {
                            this.dialog = false
                            window.open('/booking?source=admin&type=calendar&redirect=calendar', '_blank')
                        }
                    })
                })
            },

            onCancel() {
                this.dialog = false
                this.selectedGuest = {}
                this.selectedSource = null
            },

            generateSource() {
                let sources = fn.getBookGuestOptions(this.trans)
                this.sources = [...sources]
            },

            getStatus(guest){
                switch(guest.status){
                    case 0:
                        return 'P'
                    case 1:
                        return 'C'
                    case 2:
                        return 'A'
                    case 3:
                        return 'N'
                    case 4:
                        return 'S'
                    case 5:
                        return 'NS'
                    default:
                        return guest.name.charAt(0)
                }
            },

            getNameWithStatus(guest){
                return fn.getGuestNameWithStatus(guest, this.trans)
            }
        }
    }
</script>
