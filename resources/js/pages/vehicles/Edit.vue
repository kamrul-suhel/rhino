<template>
    <v-container pa-0>
        <v-layout row wrap justify-end>
            <v-flex xs12 sm3>
                <language-picker
                    :languageId="vehicle.language_id"
                    :solo="false"
                    :flat="false"
                    :chip="false"
                ></language-picker>
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
                            <v-layout row wrap v-if="!subComponent">
                                <v-flex xs12 sm5 pa-2>
                                    <v-select
                                        :items="brands"
                                        item-text="name"
                                        :rules="[v => !!v || `${trans.select_a} ${trans.brand}`]"
                                        item-value="id"
                                        :color="themeOption.inputColor"
                                        :label="trans.brand"
                                        v-model="vehicle.brand_id"
                                        style="width: 70%"
                                        box solo flat>
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm5 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.vehicle} ${trans.model} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.model"
                                        v-model="vehicle.model"
                                        style="width: 70%"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout>
                                <v-flex xs12 sm5 pa-2>
                                    <v-layout row wrap pt-3>
                                        <v-flex xs12>
                                            <label class="mb-3">{{ `${trans.left_hand_drive_image}` }}</label>
                                            <v-card class="pa-2 my-3">
                                                <v-img
                                                    contain
                                                    aspect-ratio="2.2"
                                                    :src="leftImage"
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


                                <v-flex xs12 sm5 pa-2>
                                    <v-layout row wrap pt-3>
                                        <v-flex xs12>
                                            <label for="">{{`${trans.right_hand_drive_image}`}} </label>
                                            <v-card class="pa-2 my-3">
                                                <v-img
                                                    aspect-ratio="2.2"
                                                    contain
                                                    :src="rightImage"
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

                        <v-card-actions class="justify-center pa-3">
                            <v-btn
                                dark
                                identifier="'vehicleBack'"
                                :class="themeOption.buttonSecondaryColor"
                                class="rounded-btn"
                                small
                                @click="onBackToVehicles"
                            >
                                {{ trans.back }}
                            </v-btn>

                            <v-btn
                                dark
                                :loading="themeOption.buttonLoading"
                                :disabled="themeOption.buttonLoading"
                                :color="themeOption.buttonDangerColor"
                                class="rounded-btn"
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
    import FileUpload from '../../components/ImageUpload'
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

            selectedLanguage() {
                this.$store.dispatch('fetchVehicle', {
                    id: this.$route.params.id,
                    languageId: this.selectedLanguage.id,
                    edit: true
                })
            }
        },

        created() {
            this.initialize()
            this.$store.commit('setHeaderTitle', `${this.trans.edit} ${this.trans.vehicle}`)
            this.$store.commit('setNavTitle', `${this.trans.edit} ${this.trans.vehicle}`)
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchBrandForDropDown');

                if (this.subComponent) {
                    this.$store.dispatch('fetchVehicle', {id: this.$route.params.vehicleId})
                } else {
                    this.$store.dispatch('fetchVehicle', {id: this.$route.params.id})
                }
            },

            onUpdateVehicle() {
                if (this.$refs.vehicleForm.validate()) {
                    let vehicleForm = new FormData()

                    // Set form object for vehicle
                    _.forOwn(this.vehicle, (value, key) => {
                        vehicleForm.append(key, value)
                    })

                    vehicleForm.append('leftImage', this.leftImage)
                    vehicleForm.append('rightImage', this.rightImage)

                    vehicleForm.append('_method', 'put')

                    // send form data to save
                    const URL = `/api/vehicles/${this.vehicle.id}/update`
                    axios.post(URL, vehicleForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.vehicle.model}  ${this.trans.successfully_updated}`
                            })
                        }
                    }).catch((error) => {
                        this.$store.commit('setAppErrorMessages', error)
                    })
                }
            },

            onBackToVehicles() {
                this.$router.push({name: 'listVehicles'})
                this.$store.commit('setButtonLoading', false)
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
            }

        },

    }
</script>
