<template>
    <v-layout row wrap>
        <v-flex xs12 pt-3>
            <v-data-table
                :headers="headers"
                :items="vehicles"
                disable-initial-sort
                :pagination.sync="pagination"
                :no-results-text="trans.no_brand_found"
                :no-data-text="trans.no_brand_found"
                :rows-per-page-text="trans.rows_per_page"
                :rows-per-page-items="rowsPerPage"
                :total-items="totalEvents"
                :loading="loading"
                class="elevation-1"
            >
                <template v-slot:items="props">
                    <td>{{ props.item.model }}</td>
                    <td>
                        <v-switch
                            class="eventVehicleSwitche"
                            :color="themeOption.inputColor"
                            :false-value="0"
                            :true-value="1"
                            v-model="props.item.new"
                        ></v-switch>
                    </td>

                    <td>
                        <v-switch
                            class="eventVehicleSwitche"
                            :color="themeOption.inputColor"
                            v-model="props.item.used"
                            return-object
                            @change="onChange(props.item.used)"
                        ></v-switch>
                    </td>

                    <td>{{ props.item.image }}</td>
                    <td>

                        <v-edit-dialog
                            :return-value.sync="props.item"
                            lazy
                            @save="save(props.item)"
                            @cancel="cancel(props.item)"
                            @open="open(props.item)"
                            @close="close(props.item)"
                        > {{ props.item.order }}
                            <template v-slot:input>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    type="text"
                                    v-model="props.item.order"
                                    :label="trans.edit"
                                    single-line
                                ></v-text-field>
                            </template>
                        </v-edit-dialog>

                    </td>
                    <td class="text-xs-right">
                        <v-icon
                            small
                            class="mr-2"
                            @click="onEditEvent(props.item)"
                        >
                            edit
                        </v-icon>

                        <v-icon
                            :color="themeOption.buttonDangerColor"
                            small
                            @click="onDeleteEvent(props.item)"
                        >
                            delete
                        </v-icon>
                    </td>
                </template>
            </v-data-table>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return {
                pagination:{}
            }
        },

        computed:({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                vehicles: 'getEventVehicles',
                headers: 'getEventVehiclesListHeader',
                totalEvents: 'getTotalEventVehicle',
                loading: 'getEventVehiclesLoading',
                rowsPerPage: 'getEventVehiclesListRowsPerPage',
                selectedEvent: 'getSelectedEventVehicle'
            })
        }),

        watch:{
            pagination: {
                handler() {
                    this.initialize()
                }
            }
        },

        created() {

        },

        methods:{
            // Initialize data when first render
            initialize() {
                let paramObject = {}

                if(this.subComponent){
                }
                const paginateOption = {
                    ...this.pagination,
                    id: this.$route.params.eventId,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchBrands,
                    ...paramObject
                }

                this.$store.dispatch('fetchEventVehicles', paginateOption)
            },

            save (item) {
                console.log(item)
            },
            cancel (item) {
                console.log(item)
            },
            open () {
            },
            close (item) {
                console.log(item)
            },

            onChange(vehicle){
                console.log(vehicle)
            }
        }
    }
</script>
