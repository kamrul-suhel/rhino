<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.vehicles }}</span>
            </v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :color="themeOption.inputColor"
                :label="trans.search_by_model"
                v-model="searchVehicle">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="vehicles"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_vehicle_found"
                    :no-data-text="trans.no_vehicle_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalVehicles"
                    :loading="loading"
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.model }}</td>
                        <td>{{ props.item.brand }}</td>
                        <td class="text-xs-right">
                            <a :href="('vehicles/'+props.item.id+'/edit')">
                                <v-icon
                                small
                                class="mr-2"

                            >
                                edit
                            </v-icon>
                            </a>

                            <v-icon
                                :color="themeOption.buttonDangerColor"
                                small
                                @click="onDeleteVehicle(props.item)"
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
                    <h3>{{ trans.delete }} {{selectedVehicle.name }}</h3>
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
                        @click="onConfirmDeleteVehicle"
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
                searchVehicle: '',
                editVehicle: false,
                valid: true,
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                brands: 'getBrands',
                themeOption: 'getThemeOption',
                vehicles: 'getVehicles',
                headers: 'getVehicleListHeader',
                totalVehicles: 'getTotalVehicles',
                loading: 'getVehicleLoading',
                rowsPerPage: 'getVehicleListRowsPerPage',
                selectedVehicle: 'getSelectedVehicle',
                //brandImage: 'getUploadedImage'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            searchVehicle() {
                this.initialize()
            },

            // selectedColor(value) {
            //     this.color = value.hex
            // }
        },

        created() {
        },

        mounted() {
        },
        methods: {
            fetchVehicle() {
                this.$store.dispatch('fetchVehicles', {themeOption: this.themeOption, trans: this.trans});
            },

            // Initialize data when first render
            initialize() {
                //this.$refs.createVehicle.resetValidation()

                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchVehicle
                }

                this.$store.dispatch('fetchVehicles', paginateOption)
            },

            onEditVehicle(vehicle) {
                this.$router.push({model: 'editVehicles', params: {id: vehicle.id}})
            },

            onDeleteVehicle(vehicle) {
                this.deleteDialog = true
                this.$store.commit('setSelectedVehicle', vehicle)
            },

            onDeleteCancel(){
                this.deleteDialog = false
                this.$refs.createVehicle.resetValidation()
                this.$store.commit('setSelectedVehicle', {})
            },

            onConfirmDeleteVehicle() {
                const selectedVehicle = this.selectedVehicle
                const URL = `/api/vehicles/${selectedVehicle.id}`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedVehicle.model}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.onResetVehicle()
                            this.deleteDialog = false
                        }
                    });
            },
            // onCreateVehicle() {
            //     if (this.$refs.createVehicle.validate()) {
            //         // Check update or create
            //         let URL = '/api/vehicles'
            //         let vehicleForm = new FormData()
            //         vehicleForm.append('model', this.selectedVehicle.model)
            //         vehicleForm.append('driver_seating_position_right_image', this.seatingRightImage)
            //         vehicleForm.append('driver_seating_position_left_image', this.seatingLeftImage)
            //         vehicleForm.append('brand_id', this.selectedVehicle.brand_id)
            //         vehicleForm.append('status', this.selectedVehicle.status)

            //         axios.post(URL, vehicleForm).then((response) => {
            //             if (response.data.success) {
            //                 this.initialize()
            //                 this.$store.commit('setSnackbarMessage', {
            //                     openMessage: true,
            //                     timeOut: this.themeOption.snackBarTimeout,
            //                     message: `${this.selectedVehicle.model}  ${this.trans.successfully_created}`
            //                 })

            //                 this.onResetVehicle()
            //             }
            //         })
            //     }

            // },

            onLanguageChange(selectedLanguage) {
                this.$store.dispatch('fetchVehicle', {
                    id: this.selectedVehicle.id,
                    languageId: selectedLanguage
                })
            },

            onResetVehicle() {
                this.editVehicle = false
                this.$store.commit('setSelectedVehicle', {})
                // this.$store.commit('resetImageUpload')
            },
        }
    }
</script>