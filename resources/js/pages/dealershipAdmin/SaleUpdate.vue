<template>
    <div>
        <v-toolbar flat
                   :color="subComponent ? themeOption.toolbarColor : 'adminHeader'">
            <v-text-field xs12 sm4
                          :color="themeOption.inputColor"
                          :label="`${trans.searchByName}`"
                          v-model="searchGuests">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="guests"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.noBrandFound}`"
                    :no-data-text="`${trans.noBrandFound}`"
                    :rows-per-page-text="trans.rowsPerPage"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalGuests"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td>{{ `${props.item.first_name} ${props.item.surname}` }}</td>
                        <td>{{ renderGuestStatus(props.item) }}</td>
                        <td>TEST</td>
                        <td class="text-xs-right">
                            <v-menu>
                                <template #activator="{ on: menu }">
                                    <v-tooltip bottom>
                                        <template #activator="{ on: tooltip }">
                                            <v-btn
                                                :color="themeOption.buttonColor"
                                                flat
                                                v-on="{ ...tooltip, ...menu }"
                                            >{{ `${trans.userStatus}` }}
                                            </v-btn>
                                        </template>
                                        <span>{{ `${trans.updateGuest}` }}</span>
                                    </v-tooltip>
                                </template>
                                <v-list>
                                    <v-list-tile
                                        v-for="(item, index) in items"
                                        :key="index"
                                        @click="onUpdateStatus(props.item, item)"
                                    >
                                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                                    </v-list-tile>
                                </v-list>
                            </v-menu>
                        </td>
                    </template>
                </v-data-table>
            </v-flex>
        </v-layout>

        <v-dialog
            v-model="deleteDialog"
            persistent
            max-width="290"
        >
            <v-card>
                <v-card-title
                    primary-title
                    class="pa-2 pl-3"
                >
                    <h3>{{ trans.delete }} {{selectedGuest.firstname }}</h3>
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text>
                    <v-flex xs12>
                        {{ trans.deleteConfirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="onDeleteConfirm"
                    >
                        {{ trans.delete }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    import UploadGuestCSVComponent from "@/components/Guest/UploadGuestCSVComponent";

    export default {
        components: {
            UploadGuestCSVComponent
        },

        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                searchGuests: '',
                selectedGuest: {},
                items: []
            }
        },

        props: {
            subComponent: {
                type: Boolean,
                default: false
            },

            model: {
                type: String
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                guests: 'getGuests',
                headers: 'getGuestListHeader',
                totalGuests: 'getTotalGuests',
                loading: 'getGuestLoading',
                rowsPerPage: 'getGuestListRowsPerPage',
                updateGuest: 'getInitializeGuest',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                    this.generateButton()
                }
            },

            selectedEvent() {
                this.initialize()
            },

            searchGuests() {
                this.initialize()
            },

            updateGuest() {
                this.initialize()
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.welcomeBack}`)
        },

        methods: {
            // Initialize data when first render
            initialize() {
                if (!this.selectedEvent.id) {
                    return
                }

                let additionalOptions = {}
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchGuests,
                    eventId: this.selectedEvent.id,
                    eventSale: true,
                    ...additionalOptions
                }

                this.$store.dispatch('fetchGuests', paginateOption)
            },

            onEditGuest(guest) {

            },

            onDeleteGuest(guest) {
                this.selectedGuest = {...guest}
                this.deleteDialog = true
            },

            onDeleteConfirm() {
                // Delete guest
                const URL = `/api/guests/${this.selectedGuest.id}`
                axios.delete(URL).then((response) => {
                    this.deleteDialog = false
                    this.initialize()

                    this.$store.commit('setSnackbarMessage', {
                        openMessage: true,
                        timeOut: this.themeOption.snackBarTimeout,
                        message: `${this.selectedGuest.first_name}  ${this.trans.successfullyDeleted}`
                    })
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            /**
             *
             * @param guest
             * @returns {string[]|{datasets: [{backgroundColor: [string, string], borderColor: [string, string], data: number[], label: string}], labels: [string, string]}|{datasets: [{backgroundColor: [string, string], borderColor: [string, string], data: number[], label: string}], labels: [string, string]}|*}
             */
            renderGuestStatus(guest) {
                let status = ''
                switch (guest.status) {
                    case 0:
                        status = this.trans.pending
                        break

                    case 1:
                        status = this.trans.confirmed
                        break

                    case 2:
                        status = this.trans.arrived
                        break

                    case 3:
                        status = this.trans.noSale
                        break

                    case 4:
                        status = this.trans.saleMade
                        break

                    case 5:
                        status = this.trans.completedNoShow
                        break

                    default:
                        status = this.trans.unknown
                }

                return status
            },

            generateButton() {
                this.items = [
                    {
                        title: `${this.trans.guestArrived}`,
                        status: 2, // No sale
                    },

                    {
                        title: `${this.trans.completeNoSale}`,
                        status: 3, // No sale
                    },

                    {
                        title: `${this.trans.completeSaleMade}`,
                        status: 4 // Sale made
                    },

                    {
                        title: `${this.trans.noShow}`,
                        status: 5 // No show
                    }
                ]
            },

            onUpdateStatus(guest, status) {
                let guestForm = new FormData()
                _.forOwn(guest, (value, key) => {
                    if (key === 'status') {
                        guestForm.append('status', status.status)
                    } else {
                        guestForm.append(key, value)
                    }
                })

                guestForm.append('_method', 'put')

                const URL = `/api/guests/${guest.id}`
                axios.post(URL, guestForm).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${guest.first_name}  ${this.trans.successfullyUpdated}`
                        })
                        this.initialize()
                    }
                    // this.loading = false
                }).catch(() => {
                    this.loading = false
                    this.$store.dispatch('initializeError', error)
                })
            }
        }
    }
</script>
