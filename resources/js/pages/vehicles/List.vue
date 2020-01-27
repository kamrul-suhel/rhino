<template>
    <div>
        <v-layout row wrap>
            <div class="r-tab" >
                <div class="r-tab-title r-border-round">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">drive_eta
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.add} ${trans.a} ${trans.vehicle}` }}
                    </div>
                </div>

                <div class="r-tab-content" >
                    <v-container fluid pa-0 grid-list-xl>
                        <v-form
                        row wrap
                        ref="vehicleForm"
                        v-model="valid"
                        lazy-validation>
                        <v-layout row wrap>
                            <v-flex xs12 pa-2>
                                <v-text-field box
                                    :rules="[v => !!v || `${trans.model} ${trans.is_required}`]"
                                    :label="`${trans.model} ${trans.of} ${trans.vehicle}`"
                                    :color="themeOption.inputColor"
                                    v-model="vehicle.model"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>

                        <v-layout row wrap>
                            <v-flex xs12 sm6 pa-2>
                                <v-select box
                                    :items="brands"
                                    item-text="name"
                                    item-value="id"
                                    :rules="[v => !!v || `${trans.vehicle} ${trans.brand} ${trans.is_required}`]"
                                    :color="themeOption.inputColor"
                                    :label="`${trans.select_a} ${trans.brand}`"
                                    v-model="vehicle.brand_id"
                                >
                                </v-select>
                            </v-flex>
                        </v-layout>

                        <v-layout>
                            <v-flex xs12 sm6 pa-2>
                                <v-layout row wrap pt-3>
                                    <v-flex xs12>
                                        <label class="mb-3">{{ trans.left_hand_drive_image}}</label>
                                        <v-divider class="my-2"></v-divider>

                                        <v-card class="pa-2 my-3">
                                            <v-img
                                                :src="leftImage"
                                                aspect-ratio="2.75"
                                            ></v-img>
                                        </v-card>

                                        <input
                                            ref="leftImage"
                                            type="file"
                                            @change="setLeftImage"
                                        />
                                    </v-flex>
                                </v-layout>
                            </v-flex>

                            <v-flex xs12 sm6 pa-2>
                                <v-layout row wrap pt-3>
                                    <v-flex xs12>
                                        <label for="">{{ trans.right_hand_drive_image }}</label>

                                        <v-divider class="my-2"></v-divider>

                                        <v-card class="pa-2 my-3">
                                            <v-img
                                                :src="rightImage"
                                                aspect-ratio="2.75"
                                            ></v-img>
                                        </v-card>

                                        <input
                                            ref="rightImage"
                                            type="file"
                                            @change="setRightImage"
                                        />
                                    </v-flex>
                                </v-layout>
                            </v-flex>

                            <v-flex xs12 text-center>
                                <v-card-actions class="pa-3">
                                <v-spacer></v-spacer>
                                <v-btn
                                    :class="themeOption.buttonSuccess"
                                    small
                                    @click="onCreateVehicle()"
                                >
                                    {{ `${trans.create} ${trans.vehicle}` }}
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
                    :no-results-text="`${trans.no} ${trans.vehicle} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.vehicle} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalVehicles"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <tr @click="onEditVehicle(props.item)">
                            <td>{{ props.item.model }}</td>
                            <td v-if="!subComponent">{{ props.item.brand }}</td>
                            <td class="text-xs-right">
                                <v-icon
                                small
                                class="mr-2"
                                @click="onEditVehicle(props.item)">
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
                hasRightImage: false
            }
        },

        props:{
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
            }
        },

        created() {
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {

                let extraOption = {}
                if(this.subComponent){
                    extraOption = {
                        filterBy: this.model,
                        brandId: this.$route.params.id
                    }
                }

                this.$store.dispatch('fetchBrandForDropDown');
                this.$store.dispatch('fetchVehicles', this.getPagination())
            },

            onCreateVehicle() {

                console.log('create vehicle');

                if (this.$refs.vehicleForm.validate()) {

                    console.log('Passed validate');

                    let vehicleForm = new FormData()

                    this.vehicle.leftImage = this.leftImage;
                    this.vehicle.rightImage = this.rightImage;

                    // Set form object for vehicle
                    _.forOwn(this.vehicle, (value, key) => {
                            vehicleForm.append(key, value)
                    });          
                    
                    if(this.subComponent){
                        vehicleForm.append('brand_id', this.$route.params.brandId)
                    }

                    // send form data to save
                    axios.post('/api/vehicles', vehicleForm).then((response) => {
                        if (response.data.success) {
                            console.log('success');
                            console.log(response.data);

                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.vehicle.model}  ${this.trans.successfully_created}`
                            })


                            this.$store.dispatch('fetchVehicles', this.getPagination() );
                            
                        }
                    })
                } else {
                    console.log('failed validate');
                }
            },



            getPagination(){
                const pagination = {
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

            setRightImage(){
                const image = this.$refs.rightImage.files[0]
                this.uploadImage(image, 'vehicles', 'rightImage')
                this.hasRightImage = true
            },

           uploadImage(file, identifier, image){
                let formData = new FormData()
                formData.append('file', file)
                formData.append('model', identifier)

                axios.post('/api/uploadfiles', formData).then((response) => {
                    if(image === 'leftImage'){
                        this.leftImage = response.data
                    }

                    if(image === 'rightImage'){
                        this.rightImage = response.data
                    }
                })
            },

            onEditVehicle(vehicle) {
                // $router.push({name: 'editVehicles', params:{id: props.item.id}})
                if (this.subComponent){
                    switch(this.model){
                        case 'brand':
                            this.$router.push({name: 'editBrandVehicle', params:{brandId: this.$route.params.id, vehicleId: vehicle.id}})
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
        }
    }
</script>
