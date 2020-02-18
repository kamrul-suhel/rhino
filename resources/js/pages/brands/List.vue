<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12>
                <v-form
                    ref="createBrand"
                    v-model="valid"
                    lazy-validation>

                    <v-layout row wrap>

                        <v-flex xs12>
                            <h3>{{ `${trans.add} ${trans.new} ${trans.brand}` }}</h3>
                        </v-flex>

                        <v-flex xs4>
                            <v-autocomplete
                                v-if="this.editBrand"
                                :label="trans.languages"
                                v-model="selectedBrand.language_id"
                                item-text="name"
                                item-value="id"
                                @change="onLanguageChange"
                                :color="themeOption.inputColor"
                                :items="languages"
                                box
                                solo
                                flat>
                            </v-autocomplete>

                            <v-text-field
                                :label="trans.name"
                                :rules="[v => !!v || `${trans.brand} ${trans.name} ${trans.is_required}`]"
                                required
                                v-model="selectedBrand.name"
                                class="mr-4"
                                :color="themeOption.inputColor"
                                box
                                solo
                                flat
                            ></v-text-field>
                        </v-flex>

                            <!--
                            <v-autocomplete :label="trans.company"
                                            :color="themeOption.inputColor"
                                            :items="companies"
                                            item-text="name"
                                            item-value="id"
                                            v-model="selectedBrand.company_id">
                            </v-autocomplete>
                            -->

                        <v-flex xs2>
                            <div class="r-color-picker" v-if="isColorSwatchActive">
                                <div class="r-color-picker-content">
                                    <chrome v-model="selectedColor"
                                        solo
                                        flat
                                        background-color="#eaeaea"></chrome>
                                    <v-btn small
                                            class="r-color-choose"
                                            @click="isColorSwatchActive = false"
                                            :color="themeOption.buttonPrimaryColor">
                                        {{ trans.select }}
                                    </v-btn>
                                </div>
                            </div>

                            <v-text-field
                                box
                                :label="trans.color"
                                v-model="color"
                                :rules="[v => !!v || `${trans.select_a} ${trans.color}`]"
                                required
                                @focus="isColorSwatchActive = true"
                                :color="themeOption.inputColor"
                                solo
                                flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs4 class="ml-5">
                            <span>{{trans.logo}}</span>

                            <FileUpload :preview="false"
                                        identifier="brand"
                                        model="brands"
                                        >
                            </FileUpload>
                        </v-flex>

                        <v-flex xs12>
                            <v-btn small
                                    dark
                                    :color="themeOption.buttonDangerColor"
                                    @click="onCreateBrand"
                                    class="rounded-btn">
                                {{ editBrand ? trans.edit : trans.create }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-form>
            </v-flex>
        </v-layout>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="brands"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.brand} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.brand} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page === null ? 'Row per page' : trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalBrands"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <tr @click="onEditBrand(props.item)">
                            <td width="25%">
                                <v-img
                                    v-if="props.item.logo"
                                    contain
                                    :src="props.item.logo"
                                    aspect-ratio="1"
                                    max-width="100"
                                    >
                                </v-img>
                            </td>
                            <td>{{ props.item.name }}</td>
                            <td>{{ props.item.company }}</td>
                            <td class="text-xs-right">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="onEditBrand(props.item)"
                                >
                                    edit
                                </v-icon>

                                <v-icon
                                    :color="themeOption.buttonDangerColor"
                                    small
                                    @click.stop="onDeleteBrand(props.item)"
                                >
                                    delete
                                </v-icon>
                            </td>
                        </tr>
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
                    <h3>{{ trans.delete }} {{selectedBrand.name }}</h3>
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
                        dark
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="onDeleteCancel"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        :color="themeOption.buttonDangerColor"
                        small
                        @click="onConfirmDeleteBrand"
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
                brands: 'getBrands',
                headers: 'getBrandListHeader',
                totalBrands: 'getTotalBrands',
                loading: 'getBrandLoading',
                rowsPerPage: 'getBrandListRowsPerPage',
                selectedBrand: 'getSelectedBrand',
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
            this.selectedBrand.status = 1;
            this.$store.commit('setHeaderTitle', `${this.trans.manage} ${this.trans.brands}`)
            this.$store.commit('setNavTitle', `${this.trans.manage} ${this.trans.brands}`)
        },

        mounted() {
        },
        methods: {
            fetchCompany() {
                this.$store.dispatch('fetchCompanies', {themeOption: this.themeOption, trans: this.trans});
            },

            // Initialize data when first render
            initialize() {
                this.$refs.createBrand.resetValidation()

                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchBrands
                }

                this.$store.dispatch('fetchBrands', paginateOption)
            },

            onEditBrand(brand) {
                this.$router.push({name: 'editBrand', params: {id: brand.id}})
            },

            onDeleteBrand(company) {
                this.deleteDialog = true
                this.$store.commit('setSelectedBrand', company)
            },

            onDeleteCancel(){
                this.deleteDialog = false
                this.$refs.createBrand.resetValidation()
                this.$store.commit('setSelectedBrand', {})
            },

            onConfirmDeleteBrand() {
                const selectedBrand = this.selectedBrand
                const URL = `/api/brands/${selectedBrand.id}/delete`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedBrand.name}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.deleteDialog = false
                        }
                    });
            },
            onCreateBrand() {
                if (this.$refs.createBrand.validate()) {
                    // Check update or create
                    let URL = '/api/brands'
                    let brandForm = new FormData()
                    brandForm.append('name', this.selectedBrand.name)
                    brandForm.append('logo', this.brandImage)
                    brandForm.append('colour', this.color)

                    console.log(this.selectedBrand)
                    this.selectedBrand.company_id ? brandForm.append('company_id', this.selectedBrand.company_id) : null


                    brandForm.append('status', this.selectedBrand.status)

                    axios.post(URL, brandForm).then((response) => {
                        if (response.data.success) {
                            this.initialize()
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedBrand.name}  ${this.trans.successfully_created}`
                            })

                            this.onResetBrand()
                        }
                    })
                }

            },

            onLanguageChange(selectedLanguage) {
                this.$store.dispatch('fetchCompany', {
                    id: this.selectedBrand.id,
                    languageId: selectedLanguage
                })
            },
        }
    }
</script>
