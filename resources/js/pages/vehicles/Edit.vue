<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span :class="themeOption.textHeadingColor+'--text'">{{ trans.edit_vehicle }}</span>
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
                                        :rules="[v => !!v || trans.vehicle_model_is_required]"
                                        :color="themeOption.inputColor"
                                        :label="trans.model"
                                        v-model="brand.model"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="brands"
                                        item-text="name"
                                        :rules="[v => !!v || trans.select_a_brand]"
                                        item-value="id"
                                        :color="themeOption.inputColor"
                                        :label="trans.brand"
                                        v-model="vehicle.brand_id"
                                        @change="onBrandChange"
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>

                            <v-divider class="mt-2 mb-2"></v-divider>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                :class="themeOption.buttonSecondaryColor"
                                small
                                @click="$router.push({name: 'listVehicles'})"
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
    //import Brands from '../../components/Brand'
    import LanguagePicker from '../../components/Language'

    export default {
        components: {
            Chrome,
            FileUpload,
            //Brands,
            LanguagePicker
        },

        data() {
            return {
                valid: true,
                model: null,
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrands',
                brand: 'getSelectedBrand',
                selectedLanguage: 'getSubSelectedLanguage'
            })
        }),

        watch: {
            brand(value) {
                this.$refs.brandForm.resetValidation()
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
                this.$store.dispatch('fetchBrandsForDropdown')
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
