<template>
    <div class="dealership-brands">
        <v-layout row wrap pt-4>
            <v-flex xs12 sm8 pa-2>
                <v-card>
                    <v-card-text>
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
                            class="elevation-0"
                        >
                            <template v-slot:items="props">
                                <td>{{ props.item.brand }}</td>
                                <td>{{ props.item.country }}</td>
                                <td class="text-xs-left">{{ props.item.region }}</td>
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
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12 sm4 pa-2>
               <Create></Create>
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
                        @click="onCancelDelete"
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
    import Create from '../../components/Dealership/CreateForm'
    import {mapGetters} from "vuex"

    export default {
        components:{
            Create
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsByDealership',
                headers: 'getListHeaderForBrandDealership',
                totalBrands: 'getTotalBrandsByDealership',
                loading: 'getBrandLoading',
                rowsPerPage: 'getBrandDealershipListRowPerPage',
                initializeBrands : 'getInitializeBrands',
                selectedBrand: 'getSelectedBrandDealership'
            })
        }),

        data(){
            return{
                pagination: {},
                deleteDialog: false,
            }
        },

        props: {
            dealershipId:{
                type: Number,
                required: true
            }
        },

        watch:{
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            initializeBrands(){
                this.initialize()
            }
        },

        created(){

        },

        methods:{
            // Initialize data when first render
            initialize() {
                // this.$refs.createBrand.resetValidation()

                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    dealershipId: this.$route.params.id
                }

                this.$store.dispatch('fetchBrandsByDealershipId', paginateOption)
            },

            onEditBrand(brand){
                this.$store.commit('setSelectedBrandDealership', brand)
            },

            onDeleteBrand(brand){
                this.deleteDialog = true
                this.$store.commit('setSelectedBrandDealership', brand)
            },

            onCancelDelete(){
                this.deleteDialog = false
                this.$store.commit('setSelectedBrandDealership', {})
            },

            onConfirmDeleteBrand(){
                const brandDealershipId = this.selectedBrand.id

                const URL = `/api/brandDealerships/${brandDealershipId}`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.deleteDialog = false
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedBrand.brand}  ${this.trans.successfully_deleted}`
                            })
                            this.$store.commit('setInitializeBrands')
                        }
                    });
            }
        }
    };
</script>
