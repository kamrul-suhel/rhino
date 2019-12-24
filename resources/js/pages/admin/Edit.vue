<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span :class="themeOption.textHeadingColor+'--text'">{{ trans.edit_brand }}</span>
                    </v-toolbar-title>

                    <v-divider
                        class="mx-2"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>

                    <language-picker :languageId="brand.language_id"></language-picker>
                </v-toolbar>
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
                            <v-layout justify-space-between row>
                                <v-flex xs12 sm6 md6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || trans.brand_name_is_required]"
                                        :color="themeOption.inputColor"
                                        :label="trans.name"
                                        v-model="brand.name"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 md4 wrap pt-3 row justify-center >
                                    <v-card width="250px">
                                        <v-img
                                            contain
                                            :src="logo|image(themeOption.brandDefaultImage)"
                                            aspect-ratio="2"
                                        ></v-img>
                                    </v-card>
                                    <FileUpload :label="trans.logo" :preview="false"
                                        model="brand"></FileUpload>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="companies"
                                        item-text="name"
                                        :rules="[v => !!v || trans.select_a_company]"
                                        item-value="id"
                                        :color="themeOption.inputColor"
                                        :label="trans.company"
                                        v-model="brand.company_id"
                                        @change="onCountryChange"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 md6 pa-2 row justify-center>
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
                                        :rules="[v => !!v || trans.choose_a_color]"
                                        required
                                        @focus="isColorSwatchActive = true"
                                        :color="themeOption.inputColor">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-switch :label="trans.status"
                                              :color="themeOption.inputColor"
                                              v-model="brand.status">
                                    </v-switch>
                                </v-flex>
                            </v-layout>

                            <v-divider class="mt-2 mb-2"></v-divider>

                            <v-layout column wrap>
                                <v-tabs
                                    v-model="active"
                                    :color="themeOption.tabColor"
                                    :slider-color="themeOption.tabSliderColor"
                                >

                                    <v-tab
                                        key="vehicles"
                                        ripple
                                    >
                                        {{ trans.vehicles }}
                                    </v-tab>

                                    <v-tab
                                        key="regions"
                                        ripple
                                    >
                                        {{ trans.regions}}
                                    </v-tab>

                                    <v-tab-item
                                        key="Vehicles"
                                    >
                                        <v-layout>
                                            <v-flex xs12 md8 lg10>
                                                <vehicles model="brand" subComponent></vehicles>
                                            </v-flex>
                                            <v-flex xs12 md4 lg2 pt-3 class="text-xs-right">
                                                <v-btn
                                                    :class="themeOption.buttonSuccess"
                                                    small
                                                    @click="$router.push({name: 'addBrandVehicle'})"
                                                >
                                                    {{ trans.create_vehicle }}
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-tab-item>
                                    <v-tab-item
                                        key="regions"
                                    >
                                        <Regions model="brand"></Regions>
                                    </v-tab-item>
                                </v-tabs>
                            </v-layout>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                :class="themeOption.buttonSecondaryColor"
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
    import FileUpload from '../../components/ImageUpload'
    import Regions from '../../components/Brand/Regions'
    import LanguagePicker from '../../components/Language'
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
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchBrand', {id: this.$route.params.id})
            },
            fetchCompany() {
                this.$store.dispatch('fetchCompanies', {themeOption: this.themeOption, trans: this.trans});
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
            }
        },

        destroyed() {
            this.resetBrands()
        }
    }
</script>
