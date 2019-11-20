<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>{{ trans.countries }}</v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :label="trans.search_country_by_name"
                v-model="searchCountry">
            </v-text-field>
        </v-toolbar>

        <v-data-table
            :headers="headers"
            :items="countries"
            :pagination.sync="pagination"
            :no-results-text="trans.no_country_found"
            :no-data-text="trans.no_country_found"
            :rows-per-page-text="trans.rows_per_page"
            :rows-per-page-items="rowsPerPage"
            :total-items="totalCountry"
            :loading="loading"
            class="elevation-1"
        >
            <template v-slot:items="props">
                <td>{{ props.item.full_name }}</td>
                <td class="text-xs-left">{{ props.item.capital }}</td>
                <td class="text-xs-left">{{ props.item.iso_3166_2 }}</td>
                <td class="text-xs-left">{{ props.item.driver_seating_position }}</td>
                <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                <td class="text-xs-right">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editCountry(props.item)"
                    >
                        edit
                    </v-icon>

                    <v-icon
                        small
                        @click="deleteCountry(props.item)"
                    >
                        delete
                    </v-icon>
                </td>
            </template>
        </v-data-table>


        <v-dialog
            v-model="dialog"
            width="500"
        >
            <v-card>
                <v-card-title
                    primary-title
                >
                    {{ trans.edit }} {{ selectedCountry.full_name }}
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text>
                    <v-flex xs12>
                        <v-text-field
                            :label="trans.name"
                            v-model="selectedCountry.full_name"
                            ></v-text-field>
                    </v-flex>

                    <v-flex xs12>
                        <v-text-field
                            :label="trans.capital"
                            v-model="selectedCountry.capital"
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12>
                        <v-text-field
                            :label="trans.code"
                            v-model="selectedCountry.iso_3166_2"
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12>
                        <v-switch
                            v-model="selectedCountry.status"
                            :label="trans.status"
                        ></v-switch>
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        @click="updateCountry()"
                    >
                        {{ trans.update }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="deleteDialog"
            persistent
            max-width="290"
        >
            <v-card>
                <v-card-title
                    primary-title
                >
                    {{ trans.delete }} {{ selectedCountry.full_name }}
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
                        @click="confirmDeleteCountry()"
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
                searchCountry: '',
                dialog: false,
                deleteDialog: false
            }
        },

        computed: ({
            ...mapGetters({
                countries: 'getCountries',
                trans: 'getFields',
                headers: 'getCountriesListHeader',
                totalCountry: 'getTotalCountry',
                loading: 'getCountryLoading',
                rowsPerPage: 'getCountryListRowsPerPage',
                selectedCountry: 'getSelectedCountry'
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

            searchCountry(value) {
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
                    paginate: true,
                    search: this.searchCountry
                }

                this.$store.dispatch('fetchCountries', paginateOption)
            },

            editCountry(country){
                this.$store.commit('setSelectedCountry', country)
                this.dialog = true
            },

            updateCountry(){
                const selectedCountry = this.selectedCountry
                const ID = selectedCountry.id
                const URL = `/api/countries/${ID}/update`
                axios.post(URL, selectedCountry).then((response)=>{
                  if(response.data.success){

                      this.initialize()
                      // reset selectedCountry in store
                      this.$store.commit('setSelectedCountry', {})
                      this.dialog = false
                  }

                })
            },

            deleteCountry(country){
                this.$store.commit('setSelectedCountry', country)
                this.deleteDialog = true
            },

            confirmDeleteCountry(){
                const selectedCountry = this.selectedCountry
                const URL = `api/countries/${selectedCountry.id}/delete`

                axios.delete(URL).then((response)=>{
                    if(response.data.success){
                        this.initialize()
                        // reset selectedCountry in store
                        this.$store.commit('setSelectedCountry', {})
                        this.dialog = false
                    }
                });
            }
        }
    }
</script>