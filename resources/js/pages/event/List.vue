<template>
    <div>


        <EventForm></EventForm>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="events"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.events} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.events} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalEvents"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.event }}</td>
                        <td>{{ props.item.country }}</td>
                        <td>{{ props.item.dealership }}</td>
                        <td>{{ props.item.start }} to {{ props.item.end }}</td>
                        <td>{{ props.item.appointment_duration }}</td>
                        <td>{{ props.item.type }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                class="mr-2"
                                @click="onEditEvent(props.item)"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                :color="themeOption.buttonDangerColor"
                                small
                                @click="onDeleteEvent(props.item)"
                            >
                                delete
                            </v-icon>
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
                    <h3>{{ trans.delete }} {{selectedEvent.name }}</h3>
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text>
                    <v-flex xs12>
                        {{ trans.delete_confirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="onDeleteCancel"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="onConfirmDeleteEvent"
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
    import {Chrome} from 'vue-color'
    import FileUpload from '../../components/ImageUpload'
    import EventForm from './Create'

    export default {
        components: {
            FileUpload,
            Chrome,
            EventForm
        },

        props: {
            subComponent: {
                type: Boolean,
                default: false
            },

            model: {
                type: String,
                default: null
            }
        },

        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                searchBrands: '',
                editBrand: false,
                color: '',
                isColorSwatchActive: false,
                selectedColor: '',
                valid: true,
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                companies: 'getCompanies',
                themeOption: 'getThemeOption',
                events: 'getEvents',
                headers: 'getEventListHeader',
                totalEvents: 'getTotalEvents',
                loading: 'getEventLoading',
                rowsPerPage: 'getBrandListRowsPerPage',
                selectedEvent: 'getSelectedEvent',
                brandImage: 'getUploadedImage',
                updateComponent: 'getUpdateComponent'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            searchBrands() {
                this.initialize()
            },

            selectedColor(value) {
                this.color = value.hex
            },

            
            updateComponent() {
                this.initialize()
            }
        },

        created() {
            this.fetchCompany()
            this.$store.commit( 'setHeaderTitle', `${this.trans.manage} ${this.trans.events}` )
            this.$store.commit( 'setNavTitle', `${this.trans.manage} ${this.trans.events}` )
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {
                let paramObject = {}

                if(this.subComponent){
                    switch(this.model){
                        case 'dealership':
                            paramObject = {
                                'dealershipId': this.$route.params.id,
                                'filterBy' : 'dealership'
                            }
                    }
                }
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchBrands,
                    ...paramObject
                }

                this.$store.dispatch('fetchEvents', paginateOption)
            },

            fetchCompany() {
                this.$store.dispatch('fetchCompanies', {themeOption: this.themeOption, trans: this.trans});
            },

            onEditEvent(event) {
                if(this.subComponent){
                    this.$router.push({
                        name: 'editDealershipsEvent',
                        params: {
                            eventId: event.id,
                            dealershipId: this.$route.params.id
                        }
                    })
                }else{
                    this.$router.push({name: 'editEvents', params: {id: event.id}})
                }
            },

            onDeleteEvent(event) {
                this.deleteDialog = true
                this.$store.commit('setSelectedEvent', event)
            },

            onDeleteCancel() {
                this.deleteDialog = false
                this.$store.commit('setSelectedEvent', {})
            },

            onConfirmDeleteEvent() {
                const selectedEvent = this.selectedEvent
                const URL = `/api/events/${selectedEvent.id}`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.trans.event}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            this.deleteDialog = false
                        }
                    });
            }
        }
    }
</script>
