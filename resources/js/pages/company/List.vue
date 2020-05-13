<template>
    <div>
        <div class="r-tab" :class="[showForm ? 'open' : '']" >
            <v-btn outline round
                    @click="onGoBack()"
                    :color="themeOption.adminNavIconColor"
                    class="ma-0 ml-4 btn-absolute"  style="position: absolute; right: 0;" >
                <v-icon left dark>reply</v-icon>
                {{ `${trans.back}` }}
            </v-btn>
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">business
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.addNewCompany}` }}
                </div>
            </div>

            <div class="r-tab-content" :class="[showForm ? 'open' : '']" >
            <v-form
                row wrap
                ref="companyForm"
                v-model="valid"
                lazy-validation>
                <v-layout>
                    <v-flex xs12 sm4 mr-3>
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
                    </v-flex>
                </v-layout>
                <v-layout row wrap>
                    <v-flex xs12 sm4 mr-3>
                        <v-text-field
                            :label="trans.name"
                            v-model="selectedCompany.name"
                            :color="themeOption.inputColor"
                            :rules="[v => !!v || `${trans.nameIsRequired}`]"
                            box solo flat
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm-4 ml-3>
                        <span>{{trans.logo}}</span>

                        <v-img
                            :src="companyImage"
                            width="200"
                        ></v-img>

                        <FileUpload :preview="false"
                                    :multiple="false"
                                    model="'groups'">
                        </FileUpload>
                    </v-flex>
                </v-layout>
                <v-layout row>
                    <v-flex xs12 class="pa-2">
                        <v-btn class="rounded-btn create-edit"
                            small
                            dark
                            :color="themeOption.buttonDangerColor"
                            @click="onCreateCompany">
                            {{ editCompany ? `${trans.updateCompany}` : `${trans.createCompany}` }}
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-form>   
            </div>
        </div>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="companies"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.noGroupsFound}`"
                    :no-data-text="`${trans.noGroupsFound}`"
                    :rows-per-page-text="trans.rowsPerPage === null ? 'Row per page' : trans.rowsPerPage"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalCompanies"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td width="10%">
                            <v-img
                                contain
                                width="50px"
                                :src="props.item.logo">
                            </v-img>
                        </td>
                        <td>{{ props.item.name }}</td>
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
                        {{ trans.deleteConfirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        :color="themeOption.buttonSecondaryColor"
                        dark
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        :color="themeOption.buttonDangerColor"
                        dark
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
                valid: true,
                totalDesserts: 0,
                desserts: [],
                pagination: {},
                searchDealerships: '',
                dialog: false,
                deleteDialog: false,
                searchCompany:'',
                editCompany: false,
                showForm: false,
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

            this.$store.commit( 'setHeaderTitle', `${this.trans.manageCompanies}` )
            this.$store.commit( 'setNavTitle', `${this.trans.manageCompanies}` )
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
                this.showForm = true
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
                                message: `${selectedCompany.name}  ${this.trans.successfullyDeleted}`
                            })

                            this.initialize()
                            this.onResetCompany()
                            this.deleteDialog = false
                        }
                    });
            },

            onCreateCompany() {

                if (this.$refs.companyForm.validate()) {
                    //disable create/edit button to prevent duplicate entries
                    const button = document.getElementsByClassName("create-edit")[0].setAttribute("disabled", true);


                    // Check update or create
                    let URL = '/api/companies'
                    let companyForm = new FormData()
                    companyForm.append('name', this.selectedCompany.name)
                    companyForm.append('logo', this.companyImage)
                    companyForm.append('status', 1)

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
                                    message: `${this.selectedCompany.name}  ${this.trans.successfullyUpdated}`
                                })
                                this.showForm = false;
                            }else{
                                this.$store.commit('setSnackbarMessage', {
                                    openMessage: true,
                                    timeOut: this.themeOption.snackBarTimeout,
                                    message: `${this.selectedCompany.name}  ${this.trans.successfullyCreated}`
                                })
                                this.onResetCompany()
                                this.showForm = false;
                            }
                        }
                    
                    })

                    
                    // enable create/edit button
                    button = document.getElementsByClassName("create-edit")[0].setAttribute("disabled", false);
                }

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

            toggleForm() {
                this.showForm = !this.showForm
            }, 

            onGoBack(){
                this.$router.push({name: 'dashboard'})
            }
        }
    }
</script>
