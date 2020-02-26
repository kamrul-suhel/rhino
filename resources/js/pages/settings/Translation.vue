<template>
    <div>
        <v-layout row wrap >
            <v-flex xs12 sm6>
                <v-text-field
                    :color="themeOption.inputColor"
                    :label="`${trans.searchBy} ${trans.name}`"
                    v-model="searchField"
                    box solo flat>
                </v-text-field>
            </v-flex>

            <v-flex xs12 sm6>
                <v-layout row wrap justify-end align-content-end>
                    <v-flex xs12 sm8>
                        <LanguagePicker :languageId="selectedLanguage.id"
                                        :solo="false"
                                        :flat="false"
                                        :chip="false"
                                        model="translation">
                        </LanguagePicker>
                    </v-flex>
                </v-layout>

            </v-flex>
        </v-layout>

        <v-data-table
            :headers="headers"
            :items="translations"
            :pagination.sync="pagination"
            :no-results-text="`${trans.no} ${trans.country} ${trans.found}`"
            :no-data-text="`${trans.no} ${trans.translation} ${trans.found}`"
            :rows-per-page-text="trans.rows_per_page === null ? 'Row per page' : trans.rows_per_page"
            :rows-per-page-items="rowsPerPage"
            :total-items="totalTranslation"
            :loading="loading"
            class="elevation-1 r-table translations"
        >
            <template v-slot:items="props">
                <td class="text-xs-left">{{ props.item.label }}</td>
                <td class="text-xs-left">
                    <v-edit-dialog
                        :return-value.sync="props.item.name"
                        lazy
                        :color="themeOption.inputColor"
                        @save="save(props.item)"
                        @cancel="cancel"
                        @open="open"
                        @close="close"
                    > {{ props.item.translation }}
                        <template v-slot:input>
                            <v-text-field
                                :color="themeOption.buttonDangerColor"
                                v-model="props.item.translation"
                                :label="trans.edit"
                                single-line
                                counter
                            ></v-text-field>
                        </template>
                    </v-edit-dialog>
                </td>
            </template>
        </v-data-table>

        <v-snackbar v-model="snack"
                    :timeout="3000"
                    :color="snackColor">
            {{ snackText }}
            <v-btn flat @click="snack = false">Close</v-btn>
        </v-snackbar>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import LanguagePicker from '@/components/Language'

    export default {
        components:{
            LanguagePicker
        },

        data() {
            return {
                pagination: {},
                searchField: '',

                snack: false,
                snackColor: '',
                snackText: '',
            }
        },

        computed: ({
            ...mapGetters({
                translations: 'getTranslations',
                trans: 'getFields',
                headers: 'getTranslationListHeader',
                totalTranslation: 'getTotalTranslation',
                loading: 'getTranslationLoading',
                rowsPerPage: 'getTranslationListRowsPerPage',
                themeOption: 'getThemeOption',
                selectedLanguage: 'getSelectedLanguage',
                subSelectedLanguage: 'getSubSelectedLanguage'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    const paginateOption = {
                        ...this.pagination,
                        trans: this.trans,
                        themeOption: this.themeOption,
                        paginate: true
                    }
                    this.initialize(paginateOption)
                }
            },

            searchField(value) {
                const paginateOption = {
                    ...this.pagination,
                    page: 1, // Setup first page,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    languageId: this.subSelectedLanguage.id,
                    paginate: true,
                    search: value
                }

                this.initialize(paginateOption)
            },

            subSelectedLanguage(){

                const paginateOption = {
                    ...this.pagination,
                    page: 1, // Setup first page,
                    languageId: this.subSelectedLanguage.id,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchField
                }

                this.initialize(paginateOption)
            }
        },

        created() {

            this.$store.commit('setHeaderTitle', `${this.trans.manage} ${this.trans.translations}`)
            this.$store.commit('setNavTitle', `${this.trans.manage} ${this.trans.translations}`)
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize(paginateOption) {
                this.$store.dispatch('fetchTranslations', paginateOption)
            },

            save (settingTranslation) {
                const translationId = settingTranslation.setting_translation_id
                let translationForm = new FormData()
                translationForm.append('setting_translation_id', translationId)
                translationForm.append('translation', settingTranslation.translation)
                translationForm.append('_method', 'PUT')

                const URL = `/api/settings/translations/${translationId}/update`

                axios.post(URL, translationForm).then((response) => {
                    if(response.data.success){
                        this.snackColor = 'success'
                        this.snackText = `${this.trans.translation} ${this.trans.save}`
                        this.snack = true
                    }
                })
            },

            cancel () {
                this.snack = true
                this.snackColor = 'error'
                this.snackText = 'Canceled'
            },

            open () {
                this.snack = true
                this.snackColor = 'info'
                this.snackText = `${this.trans.update} ${this.trans.translation}`
            },

            close () {
            }
        }
    }
</script>

<style scoped>
    .translations .v-menu__activator{
        background: #fff
    }
</style>