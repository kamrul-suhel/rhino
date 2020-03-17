<template>
    <div>

        <DealershipForm></DealershipForm>

        <v-data-table
            :headers="headers"
            :items="dealerships"
            disable-initial-sort
            :pagination.sync="pagination"
            :no-results-text="trans.noDealershipFound"
            :no-data-text="trans.noDealershipFound"
            :rows-per-page-text="trans.rowsPerPage === null ? 'Row per page' : trans.rowsPerPage"
            :rows-per-page-items="rowsPerPage"
            :total-items="totalDealership"
            :loading="loading"
            class="elevation-1 r-table"
        >
            <template v-slot:items="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.country }}</td>
                <td class="text-xs-left">{{ props.item.group }}</td>
                <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                <td class="text-xs-right">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editDealerships(props.item)"
                    >
                        edit
                    </v-icon>

                    <v-icon
                        :color="themeOption.buttonDangerColor"
                        small
                        @click="deleteDealerships(props.item)"
                    >
                        delete
                    </v-icon>
                </td>
            </template>
        </v-data-table>

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
                    <h3>{{ trans.delete }} {{ selectedDealership.name }}</h3>
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
                        color="info"
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="confirmDeleteDealerships()"
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
    import DealershipForm from './Create'

    export default {

        components: {
            DealershipForm
        },

        data() {
            return {
                totalDesserts: 0,
                desserts: [],
                pagination: {},
                searchDealerships: '',
                dialog: false,
                deleteDialog: false
            }
        },

        computed: ({
            ...mapGetters({
                dealerships: 'getDealerships',
                trans: 'getFields',
                headers: 'getDealershipListHeader',
                totalDealership: 'getTotalDealership',
                loading: 'getDealershipLoading',
                rowsPerPage: 'getDealershipListRowsPerPage',
                selectedDealership: 'getSelectedDealership',
                themeOption: 'getThemeOption',
                updateComponent: 'getUpdateComponent',
                selectedLanguage: 'getSelectedLanguage'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            searchDealerships() {
                this.initialize()
            },

            updateComponent() {
                this.initialize()
            },

            trans(){
                this.initialize()
            }
        },

        created() {
            this.$store.commit( 'setHeaderTitle', `${this.trans.manageDealerships}` )
            this.$store.commit( 'setNavTitle', `${this.trans.manageDealerships}` )
        },

        methods: {
            // Initialize data when first render
            initialize() {
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchDealerships,
                    languageId: this.selectedLanguage.id
                }

                this.$store.dispatch('fetchDealerships', paginateOption)
            },

            editDealerships(Dealerships) {
                this.$router.push({name: 'editDealerships', params: {id: Dealerships.id}})
            },

            deleteDealerships(Dealerships) {
                this.$store.commit('setSelectedDealership', Dealerships)
                this.deleteDialog = true
            },

            confirmDeleteDealerships() {
                const selectedDealership = this.selectedDealership
                const URL = `/api/dealerships/${selectedDealership.id}/delete`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedDealership.name}  ${this.trans.successfullyDeleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.$store.commit('setSelectedDealership', {})

                            this.deleteDialog = false
                        }
                    });
            }
        }
    }
</script>
