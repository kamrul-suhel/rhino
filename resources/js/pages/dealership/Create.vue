<template>
    <v-container pa-0>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">tag_faces
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.create} ${trans.dealership}` }}
                </div>
            </div>
            <div class="r-tab-content" :class="[showForm ? 'open' : '']">
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
                                            :rules="[v => !!v || `${trans.name} ${trans.is_required}`]"
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
                                </v-layout>

                                <v-layout row wrap>
                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.address_line} 2`"
                                            v-model="dealership.address_line_2"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.address_line} 3`"
                                            v-model="dealership.address_line_3"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.address_line} 4`"
                                            v-model="dealership.address_line_4"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.address_line} 5`"
                                            v-model="dealership.address_line_5"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>
                                </v-layout>


                                <v-layout row wrap>
                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.address_line} 6`"
                                            v-model="dealership.address_line_6"
                                            box solo flat
                                        >
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
                                            box solo flat
                                        >
                                        </v-select>
                                    </v-flex>
                                    <v-flex xs12 sm3 pa-2>
                                        <v-select
                                            :items="groups"
                                            item-text="name"
                                            item-value="id"
                                            :color="themeOption.inputColor"
                                            :label="`${trans.select_a} ${trans.group}`"
                                            v-model="dealership.group_id"
                                            box solo flat>
                                        </v-select>
                                    </v-flex>
                                </v-layout>

                                <v-layout row wrap>

                                    <v-flex xs12 sm6 pa-2>
                                        <v-switch
                                            :label="trans.status"
                                            :color="themeOption.switchOnColor"
                                            v-model="dealership.status"
                                            :true-value="1"
                                            :false-value="0"
                                            >
                                        </v-switch>
                                    </v-flex>
                                </v-layout>

                                <v-divider class="mt-2 mb-2"></v-divider>

                                <v-layout column wrap>
                                    <v-tabs
                                        v-model="active"
                                        dark
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
                                            {{ `${trans.dealership} ${trans.banner}`}}

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
                                                

                                                
                                            </v-layout>

                                            <v-layout row wrap pt-3>
                                                
                                            </v-layout>

                                            <v-layout row wrap>
                                                

                                                
                                            </v-layout>
                                        </v-tab-item>

                                        <v-tab-item
                                            key="dealershipImage"
                                        >
                                            <v-layout row wrap pt-3>
                                                <ImageUpload :preview="true"
                                                            model="dealership"
                                                ></ImageUpload>
                                            </v-layout>
                                        </v-tab-item>

                                        <v-tab-item
                                            key="times">
                                            <TimePicker :dealership="times"
                                                        v-on:sendTimes="updateTimes">
                                            </TimePicker>
                                        </v-tab-item>
                                    </v-tabs>
                                </v-layout>
                                <v-layout class="pa-3">
                                    <v-btn
                                        :color="themeOption.buttonDangerColor"
                                        class="rounded-btn"
                                        dark
                                        small
                                        @click="onCreateDealership()"
                                    >
                                        {{ `${trans.submit}` }}
                                    </v-btn>
                                </v-layout>
                        </v-flex>
                    </v-layout>
                </v-form>
            </div>
        </div>
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
                dealership: {
                    country_id: 48,
                    status: 1
                },
                times: {},
                active: null,
                model: null,
                showForm: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                countries: 'getCountries',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                regions: 'getRegions',
                groups: 'getGroups'
            })
        }),

        watch: {
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchGroups', {dropDown: true})
            },

            updateTimes(times) {
                console.log('time is: ', times);
            },

            onCreateDealership(){
                if(this.$refs.dealershipForm.validate()){
                    let dealershipForm = new FormData()

                    // Set form object for dealership
                    _.forOwn(this.dealership, (value, key)=>{
                        if(key === 'status'){
                            if(value === 'true'){
                                dealershipForm.append('status', 1)
                            }else{
                                dealershipForm.append('status', 0)
                            }
                        }else{
                            dealershipForm.append(key, value)
                        }
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key)=>{
                        dealershipForm.append(key, value)
                    })

                    // send form data to save
                    axios.post('/api/dealerships', dealershipForm).then((response)=>{
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.dealership.name}  ${this.trans.successfully_created}`
                            })
                        }
                    })
                }
            },

            toggleForm() {
                this.showForm = !this.showForm

            }
        }
    }
</script>
