<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12>
                <v-form
                    ref="createBrand"
                    v-model="valid"
                    lazy-validation>

                    <v-layout row wrap justify-space-between>
                        <v-flex xs12>
                            <h3>{{ `${trans.addNawBrand}` }}</h3>
                        </v-flex>

                        <v-flex xs12 sm4>
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
                                :rules="[v => !!v || `${trans.brandNameIsRequired}`]"
                                required
                                v-model="selectedBrand.name"
                                :color="themeOption.inputColor"
                                box
                                solo
                                flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 px-2>
                            <v-select
                                :items="companies"
                                :rules="[v => !!v || `${trans.companyIsRequired}`]"
                                required
                                item-text="name"
                                item-value="id"
                                :color="themeOption.inputColor"
                                :label="trans.company"
                                v-model="selectedBrand.company_id"
                                solo flat box
                            >
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm4>
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
                                :rules="[v => !!v || `${trans.selectAColor}`]"
                                required
                                @focus="isColorSwatchActive = true"
                                :color="themeOption.inputColor"
                                solo
                                flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 class="ml-5">
                            <span>{{trans.logo}}</span>

                            <v-img class="my-2"
                                :src="brandImage"
                                width="200"
                            ></v-img>

                            <FileUpload :preview="false"
                                    :multiple="false"
                                    model="brands">
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
                    :no-results-text="`${trans.noBrandsFound}`"
                    :no-data-text="`${trans.noBrandsFound}`"
                    :rows-per-page-text="trans.rowsPerPage === null ? 'Row per page' : trans.rowsPerPage"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalBrands"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <tr @click="onEditBrand(props.item)">
                            <td width="25%" class="py-2">
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
                                    v-if="!subComponent"
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
                        {{ trans.deleteConfirmation }}
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

        props:{
          subComponent:{
              type: Boolean,
              required: false,
              default: false
          }
        },

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
            this.$store.commit('setHeaderTitle', `${this.trans.manageBrands}`)
            this.$store.commit('setNavTitle', `${this.trans.manageBrands}`)
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
                                message: `${selectedBrand.name}  ${this.trans.successfullyDeleted}`
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

                    this.selectedBrand.company_id ? brandForm.append('company_id', this.selectedBrand.company_id) : null

                    brandForm.append('status', this.selectedBrand.status)

                    axios.post(URL, brandForm).then((response) => {
                        if (response.data.success) {
                            this.initialize()
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedBrand.name}  ${this.trans.successfullyCreated}`
                            })
                        }
                        this.$store.commit('setSelectedBrand', {})
                        this.color = ''
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
