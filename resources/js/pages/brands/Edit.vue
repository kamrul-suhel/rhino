<template>
    <v-container pa-0>

        <v-layout row wrap justify-end>
            <v-flex xs12 sm3>
                <language-picker :languageId="brand.language_id"></language-picker>
             </v-flex>
        </v-layout>

        <v-form
            row wrap
            ref="brandForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-card>
                        <v-card-text>
                            <v-layout justify-space-between row wrap>
                                <v-flex xs12 sm3 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.brand} ${trans.name} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.name"
                                        v-model="brand.name"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>
                            
                                <v-flex xs12 sm3 pa-2>
                                    <v-select
                                        :items="companies"
                                        item-text="name"
                                        item-value="id"
                                        :color="themeOption.inputColor"
                                        :label="trans.company"
                                        v-model="brand.company_id"
                                        @change="onCountryChange"
                                        solo flat box
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm3 pa-2 row justify-center>
                                    <v-flex xs12 sm12 md8 align-self-center >
                                        <div class="r-color-picker mx-auto" v-if="isColorSwatchActive">
                                            <div class="r-color-picker-content mx-auto">
                                                <chrome v-model="selectedColor"></chrome>
                                                <v-btn small
                                                    class="r-color-choose"
                                                    @click="isColorSwatchActive = false"
                                                    :color="themeOption.buttonPrimaryColor">
                                                    {{ trans.select }}
                                                </v-btn>
                                            </div>
                                        </div>
                                    </v-flex>

                                    <v-text-field
                                        :label="trans.color"
                                        v-model="brand.colour"
                                        :rules="[v => !!v || `${trans.color} ${trans.is_required}`]"
                                        required
                                        @focus="isColorSwatchActive = true"
                                        :color="themeOption.inputColor"
                                        solo flat box>
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm3 wrap pt-3 row justify-center >
                                    <v-img
                                        contain
                                        :src="logo|image(themeOption.brandDefaultImage)"
                                        width="100"
                                    ></v-img>
                                    <FileUpload :label="trans.logo" :preview="false"
                                        model="brand"></FileUpload>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap>

                                <v-flex xs12 sm3 pa-2>
                                    <v-switch :label="trans.status"
                                              :color="themeOption.switchOnColor"
                                              v-model="brand.status"
                                              :true-value="1"
                                              :false-value="0">
                                    </v-switch>
                                </v-flex>
                            </v-layout>


                            <v-layout column wrap>
                                
                                <Regions model="brand"></Regions>
                                
                            </v-layout>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                dark
                                :color="themeOption.buttonSecondaryColor"
                                small
                                @click="$router.push({name: 'listBrands'})"
                            >
                                {{ trans.back }}
                            </v-btn>

                            <v-btn
                                :loading="themeOption.buttonLoading"
                                :disabled="themeOption.buttonLoading"
                                :class="themeOption.buttonSuccess"
                                small
                                @click="onUpdateBrand()"
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
    import FileUpload from '@/components/ImageUpload'
    import Regions from '@/components/Brand/Regions'
    import LanguagePicker from '@/components/Language'
    import Vehicles from '../vehicles/List'

    export default {
        components: {
            Chrome,
            FileUpload,
            Regions,
            LanguagePicker,
            Vehicles
        },

        data() {
            return {
                valid: true,
                active: null,

                isColorSwatchActive: false,
                selectedColor: '',
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
                companies: 'getCompanies',
                countries: 'getCountries',
                selectedCountry: 'getSelectedCountry',
                regions: 'getRegions',
                brand: 'getSelectedBrand',
                selectedLanguage: 'getSubSelectedLanguage',
                logo: 'getUploadedImage',
                vehicles: 'getVehicles'
            })
        }),

        watch: {
            brand(value) {
                this.$refs.brandForm.resetValidation()
                this.$store.commit('setImage', value.logo)
            },

            selectedColor(value) {
                let brand = {...this.brand}
                brand.colour = value.hex
                this.$store.commit('setSelectedBrand', brand)
            },

            selectedLanguage(){
                this.$store.dispatch('fetchBrand', {
                    id: this.$route.params.id,
                    languageId: this.selectedLanguage.id,
                    edit: true
                })
            }
        },

        created() {
            this.initialize()
            this.fetchCompany()
            this.$store.commit('setHeaderTitle', `${this.trans.edit} ${this.trans.brand}`)
            this.$store.commit('setNavTitle', `${this.trans.edit} ${this.trans.brand}`)
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchBrand', {id: this.$route.params.id})
            },
            fetchCompany() {
                this.$store.dispatch('fetchCompanyForDropdown', {themeOption: this.themeOption, trans: this.trans});
            },

            onUpdateBrand() {

                if (this.$refs.brandForm.validate()) {
                    // this.$store.commit('setThemeOption', {buttonLoading: true})

                    let brandForm = new FormData()

                    // Set form object for brand
                    _.forOwn(this.brand, (value, key) => {
                        brandForm.append(key, value)
                    })

                    brandForm.append('logo', this.logo)

                    brandForm.append('_method', 'put')

                    // send form data to save
                    const URL = `/api/brands/${this.brand.id}/update`
                    axios.post(URL, brandForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.brand.name}  ${this.trans.successfully_updated}`
                            })
                            this.$store.commit('setThemeOption', {buttonLoading: false})
                            // this.$router.push({name: 'listbrands'})
                        }
                    }).catch((error) => {
                        this.$store.commit('setThemeOption', {buttonLoading: false})
                    })
                }
            },

            onCountryChange(value) {
                let newBrand = {...this.brand}
                newBrand.region_id = null
                this.$store.commit('setSelectedBrand', newBrand)
                this.$store.dispatch('fetchRegions', {id: value.id})
            },

            resetBrands(){
                this.$store.commit('setSelectedBrand', {})
                this.$store.commit('setSubSelectedLanguage', {})
                this.$store.commit('setRegionsByBrandId', [])
            },

            addBrandVehicle(){
                this.$router.push({name: 'addBrandVehicle', params: {brandId: this.$route.params.id}})
            }
        },

        destroyed() {
            this.resetBrands()
        }
    }
</script>
