<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.companies }}</span>
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
                v-model="searchCompany">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 sm8 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="companies"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_group_found"
                    :no-data-text="trans.no_group_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalCompanies"
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
                                @click="onEditCompany(props.item)"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                :color="themeOption.buttonDangerColor"
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
                        <h3>{{ editCompany ? trans.edit_company : trans.create_company}}</h3>
                    </v-card-title>
                    <v-divider></v-divider>

                    <v-card-text>
                        <v-autocomplete
                            v-if="this.editCompany"
                            :label="trans.languages"
                            v-model="selectedCompany.language_id"
                            item-text="name"
                            item-value="id"
                            @change="onLanguageChange"
                            :color="themeOption.inputColor"
                            :items="languages">
                        </v-autocomplete>

                        <v-text-field
                            :label="trans.name"
                            v-model="selectedCompany.name"
                            :color="themeOption.inputColor"
                        ></v-text-field>

                        <v-flex xs12>
                            <span>{{trans.logo}}</span>

                            <v-img
                                :src="companyImage"
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
                            @click="onCreateCompany">
                            {{ editCompany ? trans.update_company : trans.create_company }}
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
                    <h3>{{ trans.delete }} {{selectedCompany.name }}</h3>
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
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="onConfirmDeleteCompany"
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
                totalDesserts: 0,
                desserts: [],
                pagination: {},
                searchDealerships: '',
                dialog: false,
                deleteDialog: false,
                searchCompany:'',
                editCompany: false
            }
        },

        computed: ({
            ...mapGetters({
                companies: 'getCompanies',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                headers: 'getCompanyListHeader',
                totalCompanies: 'getTotalCompanies',
                loading: 'getCompanyLoading',
                rowsPerPage: 'getCompanyListRowsPerPage',
                selectedCompany: 'getSelectedCompany',
                companyImage: 'getUploadedImage',
                languages: 'getLanguages'
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

                this.$store.dispatch('fetchCompanies', paginateOption)
            },

            onEditCompany(company) {
                this.editCompany = true
                // Check if group has logo, then set image
                if(company.logo){
                    this.$store.commit('setImage', company.logo)
                }
                this.$store.commit('setSelectedCompany', company)
            },

            onDeleteCompany(company){
                this.deleteDialog = true
                this.$store.commit('setSelectedCompany', company)
            },

            onConfirmDeleteCompany() {
                const selectedCompany = this.selectedCompany
                const URL = `/api/companies/${selectedCompany.id}/delete`

                axios.delete(URL)
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                bgColor: this.themeOption.snackBarBgDanger,
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedCompany.name}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.onResetCompany()
                            this.deleteDialog = false
                        }
                    });
            },

            onCreateCompany() {
                // Check update or create
                let URL = '/api/companies'
                let companyForm = new FormData()
                companyForm.append('name', this.selectedCompany.name)
                companyForm.append('logo', this.companyImage)

                if(this.editCompany){
                    const ID = this.selectedCompany.id
                    // Update the data
                    URL = `${URL}/${ID}/update`
                    companyForm.append('languageId', this.selectedCompany.language_id)
                    companyForm.append('_method', 'put')
                }

                axios.post(URL, companyForm).then((response) =>{
                    if(response.data.success){
                        this.initialize()
                        if(this.editCompany){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedCompany.name}  ${this.trans.successfully_updated}`
                            })
                        }else{
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedCompany.name}  ${this.trans.successfully_created}`
                            })
                            this.onResetCompany()
                        }
                    }
                })

            },

            onLanguageChange(selectedLanguage){
              this.$store.dispatch('fetchCompany', {
                  id: this.selectedCompany.id,
                  languageId: selectedLanguage
              })
            },

            onResetCompany() {
                this.editCompany = false
                this.$store.commit('setSelectedCompany', {})
                this.$store.commit('resetImageUpload')
            },
        }
    }
</script>
