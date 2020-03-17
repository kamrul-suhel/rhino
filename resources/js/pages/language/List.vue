<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <div class="r-tab" :class="[showForm ? 'open' : '']">
                    <div class="r-tab-title r-border-round" @click="toggleForm">
                        <div>
                            <v-icon
                                :color="themeOption.adminNavIconColor">flag
                            </v-icon>
                        </div>

                        <div>
                            {{ `${trans.addLanguage}` }}
                        </div>
                    </div>
                    <div class="r-tab-content"  :class="[showForm ? 'open' : '']">
                        <v-layout row wrap justify-space-between pt-3 pl-3>
                            <v-form
                                ref="createLanguage"
                                v-model="valid"
                                lazy-validation>
                                <v-layout row wrap justify-space-between>
                                    <v-flex xs12 sm3>
                                        <v-text-field :label="trans.name"
                                            :rules="[v => !!v || `${trans.nameIsRequired}`]"
                                            :color="themeOption.inputColor"
                                            v-model="selectedLanguage.name"
                                            box flat solo
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3>
                                        <v-text-field :label="`${trans.code} 2`"
                                            :color="themeOption.inputColor"
                                            :rules="[v => !!v || `${trans.code2IsRequired}`]"
                                            v-model="selectedLanguage.code2"
                                            box flat solo
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3>
                                        <v-text-field :label="`${trans.code} 3`"
                                                        :rules="[v => !!v || `${trans.code3IsRequired}`]"
                                                        :color="themeOption.inputColor"
                                                        v-model="selectedLanguage.code3"
                                                        box flat solo
                                        ></v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm1>
                                        <v-switch
                                            :label="trans.status"
                                            :color="themeOption.switchOnColor"
                                            :true-value="1"
                                            :false-value="0"
                                            v-model="selectedLanguage.status"
                                            box flat solo>
                                        </v-switch>
                                    </v-flex>
                                </v-layout>

                                <v-layout class="pa-2">
                                    <v-flex xs5>
                                        <v-btn small
                                                dark
                                                class="rounded-btn"
                                                :color="themeOption.buttonDangerColor"
                                                @click="onCreateLanguage">
                                            {{ editLanguage ? trans.update : trans.create }}
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-form>
                        </v-layout>
                    </div>
                </div>
            </v-flex>
        </v-layout>
        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="languages"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.noLanguageFound}`"
                    :no-data-text="`${trans.noLanguageFound}`"
                    :rows-per-page-text="trans.rowsPerPage === null ? 'Row per page' : trans.rowsPerPage"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalLanguages"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <tr>
                            <td>{{ props.item.name }}</td>
                            <td>{{ props.item.code2 }}</td>
                            <td>{{ props.item.code3 }}</td>
                            <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                            <td class="text-xs-right">
                                <v-icon
                                    small
                                    :class="{'mr-2': props.item.id !== 1}"
                                    @click="onEditLanguage(props.item)"
                                >
                                    edit
                                </v-icon>

                                <v-icon
                                    v-if="props.item.id !== 1"
                                    :color="themeOption.buttonDangerColor"
                                    small
                                    @click.stop="onDeleteLanguage(props.item)"
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
                    <h3>{{ trans.delete }} {{selectedLanguage.name }}</h3>
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text>
                    <v-flex xs12>
                        {{ trans.deleteConfirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-btn
                        :color="themeOption.buttonDangerColor"
                        small
                        @click="onConfirmDeleteLanguage"
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
                deleteLanguage:{},
                searchLanguages: '',
                editLanguage: false,
                color: '',
                isColorSwatchActive: false,
                selectedColor: '',
                valid: true,
                selectedLanguage:{
                    status: 1
                },
                showForm: false
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguageCRUD',
                trans: 'getFields',
                companies: 'getCompanies',
                themeOption: 'getThemeOption',
                headers: 'getLanguagesListHeader',
                totalLanguages: 'getTotalLanguage',
                loading: 'getLanguageLoading',
                rowsPerPage: 'getLanguageListRowsPerPage',
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            searchLanguages() {
                this.initialize()
            },

            selectedColor(value) {
                this.color = value.hex
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.manageLanguages}`)
            this.$store.commit('setNavTitle', `${this.trans.manageLanguages}`)
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {
                this.$refs.createLanguage.resetValidation()

                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchLanguages
                }

                this.$store.dispatch('fetchLanguagesForCRUD', paginateOption)
            },

            onEditLanguage(language) {
                this.editLanguage = true
                this.selectedLanguage = {...language}
                this.showForm = true
            },

            onDeleteLanguage(language) {
                this.deleteDialog = true
                this.deleteLanguage = {...language}
            },

            onDeleteCancel(){
                this.deleteDialog = false
                this.deleteLanguage = {}
            },

            onConfirmDeleteLanguage() {
                const selectedLanguage = this.deleteLanguage
                const URL = `/api/languages/${selectedLanguage.id}`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedLanguage.name}  ${this.trans.successfullyDeleted}`
                            })

                            this.initialize()
                            this.deleteDialog = false
                        }
                    });
            },

            onCreateLanguage() {
                if (this.$refs.createLanguage.validate()) {
                    // Check update or create
                    let URL = '/api/languages'
                    let languageForm = new FormData()
                    languageForm.append('name', this.selectedLanguage.name)
                    languageForm.append('code2', this.selectedLanguage.code2)
                    languageForm.append('code3', this.selectedLanguage.code3)
                    languageForm.append('status', this.selectedLanguage.status)

                    if(this.editLanguage){
                        languageForm.append('_method', 'PUT')
                        URL += `/${this.selectedLanguage.id}`
                    }

                    axios.post(URL, languageForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedLanguage.name}  ${this.editLanguage ? `${this.trans.successfullyUpdated}` : `${this.trans.successfullyCreated}`}`
                            })

                            this.initialize()

                            this.onResetLanguage()

                            this.showForm = false
                        }
                    })
                }
            },

            onResetLanguage() {
                this.$refs.createLanguage.reset()
                this.editLanguage = false
                const language = {}
                this.selectedLanguage = {...language}
            },

            toggleForm() {
                this.showForm = !this.showForm
            }
        }
    }
</script>
