<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.types }}</span>
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
                v-model="searchType">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 sm8 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="types"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_type_found"
                    :no-data-text="trans.no_type_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalType"
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

            <v-flex xs12 sm4 pt-3 pl-3>
                <v-form ref="eventTypeForm"
                        v-model="valid"
                        lazy-validation>
                    <v-card>
                        <v-card-title>
                            <h3>{{ editType ? `${trans.edit} ${trans.type} ` : `${trans.create} ${trans.type}`}}</h3>
                        </v-card-title>
                        <v-divider></v-divider>

                        <v-card-text>
                            <v-flex xs12>
                                <Language v-if="editType"
                                          :languageId="selectedType.language_id">
                                </Language>
                            </v-flex>

                            <v-flex xs12>
                                <v-text-field
                                    :label="trans.name"
                                    :rules="[v => !!v || `${trans.name} ${trans.is_required}`]"
                                    required
                                    v-model="selectedType.name"
                                    :color="themeOption.inputColor">
                                </v-text-field>
                            </v-flex>

                            <v-flex xs12>
                                <span>{{trans.logo}}</span>

                                <v-img
                                    :src="typeImage"
                                    aspect-ratio="2.75"
                                ></v-img>

                                <FileUpload :preview="false"
                                            :multiple="false"
                                            model="types">
                                </FileUpload>
                            </v-flex>

                            <v-flex xs12>
                                <v-switch
                                    :label="trans.status"
                                    :color="themeOption.inputColor"
                                    v-model="selectedType.status">
                                </v-switch>
                            </v-flex>
                        </v-card-text>

                        <v-card-actions class="pa-2">
                            <v-spacer></v-spacer>
                            <v-btn
                                small
                                :color="themeOption.buttonPrimaryColor"
                                @click="onResetType">
                                {{trans.cancel}}
                            </v-btn>

                            <v-btn
                                small
                                :color="themeOption.buttonSecondaryColor"
                                @click="onCreateType">
                                {{ editType ? `${trans.update} ${trans.type}` : `${trans.add} ${trans.type}`}}
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
                    <h3>{{ trans.delete }} {{ selectedType.name }}</h3>
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
                valid: true
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

            selectedType(){
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
                                message: `${selectedType.name}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.onResetType()

                            this.deleteDialog = false
                        }
                    });
            },

            onCreateType() {
                if (this.$refs.eventTypeForm.validate()) {
                    let typeForm = new FormData()
                    typeForm.append('name', this.selectedType.name)
                    typeForm.append('logo', this.typeImage)

                    // Set status value
                    if (this.selectedType.status === true) {
                        typeForm.append('status', 1)
                    } else {
                        typeForm.append('status', 0)
                    }

                    let URL = `/api/events/types`

                    // Check if update or no
                    if (this.editType) {
                        URL += `/${this.selectedType.id}`
                        typeForm.append('_method', 'put')
                        typeForm.append('languageId', this.selectedType.language_id)
                    }

                    axios.post(URL, typeForm).then((response) => {
                        this.initialize()
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.selectedType.name}  ${this.editType ? this.trans.successfully_updated : trans.successfully_created}`
                        })

                        this.onResetType()
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

            resetEventTypeForm(){
                this.$refs.eventTypeForm.reset()
            },

            onCancelType() {

            }
        }
    }
</script>
