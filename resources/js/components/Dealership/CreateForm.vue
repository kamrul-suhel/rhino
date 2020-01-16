<template>
    <v-form ref="brandDealershipForm"
            v-model="valid"
            lazy-validation
    >
        <v-card>
            <v-card-title>
                <h3>{{ `${trans.add} ${trans.brand}` }}</h3>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text>

                <v-layout row wrap>
                    <v-flex xs12>
                        <v-select :label="`${trans.select_a} ${trans.brand}`"
                                  :color="themeOption.inputColor"
                                  item-text="name"
                                  :rules="[v => !!v || `${trans.select_a} ${trans.brand}`]"
                                  item-value="id"
                                  v-model="selectedBrand.brand_id"
                                  @change="onBrandChange"
                                  :items="brands"
                        >
                        </v-select>
                    </v-flex>

                    <v-flex xs12>
                        <v-select :label="trans.region"
                                  :items="regions"
                                  :rules="[v => !!v || `${trans.select_a} ${trans.region}`]"
                                  item-text="name"
                                  v-model="selectedBrand.region_id"
                                  item-value="id"
                                  :color="themeOption.inputColor">
                        </v-select>
                    </v-flex>
                </v-layout>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn small
                       @click="onFetchBrands"
                       :color="themeOption.buttonSecondaryColor"
                >
                    {{ trans.cancel }}
                </v-btn>

                <v-btn small
                       @click="onCreateRelation"
                       :color="themeOption.buttonPrimaryColor"
                >{{ this.selectedBrand.id ? `${trans.update} ${trans.brand}` : `${trans.add} ${trans.brand}` }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                valid: true
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown',
                dealership: 'getSelectedDealership',
                regions: 'getRegions',
                selectedBrand: 'getSelectedBrandDealership',
                initializeBrands : 'getInitializeBrands',
            })
        },

        watch: {
            selectedBrand(){
                this.$store.dispatch('fetchRegionsByBrandIdAndCountryId',
                    {
                        countryId: this.dealership.country_id,
                        brandId: this.selectedBrand.brand_id
                    })
            },

            initializeBrands(){
                this.reset()
                this.resetValidation()
            }
        },

        created() {
        },

        methods: {
            onBrandChange(brandId) {
                this.$store.dispatch('fetchRegionsByBrandIdAndCountryId',
                    {
                        countryId: this.dealership.country_id,
                        brandId: brandId
                    })
            },

            onCreateRelation(){
                if(this.$refs.brandDealershipForm.validate()){
                    let brandDealershipFrom = new FormData()
                    let URL =''

                    // Check update or create
                    if(this.selectedBrand.id){
                        brandDealershipFrom.append('_method', 'put')
                        URL = `/api/brandDealerships/${this.selectedBrand.id}`
                    }else{
                        URL = `/api/dealerships/${this.dealership.id}/brands`
                    }

                    brandDealershipFrom.append('dealership_id', this.dealership.id)
                    brandDealershipFrom.append('brand_id', this.selectedBrand.brand_id)
                    brandDealershipFrom.append('region_id', this.selectedBrand.region_id)
                    axios.post(URL, brandDealershipFrom).then((response)=>{
                        if(response.data.success){
                            this.$store.commit('setInitializeBrands')
                        }
                    })
                }
            },

            reset () {
                this.$refs.brandDealershipForm.reset()
            },
            resetValidation () {
                this.$refs.brandDealershipForm.resetValidation()
            },

            onFetchBrands(){
                this.reset()
                this.resetValidation()
                this.$store.commit('setInitializeBrands')
            }
        }
    }
</script>
