<template>
    <v-form ref="brandDealershipForm"
            v-model="valid"
            lazy-validation
    >
        <v-card>
            <v-card-title>
                Make relation between brand
            </v-card-title>

            <v-card-text>

                <v-layout row wrap>
                    <v-flex xs12>
                        <v-select :label="trans.select_a_brand"
                                  :color="themeOption.inputColor"
                                  item-text="name"
                                  :rules="[v => !!v || trans.select_a_brand]"
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
                                  :rules="[v => !!v || trans.select_a_region]"
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
                       :color="themeOption.buttonSecondaryColor"
                >
                    {{ trans.cancel }}
                </v-btn>

                <v-btn small
                       @click="onCreateRelation"
                       :color="themeOption.buttonPrimaryColor"
                >{{ trans.add_brand }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                valid:true
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown',
                dealership: 'getSelectedDealership',
                regions: 'getRegions',
                selectedBrand: 'getSelectedDealershipBrand'
            })
        },

        watch: {},

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
                    brandDealershipFrom.append('dealership_id', this.dealership.id)
                    brandDealershipFrom.append('brand_id', this.selectedBrand.brand_id)
                    brandDealershipFrom.append('region_id', this.selectedBrand.region_id)

                    const URL = `/api/dealerships/${this.dealership.id}/brands`
                    axios.post(URL, brandDealershipFrom).then((response)=>{
                        if(response.data.success){
                            this.$store.dispatch('fetchBrandsByDealershipId', {dealershipId: this.dealership.id})
                        }
                    })

                    console.log(this.selectedBrand)
                    console.log('send data into ')
                }
            },

            reset () {
                this.$refs.brandDealershipForm.reset()
            },
            resetValidation () {
                this.$refs.brandDealershipForm.resetValidation()
            }
        }
    }
</script>
