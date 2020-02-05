<template>
    <v-container pa-0>
        <v-form
            row wrap
            ref="dealershipForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-layout row wrap>
                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :rules=" [v => !!v || `${trans.name} ${trans.is_required}`]"
                                :color="themeOption.inputColor"
                                :label="`${trans.name}`"
                                v-model="dealership.name" 
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                type="number"
                                :color="themeOption.inputColor"
                                :label="trans.latitude"
                                v-model="dealership.latitude"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                type="number"
                                :color="themeOption.inputColor"
                                v-model="dealership.longitude"
                                :label="trans.longitude"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :rules="[v => !!v || `${trans.address} ${trans.is_required}`]"
                                :label="`${trans.address_line} 1`"
                                v-model="dealership.address_line_1"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.address_line} 2`"
                                v-model="dealership.address_line_2"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.address_line} 3`"
                                v-model="dealership.address_line_3"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.address_line} 4`"
                                v-model="dealership.address_line_4"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.address_line} 5`"
                                v-model="dealership.address_line_5"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.address_line} 6`"
                                v-model="dealership.address_line_6"
                                box solo flat>
                            </v-text-field>
                        </v-flex>
                        
                        <v-flex xs12 sm3 pa-2>
                            <v-select
                                :items="countries"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || `${trans.select_a} ${trans.country}`]"
                                :color="themeOption.inputColor"
                                :label="trans.select_country"
                                v-model="dealership.country_id"
                                box solo flat>
                            </v-select>
                        </v-flex>
                    </v-layout>


                    <v-layout column wrap>
                        <v-tabs
                            v-model="active"
                            :color="themeOption.tabColor"
                            :slider-color="themeOption.tabSliderColor"
                        >

                            <v-tab
                                key="users"
                                ripple
                            >
                                {{ trans.users }}
                            </v-tab>

                            <v-tab
                                key="brands"
                                ripple
                            >
                                {{ trans.brands }}
                            </v-tab>

                            <v-tab
                                key="times"
                                ripple
                            >
                                {{ trans.opening_times}}
                            </v-tab>

                            <v-tab-item
                                key="users"
                            >
                                <v-layout row wrap pt-3>
                                    <dealership-users></dealership-users>

                                    
                                    <v-flex xs12 sm6 pa-2>
                                        <v-btn
                                            :color="themeOption.buttonSuccess"
                                            small
                                            @click="$router.push({name: 'createDealershipUser', params: {dealershipId: dealership.id}})"
                                        >
                                        
                                            {{ trans.add }} {{ trans.user }}
                                        </v-btn>
                                    </v-flex>

                                </v-layout>
                            </v-tab-item>

                            <v-tab-item
                                key="brands"
                            >
                                <Brands v-if="dealership.id"
                                        :dealershipId="dealership.id">
                                </Brands>
                            </v-tab-item>


                            <v-tab-item
                                key="times">
                                <TimePicker :dealership="dealership"
                                            v-on:sendTimes="updateTimes">
                                </TimePicker>
                            </v-tab-item>
                        </v-tabs>
                    </v-layout>
                    <v-divider class="py-3"></v-divider>
                    <v-layout>
                        <v-flex>

                            <v-btn
                                dark
                                :loading="themeOption.buttonLoading"
                                :disabled="themeOption.buttonLoading"
                                :color="themeOption.buttonDangerColor"
                                class="rounded-btn"
                                small
                                @click="onUpdateDealership()"
                            >
                                {{  `${trans.update} ${trans.dealership}`  }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import TimePicker from "../../components/TimePicker"
    import ImageUpload from "../../components/ImageUpload"
    import Brands from '../../components/Dealership/Brands'
    import LanguagePicker from '../../components/Language'
    import DealershipUsers from '../../components/Dealership/Users'
    import EventList from '../event/List'

    export default {
        components: {
            TimePicker,
            ImageUpload,
            Brands,
            LanguagePicker,
            DealershipUsers,
            EventList
        },

        data() {
            return {
                valid: true,
                active: null,
                model: null,
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                countries: 'getCountries',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                regions: 'getRegions',
                dealership: 'getSelectedDealership',
                selectedLanguage: 'getSubSelectedLanguage',
            })
        }),

        watch: {
            dealership(value) {
                this.$refs.dealershipForm.resetValidation();
            },

            selectedLanguage(){
                this.$store.dispatch('fetchDealership', {
                        id: this.$route.params.id,
                        edit: true,
                        languageId: this.selectedLanguage.id
                })
            }
        },

        created() {
            this.initialize()
             this.$store.commit( 'setHeaderTitle', `${this.trans.edit} ${this.trans.dealership}` )
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchBrandForDropDown')
                this.$store.dispatch('fetchDealership', {id: this.$route.params.id})
            },

            updateTimes(times) {
            },

            onUpdateDealership(){
                if(this.$refs.dealershipForm.validate()){
                    let dealershipForm = new FormData()

                    // Set form object for dealership
                    _.forOwn(this.dealership, (value, key)=>{
                        if(key === 'group_id'){
                            if(value == 'null'){
                                
                            }else{
                                dealershipForm.append(key, value)
                            }
                        }else{
                            dealershipForm.append(key, value)
                        }
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key)=>{
                        dealershipForm.append(key, value)
                    })

                    // Set language id
                    dealershipForm.append('languageId', this.selectedLanguage.id)

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
                        }
                    }).catch((error)=>{
                    })
                }
            }
        }
    }
</script>
