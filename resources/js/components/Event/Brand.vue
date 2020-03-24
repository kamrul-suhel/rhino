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
                            :no-results-text="`${trans.noBrandsFound}`"
                            :no-data-text="`${trans.noBrandsFound}`"
                            :rows-per-page-text="trans.rowsPerPage"
                            :rows-per-page-items="rowsPerPage"
                            :total-items="totalBrands"
                            :loading="loading"
                            class="elevation-0 r-table"
                        >
                            <template v-slot:items="props">
                                <td>{{ props.item.name }}</td>
                                <td>{{ props.item.company }}</td>
                                <td class="text-xs-left">
                                    <v-avatar
                                        :tile="true"
                                        :size="24"
                                        :color="themeOption.inputColor"
                                    >
                                        <img :src="props.item.logo | image(themeOption.brandDefaultImage)" :alt="props.item.name">
                                    </v-avatar>
                                </td>

                                <td class="text-xs-right">
                                    <v-icon
                                        :color="themeOption.buttonDangerColor"
                                        small
                                        @click="onDeleteBrand(props.item.id)"
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
                <AddBrand></AddBrand>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import AddBrand from './AddBrand'
    import {mapGetters} from "vuex";

    export default {
        components:{
            AddBrand
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getEventBrands',
                headers: 'getEventBrandListHeader',
                totalBrands: 'getTotalEvents',
                loading: 'getEventLoading',
                rowsPerPage: 'getEventListRowsPerPage',
                initializeBrands : 'getInitializeBrands',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        data(){
            return{
                pagination: {},
            }
        },

        props: {
            eventId:{
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
                    eventId: this.$route.params.id
                }


                this.$store.dispatch('fetchBrandsByEventId', paginateOption)
            },

            onDeleteBrand(brandId){
                const URL = `/api/events/${this.selectedEvent.id}/brands/${brandId}`
                let brandEventFrom = new FormData()
                brandEventFrom.append(`brand_id`, brandId)
                brandEventFrom.append(`_method`, 'DELETE')
                brandEventFrom.append('event_id', this.selectedEvent.id)
                axios.delete(URL, brandEventFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setInitializeBrands')
                    }
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            }
        }
    };
</script>
