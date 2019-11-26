<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span :class="themeOption.textHeadingColor+'--text'">{{ trans.edit_dealerships }}</span>
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
            ref="dealershipForm"
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
                                        :color="themeOption.inputColor"
                                        :label="trans.name_of_dealership"
                                        v-model="dealership.name"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="countries"
                                        item-text="name"
                                        :rules="[v => !!v || trans.select_a_country]"
                                        :color="themeOption.inputColor"
                                        :label="trans.select_country"
                                        v-model="dealership.country"
                                        @change="onCountryChange"
                                        return-object
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="regions"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || trans.region_field_is_required]"
                                        :color="themeOption.inputColor"
                                        :label="trans.select_region"
                                        v-model="dealership.region_id"
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        type="number"
                                        :color="themeOption.inputColor"
                                        :label="trans.latitude"
                                        v-model="dealership.latitude">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        type="number"
                                        :color="themeOption.inputColor"
                                        v-model="dealership.longitude"
                                        :label="trans.longitude">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="groups"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || trans.groups_filed_required]"
                                        :color="themeOption.inputColor"
                                        :label="trans.select_groups"
                                        v-model="dealership.group_id"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-switch
                                        :color="themeOption.inputColor"
                                        v-model="dealership.status"
                                        :label="trans.status"
                                    ></v-switch>
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
                                        key="address"
                                        ripple
                                    >
                                        {{ trans.address}}

                                    </v-tab>

                                    <v-tab
                                        key="dealershipImage"
                                        ripple
                                    >
                                        {{ trans.dealership_banner}}

                                    </v-tab>

                                    <v-tab
                                        key="times"
                                        ripple
                                    >
                                        {{ trans.opening_times}}

                                    </v-tab>

                                    <v-tab-item
                                        key="address"
                                    >
                                        <v-layout row wrap pt-3>
                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :rules="[v => !!v || trans.address_is_required]"
                                                    :label="trans.address_line_1"
                                                    v-model="dealership.address_line_1">
                                                </v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_2"
                                                    v-model="dealership.address_line_2"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout row wrap pt-3>
                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_3"
                                                    v-model="dealership.address_line_3"
                                                >
                                                </v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_4"
                                                    v-model="dealership.address_line_4"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout row wrap>
                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_5"
                                                    v-model="dealership.address_line_5"
                                                >
                                                </v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_6"
                                                    v-model="dealership.address_line_6"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>
                                    </v-tab-item>

                                    <v-tab-item
                                        key="dealershipImage"
                                    >
                                        <v-layout row wrap pt-3>
                                            <ImageUpload></ImageUpload>
                                        </v-layout>
                                    </v-tab-item>

                                    <v-tab-item
                                        key="times">
                                        <TimePicker :dealership="dealership"
                                                    v-on:sendTimes="updateTimes">
                                        </TimePicker>
                                    </v-tab-item>
                                </v-tabs>
                            </v-layout>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                :class="themeOption.buttonPrimaryColor"
                                small
                                @click="$router.push({name: 'listDealerships'})"
                            >
                                {{ trans.cancel }}
                            </v-btn>

                            <v-btn
                                :loading="themeOption.buttonLoading"
                                :disabled="themeOption.buttonLoading"
                                :class="themeOption.buttonSuccess"
                                small
                                @click="onUpdateDealership()"
                            >
                                {{ trans.update_dealerships }}
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
    import TimePicker from "../../components/TimePicker";
    import ImageUpload from "../../components/ImageUpload";
    import dealership from "../../store/modules/dealership";

    export default {
        components: {
            TimePicker,
            ImageUpload
        },

        data() {
            return {
                valid: true,
                active: null,
                model: null,

                nameRules: [
                    v => !!v || this.trans.name_is_required
                ]
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                countries: 'getCountries',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                regions: 'getRegions',
                groups: 'getGroups',
                dealership: 'getSelectedDealership'
            })
        }),

        watch: {
            dealership(value) {
                console.log('change :', value)
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchGroups')
                this.$store.dispatch('fetchDealership', {id: this.$route.params.id})
            },

            updateTimes(times) {
                console.log('time is: ', times);
            },

            onUpdateDealership(){

                if(this.$refs.dealershipForm.validate()){
                    this.$store.commit('setThemeOption', {buttonLoading: true})

                    let dealershipForm = new FormData()

                    // Set form object for dealership
                    _.forOwn(this.dealership, (value, key)=>{
                        dealershipForm.append(key, value)
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key)=>{
                        dealershipForm.append(key, value)
                    })

                    dealershipForm.append('_method', 'put')

                    // send form data to save
                    const URL = `/api/dealerships/${this.dealership.id}/update`
                    axios.post(URL, dealershipForm).then((response)=>{
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.dealership.name}  ${this.trans.successfully_updated}`
                            })
                            this.$store.commit('setThemeOption', {buttonLoading: false})
                            // this.$router.push({name: 'listDealerships'})
                        }
                    }).catch((error)=>{
                        this.$store.commit('setThemeOption', {buttonLoading: false})
                    })
                }
            },

            onCountryChange(value){
                let newDealership = {...this.dealership}
                newDealership.region_id = null
                this.$store.commit('setSelectedDealership', newDealership)
                this.$store.dispatch('fetchRegions', {id: value.id})
            }
        }
    }
</script>
