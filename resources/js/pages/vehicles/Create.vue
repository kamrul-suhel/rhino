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
                                        :label="`${trans.model} ${trans.of} ${trans.vehicle}`"
                                        :color="themeOption.inputColor"
                                        v-model="vehicle.model"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap v-if="!subComponent">
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
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
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown',
                brand: 'getSelectedBrand',
                image: 'getUploadedImage',
            })
        }),

        created() {
            this.initialize();
            
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchBrandForDropDown');
                this.$store.dispatch('fetchBrand', {id: this.$route.params.brandId});
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
                            
                            // check if vehicle created from brand or vehicle
                            if ( this.subComponent ){
                                this.$router.push({name: 'editBrands', params:{id: this.$route.params.brandId}});
                            } else {
                                this.$router.push({name: 'listVehicles'});
                            }
                        }
                    })
                } else {
                    console.log('failed validate');
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
            }
        }
    }
</script>
