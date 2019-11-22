<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.dealerships }}</span>
            </v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :color="themeOption.inputColor"
                :label="trans.search_by_name_or_country"
                v-model="searchDealerships">
            </v-text-field>
        </v-toolbar>

        <v-data-table
            :headers="headers"
            :items="dealerships"
            :pagination.sync="pagination"
            :no-results-text="trans.no_dealership_found"
            :no-data-text="trans.no_dealership_found"
            :rows-per-page-text="trans.rows_per_page"
            :rows-per-page-items="rowsPerPage"
            :total-items="totalDealership"
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:items="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.country }}</td>
                <td class="text-xs-left">{{ props.item.region }}</td>
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
                >
                    <h2>{{ trans.delete }} {{ selectedDealership.full_name }}</h2>
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

    export default {
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
                themeOption: 'getThemeOption'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    const paginateOption = {
                        ...this.pagination,
                        trans: this.trans,
                        paginate: true
                    }
                    this.initialize(paginateOption)
                }
            },

            searchDealerships(value) {
                const paginateOption = {
                    ...this.pagination,
                    page: 1, // Setup first page,
                    trans: this.trans,
                    paginate: true,
                    search: value
                }

                this.initialize(paginateOption)
            }
        },

        created() {
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchDealerships
                }

                this.$store.dispatch('fetchDealerships', paginateOption)
            },

            editDealerships(Dealerships){
                this.$router.push({name: 'editCountries', params:{id: Dealerships.id}})
            },

            deleteDealerships(Dealerships){
                this.$store.commit('setSelectedDealerships', Dealerships)
                this.deleteDialog = true
            },

            confirmDeleteDealerships(){
                const selectedDealerships = this.selectedDealerships
                const URL = `api/countries/${selectedDealerships.id}/delete`

                axios.delete(URL).then((response)=>{
                    if(response.data.success){
                        this.initialize()
                        // reset selectedDealerships in store
                        this.$store.commit('setSelectedDealerships', {})
                        this.dialog = false
                    }
                });
            }
        }
    }
</script>
