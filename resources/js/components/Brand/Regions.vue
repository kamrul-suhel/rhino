<template>
    <v-layout row wrap pt-3>
        <v-flex xs12 sm9>
            <div class="r-tab" :class="[showForm ? 'open' : '']">
                <div class="r-tab-title r-border-round" @click="toggleForm">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">tag
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.createRegion}` }}
                    </div>
                </div>

                <div class="r-tab-content" :class="[showForm ? 'open' : '']">
                    <v-flex>
                        <v-form ref="createRegion"
                            v-model="valid"
                            lazy-validation
                        >
                            <v-layout row wrap>
                                <v-flex xs12 sm3 px-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.regionIsRequired}`]"
                                        :label="`${trans.regionName}`"
                                        v-model="selectedRegion.name"
                                        :color="themeOption.inputColor"
                                        box solo flat>
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm3 px-2>
                                    <v-autocomplete
                                        :rules="[v => !!v || `${trans.selectCountry}`]"
                                        :items="countries"
                                        item-text="name"
                                        item-value="id"
                                        :color="themeOption.inputColor"
                                        v-model="selectedRegion.country_id"
                                        :label="trans.country"
                                        box solo flat>
                                    </v-autocomplete>
                                </v-flex>
                            </v-layout>
                            <v-layout>
                                <v-flex>
                                    <v-btn small
                                        dark
                                        class="rounded-btn"
                                        @click="onCreateRegion()"
                                        :color="themeOption.buttonDangerColor">
                                        {{ editRegion ? `${trans.update}` : `${trans.add}` }}
                                    </v-btn>
                                </v-flex>
                            </v-layout>
                        </v-form>
                    </v-flex>
                </div>
            </div>
        </v-flex>
        <v-flex xs12 sm9>
            <v-data-table
                flat
                :headers="headers"
                :items="regions"
                disable-initial-sort
                :pagination.sync="pagination"
                :no-results-text="`${trans.noRegionsFound}`"
                :no-data-text="`${trans.noRegionsFound}`"
                :rows-per-page-text="trans.rowsPerPage"
                :rows-per-page-items="rowsPerPage"
                :total-items="totalRegions"
                :loading="loading"
                class="elevation-0 r-table"
            >
                <template v-slot:items="props">
                    <td>{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ props.item.country }}</td>
                    <td class="text-xs-right">
                        <v-icon
                            small
                            class="mr-2"
                            @click="onEditRegion(props.item)"
                        >
                            edit
                        </v-icon>

                        <v-icon
                            :color="themeOption.buttonDangerColor"
                            small
                            @click="onDeleteRegion(props.item)"
                        >
                            delete
                        </v-icon>
                    </td>
                </template>
            </v-data-table>
        </v-flex>

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
                    <h3>{{ trans.delete }} {{selectedRegion.name }}</h3>
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
                        @click="onCancelDeleteRegion()"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        :color="themeOption.buttonDangerColor"
                        small
                        @click="onConfirmDeleteRegion"
                    >
                        {{ trans.delete }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        props:{
            model: {
                type: String,
                required: true
            }
        },

        data() {
            return {
                valid: true,
                pagination: {},
                editRegion: false,
                deleteDialog: false,
                showForm: false,
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                headers: 'getBrandRegionListHeader',
                countries: 'getCountries',
                selectedRegion: 'getSelectedBrandRegion',
                selectedBrand: 'getSelectedBrand',
                regions: 'getRegionByBrandId',
                rowsPerPage: 'getBrandListRowsPerPage',
                totalRegions: 'getTotalRegionByBrandId',
                loading: 'getBrandLoading'
            }),
        }),

        created() {
        },

        watch: {
            pagination: {
                handler() {
                    this.fetchRegions()
                }
            },
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
            },

            fetchRegions() {
                this.$store.dispatch('fetchRegionByBranId', {
                    ...this.pagination,
                    trans: this.trans,
                    paginate: 'true',
                    themeOption: this.themeOption,
                    id: this.$route.params.id,
                    model:this.model
                })
            },

            onCreateRegion() {
                if (this.$refs.createRegion.validate()) {
                    let regionForm = new FormData()
                    regionForm.append('brand_id', this.selectedBrand.id)
                    regionForm.append('country_id', this.selectedRegion.country_id)
                    regionForm.append('name', this.selectedRegion.name)

                    let URL = `/api/regions`
                    if(this.editRegion){
                        URL += `/${this.selectedRegion.id}`
                        regionForm.append('_method', 'PUT')
                    }
                    axios.post(URL, regionForm).then((response) => {
                        if (response.data.success) {
                            this.$store.dispatch('fetchRegionByBranId', {
                                ...this.pagination,
                                trans: this.trans,
                                paginate: 'true',
                                themeOption: this.themeOption,
                                id: this.$route.params.id
                            })
                            const message = this.editRegion ? `${this.selectedRegion.name}  ${this.trans.successfullyCreated}` : `${this.selectedRegion.name}  ${this.trans.successfullyUpdated}`

                            this.onResetRegionForm()

                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                bgColor: this.themeOption.snackBarBgSuccess,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: message
                            })
                        }
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
                    })
                }
            },

            onEditRegion(region) {
                this.editRegion = true
                this.$store.commit('setSelectedBrandRegion', region)
            },

            onDeleteRegion(region) {
                this.deleteDialog = true
                this.$store.commit('setSelectedBrandRegion', region)

            },

            onConfirmDeleteRegion() {
                const regionId = this.selectedRegion.id
                const URL = `/api/regions/${regionId}`

                axios.delete(URL, {id: regionId}).then((response) => {
                    if(response.data.success){
                        this.deleteDialog = false

                        this.fetchRegions()

                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            bgColor: this.themeOption.snackBarBgDanger,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.selectedRegion.name}  ${this.trans.successfullyDeleted}`
                        })
                    }
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            onResetRegion() {
                this.$store.commit('setSelectedBrandRegion', {})
                this.onResetRegionForm()
            },

            onCancelDeleteRegion(){
              this.deleteDialog = false
                this.onResetRegionForm()
              this.$store.commit('setSelectedBrandRegion', {})
            },

            onResetRegionForm() {
                this.editRegion = false
                this.$refs.createRegion.reset()
            },

            toggleForm() {
                this.showForm = !this.showForm
            }
        }
    }
</script>
