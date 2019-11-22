<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        {{ trans.create_dealerships }}
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

        <v-layout>
            <v-flex xs12>
                <v-card>
                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex xs12 pa-2>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    :label="trans.name_of_dealership"
                                    v-model="dealership.name"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>

                        <v-layout row wrap>
                            <v-flex xs12 sm6 pa-2>
                                <v-select
                                    :color="themeOption.inputColor"
                                    :label="trans.select_country"
                                    v-model="dealership.country"
                                >
                                </v-select>
                            </v-flex>

                            <v-flex xs12 sm6 pa-2>
                                <v-select
                                    :color="themeOption.inputColor"
                                    :label="trans.select_region"
                                    v-model="dealership.region"
                                >
                                </v-select>
                            </v-flex>
                        </v-layout>

                        <v-layout row wrap>
                            <v-flex xs12 sm6 pa-2>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    :label="trans.latitude"
                                    v-model="dealership.latitude">
                                </v-text-field>
                            </v-flex>

                            <v-flex xs12 sm6 pa-2>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    v-model="dealership.longitude"
                                    :label="trans.longitude">
                                </v-text-field>
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
                                        key="dealershipImage"
                                        ripple
                                    >
                                        {{ trans.dealership_banner}}

                                    </v-tab>

                                    <v-tab
                                        key="address"
                                        ripple
                                    >
                                        {{ trans.address}}

                                    </v-tab>

                                    <v-tab
                                        key="times"
                                        ripple
                                    >
                                        {{ trans.opening_times}}

                                    </v-tab>

                                    <v-tab-item
                                        key="dealershipImage"
                                    >
                                        <v-layout row wrap pt-3>
                                            <ImageUpload></ImageUpload>
                                        </v-layout>
                                    </v-tab-item>

                                    <v-tab-item
                                        key="address"
                                    >
                                        <v-layout row wrap pt-3>
                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_1"
                                                    v-model="dealership.addressLineOne">
                                                </v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_2"
                                                    v-model="dealership.addressLineTwo"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout row wrap pt-3>
                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_3"
                                                    v-model="dealership.addressLineThree"
                                                >
                                                </v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_4"
                                                    v-model="dealership.addressLineFour"
                                                >
                                                </v-text-field>
                                            </v-flex>
                                        </v-layout>

                                        <v-layout row wrap>
                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_5"
                                                    v-model="dealership.addressLineFive"
                                                >
                                                </v-text-field>
                                            </v-flex>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-text-field
                                                    :color="themeOption.inputColor"
                                                    :label="trans.address_line_6"
                                                    v-model="dealership.addressLineSix"
                                                >
                                                </v-text-field>
                                            </v-flex>
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
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions class="pa-3">
                        <v-spacer></v-spacer>
                        <v-btn
                            :class="themeOption.buttonSuccess"
                            small
                            @click="updateCountry()"
                        >
                            {{ trans.create_dealerships }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import TimePicker from "../../components/TimePicker";
    import ImageUpload from "../../components/ImageUpload";

    export default {
        components:{
            TimePicker,
            ImageUpload
        },

        data() {
            return {

                dealership:{},
                times:{},
                active: null,
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                headers: 'getCountriesListHeader',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption'
            })
        }),

        watch:{
          dealership(){
              console.log('update dealership', this.dealership);
          }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                const Id = this.$route.params.id;
                this.$store.dispatch('fetchCountry', {id: Id})
            },

            updateTimes(times){
                console.log('time is: ', times);
            }
        }
    }
</script>
