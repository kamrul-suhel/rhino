<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.brands }}</span>
            </v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :color="themeOption.inputColor"
                :label="trans.search_by_name"
                v-model="searchBrands">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 sm8 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="brands"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_brand_found"
                    :no-data-text="trans.no_brand_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalBrands"
                    :loading="loading"
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                class="mr-2"
                                @click="onEditBrand(props.item)"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                small
                                @click="onDeleteCompany(props.item)"
                            >
                                delete
                            </v-icon>
                        </td>
                    </template>
                </v-data-table>
            </v-flex>

            <v-flex xs12 sm4 pt-3 pl-3>
                <v-card>
                    <v-card-title>
                        <h3>{{ editBrand ? trans.edit_brand : trans.create_brand}}</h3>
                    </v-card-title>
                    <v-divider></v-divider>

                    <v-card-text>
                        <v-autocomplete
                            v-if="this.editBrand"
                            :label="trans.languages"
                            v-model="selectedBrand.language_id"
                            item-text="name"
                            item-value="id"
                            @change="onLanguageChange"
                            :color="themeOption.inputColor"
                            :items="languages">
                        </v-autocomplete>

                        <v-text-field
                            :label="trans.name"
                            v-model="selectedBrand.name"
                            :color="themeOption.inputColor"
                        ></v-text-field>

                        <v-flex xs12>
                            <span>{{trans.logo}}</span>

                            <v-img
                                :src="brandImage"
                                aspect-ratio="2.75"
                            ></v-img>

                            <FileUpload :preview="false"
                                        :multiple="false"
                                        model="'groups'">
                            </FileUpload>
                        </v-flex>
                    </v-card-text>

                    <v-card-actions class="pa-2">
                        <v-spacer></v-spacer>
                        <v-btn
                            small
                            :color="themeOption.buttonPrimaryColor"
                            @click="onResetCompany">
                            {{trans.cancel}}
                        </v-btn>

                        <v-btn
                            small
                            :color="themeOption.buttonSecondaryColor"
                            @click="onCreateBrand">
                            {{ editBrand ? trans.edit : trans.create }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
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
                        color="info"
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
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
    import FileUpload from '../../components/ImageUpload'

    export default {
        components: {
            FileUpload
        },

        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                searchBrands:'',
                editBrand: false
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
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

            searchCompany() {
                this.initialize()
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
                    search: this.searchCompany
                }

                this.$store.dispatch('fetchBrands', paginateOption)
            },

            onEditBrand(company) {
                this.editBrand = true
                // Check if group has logo, then set image
                if(company.logo){
                    this.$store.commit('setImage', company.logo)
                }
                this.$store.commit('setSelectedBrand', company)
            },

            onDeleteBrand(company){
                this.deleteDialog = true
                this.$store.commit('setSelectedBrand', company)
            },

            onConfirmDeleteBrand() {
                const selectedBrand = this.selectedBrand
                const URL = `/api/companies/${selectedBrand.id}/delete`

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
                            this.onResetCompany()
                            this.deleteDialog = false
                        }
                    });
            },
            onCreateBrand() {
                // Check update or create
                let URL = '/api/companies'
                let companyForm = new FormData()
                companyForm.append('name', this.selectedBrand.name)
                companyForm.append('logo', this.brandImage)

                if(this.editBrand){
                    const ID = this.selectedBrand.id
                    // Update the data
                    URL = `${URL}/${ID}/update`
                    companyForm.append('languageId', this.selectedBrand.language_id)
                    companyForm.append('_method', 'put')
                }else{
                    // Create new company
                }

                axios.post(URL, companyForm).then((response) =>{
                    if(response.data.success){
                        this.initialize()
                        if(this.editBrand){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedBrand.name}  ${this.trans.successfully_updated}`
                            })
                        }else{
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedBrand.name}  ${this.trans.successfully_created}`
                            })
                            this.onResetCompany()
                        }
                    }
                })

            },

            onLanguageChange(selectedLanguage){
                this.$store.dispatch('fetchCompany', {
                    id: this.selectedBrand.id,
                    languageId: selectedLanguage
                })
            },

            onResetCompany() {
                this.editBrand = false
                this.$store.commit('setSelectedBrand', {})
                this.$store.commit('resetImageUpload')
            },
        }
    }
</script>
