<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span :class="themeOption.textHeadingColor+'--text'">{{ trans.create_vehicle }}</span>
                    </v-toolbar-title>

                    <v-divider
                        class="mx-2"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                </v-toolbar>
            </v-flex>
        </v-layout>

        <v-form
            row wrap
            ref="vehicleForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-card>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 pa-2>
                                    <v-text-field
                                        :rules="nameRules"
                                        :label="trans.model_of_vehicle"
                                        v-model="vehicle.model"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="brands"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || trans.vehicle_brand_is_required]"
                                        :color="themeOption.inputColor"
                                        :label="trans.select_a_brand"
                                        v-model="vehicle.brand_id"
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>

                            <v-layout>
                                <v-flex xs12 sm6 pa-2>
                                    <v-layout row wrap pt-3>
                                        <v-flex xs12>
                                            <label class="mb-3">Left hand drive image</label>
                                            <v-divider class="my-2"></v-divider>

                                            <v-card class="pa-2 my-3">
                                                <v-img
                                                    :src="leftImage"
                                                    aspect-ratio="2.75"
                                                ></v-img>
                                            </v-card>

                                            <image-uploader
                                                :preview="false"
                                                :className="['fileinput', { 'fileinput--loaded': hasLeftImage }]"
                                                capture="environment"
                                                :debug="0"
                                                accept="image/*"
                                                doNotResize="gif"
                                                :autoRotate="true"
                                                outputFormat="file"
                                                @input="setLeftImage"
                                            >
                                                <label for="fileInput" slot="upload-label">
                                                    <v-icon right>cloud_upload</v-icon>

                                                    <span class="upload-caption">
                                                {{hasLeftImage ? "Replace" : "Click to upload" }}
                                            </span>
                                                </label>
                                            </image-uploader>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>


                                <v-flex xs12 sm6 pa-2>
                                    <v-layout row wrap pt-3>
                                       <v-flex xs12>
                                           <label for="">Right hand drive image</label>

                                           <v-divider class="my-2"></v-divider>

                                           <v-card class="pa-2 my-3">
                                               <v-img
                                                   :src="rightImage"
                                                   aspect-ratio="2.75"
                                               ></v-img>
                                           </v-card>

                                           <image-uploader
                                               :preview="false"
                                               :className="['fileinput', { 'fileinput--loaded': hasRightImage }]"
                                               capture="environment"
                                               :debug="0"
                                               accept="image/*"
                                               doNotResize="gif"
                                               :autoRotate="true"
                                               outputFormat="file"
                                               @input="setRightImage"
                                           >
                                               <label for="fileInput" slot="upload-label">
                                                   <v-icon right>cloud_upload</v-icon>

                                                   <span class="upload-caption">
                                                {{hasRightImage ? "Replace" : "Click to upload" }}
                                            </span>
                                               </label>
                                           </image-uploader>
                                       </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>

                        </v-card-text>
                    </v-card>

                    <v-divider></v-divider>

                    <v-card-actions class="pa-3">
                        <v-spacer></v-spacer>
                        <v-btn
                            :class="themeOption.buttonSuccess"
                            small
                            @click="onCreateVehicle()"
                        >
                            {{ trans.create_vehicle }}
                        </v-btn>
                    </v-card-actions>
                </v-flex>
            </v-layout>
        </v-form>

    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import FileUpload from "../../components/ImageUpload";
    import vehicle from "../../store/modules/vehicle";

    export default {
        components: {
            FileUpload
        },

        data() {
            return {
                valid: true,
                vehicle: {},

                nameRules: [
                    v => !!v || this.trans.vehicle_model_is_required
                ],

                leftImage: '',
                rightImage: '',
                hasLeftImage: false,
                hasRightImage: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown',
                image: 'getUploadedImage',
            })
        }),

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchBrandForDropDown');
            },

            onCreateVehicle() {

                console.log('create vehicle');

                if (this.$refs.vehicleForm.validate()) {

                    console.log('Passed validate');

                    let vehicleForm = new FormData()

                    // Set form object for vehicle
                    _.forOwn(this.vehicle, (value, key) => {
                        vehicleForm.append(key, value)
                    })


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
                            this.$router.push({name: 'listVehicles'})
                        }
                    })
                } else {
                    console.log('failed validate');
                }
            },

            setLeftImage(image) {
                this.uploadImage(image, 'vehicles', 'leftImage')
                this.hasLeftImage = true
            },

            setRightImage(image){
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
                        console.log(this.leftImage)
                    }

                    if(image === 'rightImage'){
                        this.rightImage = response.data
                    }
                })
            }
        }
    }
</script>