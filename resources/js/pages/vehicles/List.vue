<template>
    <div>
        <v-layout row wrap>
            <div class="r-tab" :class="[showForm ? 'open' : '']">
                <div class="r-tab-title r-border-round" @click="toggleForm">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">drive_eta
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.addAVehicle}` }}
                    </div>
                </div>

                <div class="r-tab-content" :class="[showForm ? 'open' : '']">
                    <v-container fluid pa-0 grid-list-xl>
                        <v-form
                            row wrap
                            ref="vehicleForm"
                            v-model="valid"
                            lazy-validation>
                            <v-layout row wrap>
                                <v-flex xs12 sm5 pa-2>
                                    <v-select box
                                              :items="brands"
                                              item-text="name"
                                              item-value="id"
                                              :rules="[v => !!v || `${trans.vehicleBrandIsRequired}`]"
                                              :color="themeOption.inputColor"
                                              :label="`${trans.selectABrand}`"
                                              v-model="vehicle.brand_id"
                                              style="width: 70%"
                                              solo
                                              flat
                                    >
                                    </v-select>
                                </v-flex>
                                <v-flex xs12 sm5 pa-2>
                                    <v-text-field box
                                                  :rules="[v => !!v || `${trans.modelIsRequired}`]"
                                                  :label="`${trans.modelOfVehicle}`"
                                                  :color="themeOption.inputColor"
                                                  v-model="vehicle.model"
                                                  style="width: 70%"
                                                  solo
                                                  flat
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout>
                                <v-flex xs12 sm5 pa-2>
                                    <v-layout row wrap pt-3>
                                        <v-flex xs12>
                                            <label class="mb-3">{{ trans.leftHandDriveImage}}</label>
                                            <v-img
                                                :src="leftImage"
                                                width="150"
                                            ></v-img>
                                            <input
                                                ref="leftImage"
                                                type="file"
                                                @change="setLeftImage"
                                            />
                                        </v-flex>
                                    </v-layout>
                                </v-flex>

                                <v-flex xs12 sm5 pa-2>
                                    <v-layout row wrap pt-3>
                                        <v-flex xs12>
                                            <label>{{ trans.rightHandDriveImage }}</label>
                                            <v-img
                                                :src="rightImage"
                                                width="150"
                                            ></v-img>
                                            <input
                                                ref="rightImage"
                                                type="file"
                                                @change="setRightImage"
                                            />
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>

                            <v-layout>
                                <v-flex xs12 text-center>
                                    <v-card-actions class="pa-3">
                                        <v-btn
                                            dark
                                            small
                                            @click="onCreateVehicle()"
                                            :color="themeOption.buttonDangerColor"
                                            class="rounded-btn"
                                        >
                                            {{ `${trans.submit}` }}
                                        </v-btn>
                                    </v-card-actions>
                                </v-flex>
                            </v-layout>
                        </v-form>
                    </v-container>
                </div>
            </div>
        </v-layout>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="vehicles"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.noVehiclesFound}`"
                    :no-data-text="`${trans.noVehiclesFound}`"
                    :rows-per-page-text="trans.rowsPerPage === null ? 'Row per page' : trans.rowsPerPage"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalVehicles"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <tr @click="onEditVehicle(props.item)">
                            <td width="10%">
                                <v-img
                                    contain
                                    :src="props.item.driver_seating_position_left_image"
                                    aspect-ratio="1"
                                >
                                </v-img>
                            </td>
                            <td width="10%">
                                <v-img
                                    contain
                                    :src="props.item.driver_seating_position_right_image"
                                    aspect-ratio="1"
                                >
                                </v-img>
                            </td>
                            <td width="20%">{{ props.item.model }}</td>
                            <td v-if="!subComponent">{{ props.item.brand }}</td>
                            <td class="text-xs-right">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click.stop="onEditVehicle(props.item)">
                                    edit
                                </v-icon>

                                <v-icon
                                    :color="themeOption.buttonDangerColor"
                                    small
                                    @click.stop="onDeleteVehicle(props.item)"
                                >
                                    delete
                                </v-icon>
                            </td>
                        </tr>
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
                        @click="onDeleteCancel"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        dark
                        :color="themeOption.buttonDangerColor"
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
    import vehicle from "../../store/modules/vehicle";

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
                isVehicleSelected: false,
                vehicle: {},
                leftImage: '',
                rightImage: '',
                hasLeftImage: false,
                hasRightImage: false,
                showForm: false
            }
        },

        props: {
            subComponent: {
                type: Boolean,
                default: false
            },

            model: {
                type: String
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                brands: 'getBrandsForDropDown',
                themeOption: 'getThemeOption',
                vehicles: 'getVehicles',
                headers: 'getVehicleListHeader',
                totalVehicles: 'getTotalVehicles',
                loading: 'getVehicleLoading',
                rowsPerPage: 'getVehicleListRowsPerPage',
                selectedVehicle: 'getSelectedVehicle',
                //brandImage: 'getUploadedImage'
                updateComponent: 'getUpdateComponent'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize();
                }
            },

            searchVehicle() {
                this.initialize()
            },

            updateComponent() {
                this.initialize()
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.manageVehicles}`)
            this.$store.commit('setNavTitle', `${this.trans.manageVehicles}`)
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {

                let extraOption = {}
                if (this.subComponent) {
                    extraOption = {
                        filterBy: this.model,
                        brandId: this.$route.params.id
                    }
                }

                this.$store.dispatch('fetchBrandForDropDown');
                this.$store.dispatch('fetchVehicles', this.getPagination())
            },

            onCreateVehicle() {

                if (this.$refs.vehicleForm.validate()) {
                    let vehicleForm = new FormData()
                    // Set form object for vehicle
                    _.forOwn(this.vehicle, (value, key) => {
                        vehicleForm.append(key, value)
                    });

                    vehicleForm.append('leftImage', this.leftImage)
                    vehicleForm.append('rightImage', this.rightImage)

                    if (this.subComponent) {
                        vehicleForm.append('brand_id', this.$route.params.brandId)
                    }

                    // send form data to save
                    axios.post('/api/vehicles', vehicleForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.vehicle.model}  ${this.trans.successfullyCreated}`
                            })

                            this.$store.commit('setUpdateComponent')

                            this.vehicle = {}
                            this.leftImage = ''
                            this.rightImage = ''
                            this.hasLeftImage = false
                            this.hasRightImage = false
                            this.showForm = false

                        }
                    })
                } else {
                }
            },


            getPagination() {
                return {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchVehicle,
                    subComponent: this.subComponent,
                }
            },

            setLeftImage() {
                const image = this.$refs.leftImage.files[0]
                this.uploadImage(image, 'vehicles', 'leftImage')
                this.hasLeftImage = true
            },

            setRightImage() {
                const image = this.$refs.rightImage.files[0]
                this.uploadImage(image, 'vehicles', 'rightImage')
                this.hasRightImage = true
            },

            uploadImage(file, identifier, image) {
                let formData = new FormData()
                formData.append('file', file)
                formData.append('model', identifier)

                axios.post('/api/uploadfiles', formData).then((response) => {
                    if (image === 'leftImage') {
                        this.leftImage = response.data
                    }

                    if (image === 'rightImage') {
                        this.rightImage = response.data
                    }
                })
            },

            onEditVehicle(vehicle) {
                // $router.push({name: 'editVehicles', params:{id: props.item.id}})
                if (this.subComponent) {
                    switch (this.model) {
                        case 'brand':
                            this.$router.push({
                                name: 'editBrandVehicle',
                                params: {brandId: this.$route.params.id, vehicleId: vehicle.id}
                            })
                            break
                    }

                } else {
                    this.$router.push({name: 'editVehicles', params: {id: vehicle.id}})
                }
            },

            onDeleteVehicle(vehicle) {
                this.deleteDialog = true
                this.$store.commit('setSelectedVehicle', vehicle)
            },

            onDeleteCancel() {
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
                                message: `${selectedVehicle.model}  ${this.trans.successfullyDeleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.onResetVehicle()
                            this.deleteDialog = false
                        }
                    });
            },

            onLanguageChange(selectedLanguage) {
                this.$store.dispatch('fetchVehicle', {
                    id: this.selectedVehicle.id,
                    languageId: selectedLanguage
                })
            },

            onResetVehicle() {
                this.editVehicle = false
                this.$store.commit('setSelectedVehicle', {})
            },

            toggleForm() {
                this.showForm = !this.showForm
            }
        }
    }
</script>
