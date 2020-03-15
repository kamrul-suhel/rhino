<template>
    <v-layout row wrap>
        <v-flex xs12 pt-3>
            <v-data-table
                :headers="headers"
                :items="vehicles"
                disable-initial-sort
                :pagination.sync="pagination"
                :no-results-text="`${trans.noBrandsFound}`"
                :no-data-text="`${trans.noBrandsFound}`"
                :rows-per-page-text="trans.rowsPerPage === null ? 'Row per page' : trans.rowsPerPage"
                :rows-per-page-items="rowsPerPage"
                :total-items="totalEvents"
                :loading="loading"
                class="elevation-1"
            >
                <template v-slot:items="props">
                    <td>{{ props.item.model }}</td>
                    <td>
                        <v-checkbox
                            class="eventVehicleSwitch"
                            :color="themeOption.inputColor"
                            :false-value="0"
                            :true-value="1"
                            v-model="props.item.new"
                            @change="onEventVehicleChange(props.item)"
                        ></v-checkbox>
                    </td>

                    <td>
                        <v-checkbox
                            class="eventVehicleSwitch"
                            :false-value="0"
                            :true-value="1"
                            :color="themeOption.inputColor"
                            v-model="props.item.used"
                            return-object
                            @change="onEventVehicleChange(props.item)"
                        ></v-checkbox>
                    </td>

                    <td>
                        <v-avatar
                            tile
                            color="grey lighten-4"
                            @click="onImageChange(props.item)"
                        >
                            <img :src="props.item.image|image(themeOption.brandDefaultImage)" alt="avatar">
                        </v-avatar>
                    </td>

                    <td>
                        <v-edit-dialog
                            :return-value.sync="props.item"
                            lazy
                            @save="onEventVehicleChange(props.item)"
                            @cancel="cancel(props.item)"
                            @open="open(props.item)"
                            @close="close(props.item)"
                        > {{ props.item.order }}
                            <template v-slot:input>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    type="number"
                                    v-model="props.item.order"
                                    :label="trans.edit"
                                    single-line
                                ></v-text-field>
                            </template>
                        </v-edit-dialog>
                    </td>

                    <td class="text-xs-right">
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


        <v-dialog
            v-model="dialog"
            width="250"
        >
            <v-card>
                <v-card-title>
                    {{ `${trans.uploadImage}`}}
                </v-card-title>

                <v-card-text>
                    <v-card>
                        <v-img
                            :src="selectedVehicle.image|image(themeOption.brandDefaultImage)"
                            aspect-ratio="2.75"
                        ></v-img>
                    </v-card>

                    <input
                        ref="image"
                        type="file"
                        @change="setImage"
                    />
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        small
                        :color="themeOption.buttonPrimaryColor"
                        @click="onUploadConfirm()"
                    >
                        {{ trans.upload }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                dialog: false,
                pagination: {},
                selectedVehicle: {}
            }
        },

        computed: ({
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

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            '$route.params.eventId': function(id){
                this.initialize()
            }
        },

        created() {

        },

        methods: {
            // Initialize data when first render
            initialize() {
                let paramObject = {}

                if (this.subComponent) {
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

            cancel(item) {

            },

            open() {
            },

            close(item) {
            },

            onEventVehicleChange(vehicle, fetchVehicle = false) {
                let eventVehicleForm = new FormData()
                eventVehicleForm.append('_method', 'PUT')
                const URL = `/api/eventvehicle/${vehicle.id}`

                // Set form object for event vehicle
                _.forOwn(vehicle, (value, key) => {
                    eventVehicleForm.append(key, value)
                })

                axios.post(URL, eventVehicleForm).then((response) => {
                    if(response.data.success){
                        if(fetchVehicle){
                            this.dialog = false
                            this.selectedVehicle = {}
                            this.initialize()
                        }
                    }
                })
            },

            onImageChange(vehicle) {
                this.selectedVehicle = {...vehicle}
                this.dialog = true
            },

            setImage() {
                const image = this.$refs.image.files[0]
                this.uploadImage(image, 'vehicles')
            },

            onUploadConfirm() {
                this.onEventVehicleChange(this.selectedVehicle, true)
            },

            uploadImage(file, identifier) {
                let formData = new FormData()
                formData.append('file', file)
                formData.append('model', identifier)

                axios.post('/api/uploadfiles', formData).then((response) => {
                    this.rightImage = response.data
                    this.selectedVehicle = {
                        ...this.selectedVehicle,
                        image: response.data
                    }
                })
            },

            onDeleteEvent(vehicle){
                const URL = `/api/eventvehicle/${vehicle.id}`
                axios.delete(URL).then((response)=>{
                    if(response.data.success){
                        this.initialize()
                    }
                })
            }
        }
    }
</script>
