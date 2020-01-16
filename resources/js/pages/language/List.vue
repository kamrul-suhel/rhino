<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.languages }}</span>
            </v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :color="themeOption.inputColor"
                :label="`${trans.searchBy} ${trans.name}`"
                v-model="searchLanguages">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 sm8 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="languages"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.language} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.language} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalLanguages"
                    :loading="loading"
                    class="elevation-1"
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

            <v-flex xs12 sm4 pt-3 pl-3>
                <v-form
                    ref="createLanguage"
                    v-model="valid"
                    lazy-validation>
                    <v-card>
                        <v-card-title>
                            <h3>{{ editLanguage ? `${trans.edit} ${trans.language}` : `${trans.create} ${trans.language}` }}</h3>
                        </v-card-title>
                        <v-divider></v-divider>

                        <v-card-text>
                            <v-flex xs12>
                                <v-text-field :label="trans.name"
                                              :rules="[v => !!v || `${trans.name} ${trans.is_required}`]"
                                              :color="themeOption.inputColor"
                                              v-model="selectedLanguage.name"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <v-text-field :label="`${trans.code} 2`"
                                              :color="themeOption.inputColor"
                                              :rules="[v => !!v || `${trans.code} 2 ${trans.is_required}`]"
                                              v-model="selectedLanguage.code2"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <v-text-field :label="`${trans.code} 3`"
                                              :rules="[v => !!v || `${trans.code} 3 ${trans.is_required}`]"
                                              :color="themeOption.inputColor"
                                              v-model="selectedLanguage.code3"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <v-switch
                                    :label="trans.status"
                                    :color="themeOption.inputColor"
                                    :true-value="1"
                                    :false-value="0"
                                    v-model="selectedLanguage.status">
                                </v-switch>
                            </v-flex>
                        </v-card-text>

                        <v-card-actions class="pa-2">
                            <v-spacer></v-spacer>
                            <v-btn small
                                   :color="themeOption.buttonSecondaryColor"
                                   @click="onResetLanguage">
                                {{trans.cancel}}
                            </v-btn>

                            <v-btn small
                                   :color="themeOption.buttonPrimaryColor"
                                   @click="onCreateLanguage">
                                {{ editLanguage ? trans.update : trans.create }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
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
                        {{ trans.delete_confirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="onDeleteCancel"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
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
                }
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
                rowsPerPage: 'getLanguageListRowsPerPage'
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
                                message: `${selectedLanguage.name}  ${this.trans.successfully_deleted}`
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
                                message: `${this.selectedLanguage.name}  ${this.editLanguage ? `${this.trans.successfully_updated}` : `${this.trans.successfully_created}`}`
                            })

                            this.initialize()

                            this.onResetLanguage()
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
        }
    }
</script>
