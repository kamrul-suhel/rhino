<template>
    <div>
        <v-toolbar flat :class="{'mt-4' : subComponent}">
            <v-toolbar-title v-if="!subComponent">
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.events }}</span>
            </v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
                v-if="!subComponent"
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :color="themeOption.inputColor"
                :label="`${trans.searchBy} ${trans.event.toLowerCase()} ${trans.name.toLowerCase()}`"
                v-model="searchBrands">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="events"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_brand_found"
                    :no-data-text="trans.no_brand_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalEvents"
                    :loading="loading"
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.event }}</td>
                        <td>{{ props.item.start }}</td>
                        <td>{{ props.item.end }}</td>
                        <td>{{ props.item.type }}</td>
                        <td>{{ props.item.dealership }}</td>
                        <td>{{ props.item.country }}</td>
                        <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
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

    export default {
        components: {
            FileUpload,
            Chrome
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
                brandImage: 'getUploadedImage'
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
            }
        },

        created() {
            this.fetchCompany()
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
                console.log(paginateOption)

                this.$store.dispatch('fetchEvents', paginateOption)
            },

            fetchCompany() {
                this.$store.dispatch('fetchCompanies', {themeOption: this.themeOption, trans: this.trans});
            },

            onEditEvent(event) {
                if(this.subComponent){
                    this.$router.push({
                        name: 'editEvents',
                        params: {
                            id: event.id
                        },
                        query:{
                            previousPage: 'dealership',
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
                                message: `${selectedEvent.name}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            this.deleteDialog = false
                        }
                    });
            }
        }
    }
</script>
