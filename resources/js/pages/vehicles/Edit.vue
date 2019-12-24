<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span :class="themeOption.textHeadingColor+'--text'">{{ `${trans.edit} ${trans.vehicle}` }}:</span>
                        <span v-if="!subComponent">{{ vehicle.brand }}</span> <span>{{ vehicle.model }}</span>
                    </v-toolbar-title>

                    <v-divider
                        class="mx-2"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>

                    <language-picker :languageId="vehicle.language_id"></language-picker>
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
                                        :rules="[v => !!v || `${trans.vehicle} ${trans.model} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.model"
                                        v-model="vehicle.model"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap v-if="!subComponent">
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="brands"
                                        item-text="name"
                                        :rules="[v => !!v || `${trans.select_a} ${trans.brand}`]"
                                        item-value="id"
                                        :color="themeOption.inputColor"
                                        :label="trans.brand"
                                        v-model="vehicle.brand_id"
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>

                            <v-divider class="mt-2 mb-2"></v-divider>


                            <v-layout>
                                <v-flex xs12 sm6 pa-2>
                                    <v-layout row wrap pt-3>
                                        <v-flex xs12>
                                            <label class="mb-3">{{ `${trans.left_hand_drive_image}` }}</label>
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
                                           <label for="">{{`${trans.right_hand_drive_image}`}} </label>

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

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                identifier="'vehicleBack'"
                                :class="themeOption.buttonSecondaryColor"
                                small
                                @click="onBackToBrand"
                            >
                                {{ trans.back }}
                            </v-btn>

                            <v-btn
                                :loading="themeOption.buttonLoading"
                                :disabled="themeOption.buttonLoading"
                                :class="themeOption.buttonSuccess"
                                small
                                @click="onUpdateVehicle()"
                            >
                                {{ trans.update }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import {Chrome} from 'vue-color'
    import FileUpload from '../../components/ImageUpload'
    import vehicle from "../../store/modules/vehicle";
    import LanguagePicker from '../../components/Language'

    export default {
        components: {
            FileUpload,
            LanguagePicker
        },

        data() {
            return {
                valid: true,

                leftImage: '',
                rightImage: '',
            }
        },

        props: {
            subComponent: {
                type: Boolean,
                default: false
            },
            model: {
                type: String,
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown',
                brand: 'getSelectedBrand',
                selectedLanguage: 'getSubSelectedLanguage',
                vehicle: 'getSelectedVehicle',
            })
        }),

        watch: {
            vehicle(value) {
                this.$refs.vehicleForm.resetValidation();
                this.leftImage = this.vehicle.driver_seating_position_left_image;
                this.rightImage = this.vehicle.driver_seating_position_right_image;
            },

            selectedLanguage(){
                this.$store.dispatch('fetchVehicle', {
                    id: this.$route.params.id,
                    languageId: this.selectedLanguage.id,
                    edit: true
                })
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchBrandForDropDown');

                if ( this.subComponent) {
                    this.$store.dispatch('fetchVehicle', {id: this.$route.params.vehicleId})
                } else {
                    this.$store.dispatch('fetchVehicle', {id: this.$route.params.id})
                }
            },

            onUpdateVehicle(){
                if (this.$refs.vehicleForm.validate()) {
                    let vehicleForm = new FormData()

                    this.vehicle.leftImage = this.leftImage;
                    this.vehicle.rightImage = this.rightImage;

                    // Set form object for vehicle
                    _.forOwn(this.vehicle, (value, key) => {
                        vehicleForm.append(key, value)
                    })

                    vehicleForm.append('_method', 'put')

                    // send form data to save
                    const URL = `/api/vehicles/${this.vehicle.id}/update`
                    axios.post(URL, vehicleForm).then((response)=>{
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.vehicle.model}  ${this.trans.successfully_updated}`
                            })
                        }
                    }).catch((error)=>{
                    })
                }
            },

            onBackToBrand(){
                if(this.subComponent){
                    console.log('is subComponent');
                    switch(this.model){
                        case 'brand':
                            this.$router.push({
                                name: 'editBrand',
                                params: {
                                    id: this.$route.params.BrandId
                                }
                            })

                            this.$store.commit('setButtonLoading', false)
                            break
                    }
                }else{
                    console.log("isn't subComponent");
                    this.$router.push({name: 'listBrands'})
                    this.$store.commit('setButtonLoading', false)
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

        },

    }
</script>
