<template>
    <div>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">grade
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.addEventType}` }}
                </div>
            </div>

            <div class="r-tab-content" :class="[showForm ? 'open' : '']">
                <v-form ref="eventTypeForm"
                        v-model="valid"
                        lazy-validation>

                    <!-- Language Selector for translations -->
                    <v-layout row wrap justify-end>
                        <v-flex xs12 sm3 v-if="editType">
                            <Language :solo="false"
                                      :flat="false"
                                      :chip="false"
                                      :languageId="selectedType.language_id">
                            </Language>
                        </v-flex>
                    </v-layout>


                    <v-layout row wrap>
                        <v-flex xs12 sm1 ml-3>
                            <span>{{trans.icon}}</span>

                            <v-img
                                :src="typeImage"
                                width="50px"
                            ></v-img>

                            <FileUpload :preview="false"
                                        :multiple="false"
                                        model="types">
                            </FileUpload>
                        </v-flex>

                        <v-flex xs12 sm3 mr-3>
                            <v-text-field
                                :label="trans.name"
                                :rules="[v => !!v || `${trans.nameIsRequired}`]"
                                required
                                v-model="selectedType.name"
                                :color="themeOption.inputColor"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 mr-3>
                            <v-text-field
                                :label="trans.displayName"
                                v-model="selectedType.display_name"
                                :color="themeOption.inputColor"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 mr-3>
                            <v-textarea
                                :label="trans.description"
                                v-model="selectedType.description"
                                :color="themeOption.inputColor"
                                box solo flat>
                            </v-textarea>
                        </v-flex>
                    </v-layout>

                    <v-layout row justify-center class="py-4 text-center">
                        <v-flex xs12 sm-4 class="text-center">
                            <v-btn
                                small
                                dark
                                class="rounded-btn"
                                :color="themeOption.buttonDangerColor"
                                @click="onCreateType">
                                {{ editType ? `${trans.updateType}` : `${trans.addType}`}}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-form>
            </div>
        </div>

        <v-layout row>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="types"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.noTypeFound"
                    :no-data-text="trans.noTypeFound"
                    :rows-per-page-text="trans.rowsPerPage"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalType"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td width="7%">
                            <v-img
                                contain
                                width="50px"
                                :src="props.item.image">
                            </v-img>
                        </td>
                        <td>{{ props.item.display_name }}</td>
                        <td>{{ props.item.name }}</td>
                        <td>{{ props.item.description }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                class="mr-2"
                                @click="onEditType(props.item)"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                small
                                :color="themeOption.buttonDangerColor"
                                @click="onDeleteType(props.item)"
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
                    <h3>{{ trans.delete }} {{ selectedType.name }}</h3>
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
                        @click="onCancelDeleteDialog()"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="confirmDeleteDealerships()"
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
    import FileUpload from '../../../components/ImageUpload'
    import Language from "../../../components/Language";

    export default {
        components: {
            FileUpload,
            Language
        },

        data() {
            return {
                totalDesserts: 0,
                desserts: [],
                pagination: {},
                searchType: '',
                dialog: false,
                deleteDialog: false,
                editType: false,
                valid: true,
                showForm: false,
                type: {
                    status: 1
                },
            }
        },

        computed: ({
            ...mapGetters({
                types: 'getTypes',
                trans: 'getFields',
                headers: 'getTypeListHeader',
                totalType: 'getTotalType',
                loading: 'getTypeLoading',
                rowsPerPage: 'getTypeListRowsPerPage',
                selectedType: 'getSelectedType',
                themeOption: 'getThemeOption',
                typeImage: 'getUploadedImage',
                selectedLanguage: 'getSubSelectedLanguage'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            selectedType() {
                this.resetValidationEventTypeForm()
            },

            searchType(value) {
                this.initialize()
            },

            // When language is change it will trigger
            selectedLanguage(value) {
                this.$store.dispatch('fetchType', {
                    id: this.selectedType.id,
                    languageId: value.id,
                    edit: true
                })
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.manageEventType}`)
            this.$store.commit('setNavTitle', `${this.trans.events}`)
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
                    search: this.searchType
                }

                this.$store.dispatch('fetchTypes', paginateOption)
            },

            onEditType(type) {
                if (type.image) {
                    this.$store.commit('setImage', type.image)
                }
                // Check if type has logo, then set image
                this.$store.commit('setSelectedType', type)
                this.editType = true
                this.showForm = true
            },

            onDeleteType(Type) {
                this.$store.commit('setSelectedType', Type)
                this.deleteDialog = true
            },

            onCancelDeleteDialog() {
                this.deleteDialog = false
                this.onResetType()
            },

            confirmDeleteDealerships() {
                const selectedType = this.selectedType
                const URL = `/api/events/types/${selectedType.id}`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedType.name}  ${this.trans.successfullyDeleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.onResetType()

                            this.deleteDialog = false
                        }
                    }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            onCreateType() {
                if (this.$refs.eventTypeForm.validate()) {
                    let typeForm = new FormData()
                    typeForm.append('name', this.selectedType.name)
                    typeForm.append('display_name', this.selectedType.display_name)
                    typeForm.append('description', this.selectedType.description)
                    typeForm.append('logo', this.typeImage)

                    let URL = `/api/events/types`

                    // Check if update or no
                    if (this.editType) {
                        URL += `/${this.selectedType.id}`
                        typeForm.append('_method', 'put')
                        typeForm.append('languageId', this.selectedType.language_id)
                    }

                    axios.post(URL, typeForm).then((response) => {
                        this.initialize()
                        const message = this.editType ? `${this.trans.successfullyUpdated}` : `${this.trans.successfullyCreated}`
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: message
                        })

                        this.onResetType()
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
                    })
                }

            },

            onResetType() {
                this.resetEventTypeForm()
                this.editType = false
                this.$store.commit('setImage', '')
                this.$store.commit('setSelectedType', {})
            },

            resetValidationEventTypeForm() {
                this.$refs.eventTypeForm.resetValidation()
            },

            resetEventTypeForm() {
                this.$refs.eventTypeForm.reset()
            },

            onCancelType() {

            },

            toggleForm() {
                this.showForm = !this.showForm
            }
        }
    }
</script>
