<template>
    <div>

        <CountryForm></CountryForm>

        <v-data-table
            :headers="headers"
            :items="countries"
            :pagination.sync="pagination"
            :no-results-text="`${trans.no} ${trans.country} ${trans.found}`"
            :no-data-text="`${trans.no} ${trans.country} ${trans.found}`"
            :rows-per-page-text="trans.rows_per_page"
            :rows-per-page-items="rowsPerPage"
            :total-items="totalCountry"
            :loading="loading"
            class="elevation-1 r-table"
        >
            <template v-slot:items="props">
                <td>{{ props.item.name }}</td>
                <td class="text-xs-left">{{ props.item.country_code }}</td>
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
                            :label="trans.code"
                            v-model="selectedCountry.country_code"
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

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        small
                        @click="dialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        class="success"
                        small
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
                    <h2>{{ trans.delete }} {{ selectedCountry.full_name }}</h2>
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
    import CountryForm from './Create'

    export default {

        components: {
            CountryForm
        },

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
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                updateComponent: 'getUpdateComponent'
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
            },

            updateComponent() {
                this.initialize()
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.manage} ${this.trans.countries}`)
            this.$store.commit('setNavTitle', `${this.trans.manage} ${this.trans.countries}`)
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
                    search: this.searchCountry
                }

                this.$store.dispatch('fetchCountries', paginateOption)
            },

            editCountry(country){
                this.$router.push({name: 'editCountries', params:{id: country.id}})
            },

            deleteCountry(country){
                this.$store.commit('setSelectedCountry', country)
                this.deleteDialog = true
            },

            confirmDeleteCountry(){
                const selectedCountry = this.selectedCountry
                const URL = `/api/countries/${selectedCountry.id}/delete`

                axios.delete(URL).then((response)=>{
                    if(response.data.success){
                        this.initialize()
                        // reset selectedCountry in store
                        this.$store.commit('setSelectedCountry', {})
                        this.deleteDialog = false
                    }
                });
            },

        }
    }
</script>
