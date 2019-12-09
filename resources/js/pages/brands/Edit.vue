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
                            <v-layout row wrap>
                                <v-flex xs12 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || trans.brand_name_is_required]"
                                        :color="themeOption.inputColor"
                                        :label="trans.name"
                                        v-model="brand.name"
                                    ></v-text-field>
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

                                <v-flex xs12 sm6 pa-2>
                                    <div class="r-color-picker" v-if="isColorSwatchActive">
                                        <div class="r-color-picker-content">
                                            <chrome v-model="selectedColor"></chrome>
                                            <v-btn small
                                                   class="r-color-choose"
                                                   @click="isColorSwatchActive = false"
                                                   :color="themeOption.buttonPrimaryColor">
                                                {{ trans.select }}
                                            </v-btn>
                                        </div>
                                    </div>

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
                                        key="regions"
                                        ripple
                                    >
                                        {{ trans.regions}}
                                    </v-tab>

                                    <v-tab
                                        key="flag"
                                        ripple
                                    >
                                        {{ trans.logo}}
                                    </v-tab>

                                    <v-tab-item
                                        key="regions"
                                    >
                                        <Regions model="brand"></Regions>
                                    </v-tab-item>

                                    <v-tab-item
                                        key="logo"
                                    >
                                        <v-layout row wrap pt-3>
                                            <v-card width="250px">
                                                <v-img
                                                    :src="logo"
                                                    aspect-ratio="2.75"
                                                ></v-img>
                                            </v-card>
                                            <FileUpload :preview="false"
                                                        model="country"></FileUpload>
                                        </v-layout>
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

    export default {
        components: {
            Chrome,
            FileUpload,
            Regions,
            LanguagePicker
        },

        data() {
            return {
                valid: true,
                active: null,
                model: null,

                isColorSwatchActive: false,
                selectedColor: '',
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
                logo: 'getUploadedImage'
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
