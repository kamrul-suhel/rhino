<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.events }}</span>
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
            <v-flex xs12 pt-3>
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
                        <td>{{ props.item.company }}</td>
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
                                :color="themeOption.buttonDangerColor"
                                small
                                @click="onDeleteBrand(props.item)"
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
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="onDeleteCancel"
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
        },

        mounted() {
        },
        methods: {
            fetchCompany() {
                this.$store.dispatch('fetchCompanies', {themeOption: this.themeOption, trans: this.trans});
            },

            // Initialize data when first render
            initialize() {
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
                this.$router.push({name: 'editBrands', params: {id: brand.id}})
            },

            onDeleteBrand(company) {
                this.deleteDialog = true
                this.$store.commit('setSelectedBrand', company)
            },

            onDeleteCancel(){
                this.deleteDialog = false
                this.$store.commit('setSelectedBrand', {})
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
                            this.onResetBrand()
                            this.deleteDialog = false
                        }
                    });
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
