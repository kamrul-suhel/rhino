<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>{{ trans.countries }}</v-toolbar-title>
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
            ref="countryForm"
            v-model="valid"
            lazy-validation>        
            <v-layout row wrap>
                <v-flex xs12>
                    <v-card>
                        <v-card-title
                            primary-title
                        >
                            <h3 :class="themeOption.textHeadingColor+'--text'">
                                {{ trans.create_country }}
                            </h3>
                        </v-card-title>

                        <v-divider></v-divider>

                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 sm6 wrap>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="trans.name"
                                        v-model="country.name"
                                        :rules="[v => !!v ||  `${trans.country} ${trans.name} ${trans.is_required}` ]"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="trans.code"
                                        v-model="country.code"
                                        :rules="[v => !!v || `${trans.country} ${trans.code} ${trans.is_required}`]"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6>
                                    <v-switch
                                        :color="themeOption.inputColor"
                                        :label="trans.status"
                                        v-model="country.status"
                                        :true-value="1"
                                        :false-value="0"
                                    ></v-switch>
                                </v-flex>

                                <v-flex xs12 sm6>
                                    <v-select
                                        :items="seatingPosition"
                                        :color="themeOption.inputColor"
                                        :label="trans.seating_position"
                                        v-model="country.seating_position"
                                        :rules="[v => !!v ||  `${trans.seating_positions} ${trans.is_required}`]"
                                    ></v-select>
                                </v-flex>
                            </v-layout>

                        </v-card-text>

                        <v-divider></v-divider>


                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>

                            <v-btn
                                :class="themeOption.buttonSuccess"
                                small
                                @click="createCountry()"
                            >
                                {{ trans.create }}
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
    import country from "../../store/modules/country";

    export default {

        data() {
            return {
                valid: true,
                active: null,
                seatingPosition:[],
                country: {
                    status: 1
                }
            }

        },

        watch:{
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        }),

        created() {
            this.initialize()
            const position = [
                {
                    text :this.trans.left,
                    value: 'left'
                },
                {
                    text: this.trans.right,
                    value: 'right'
                }
            ]
            this.seatingPosition = position
        },

        methods: {
            initialize() {
                
            },

            createCountry(){

                // const selectedCountry = this.selectedCountry
                // const ID = selectedCountry.id

                if(this.$refs.countryForm.validate()){
                    let countryForm = new FormData()

                    // Set form object for Country
                    _.forOwn(this.country, (value, key)=>{
                        countryForm.append(key, value)
                    });

                    
                    const URL = `/api/countries`
                    axios.post(URL, countryForm).then((response)=>{
                        if(response.data){
                            console.log(response.data);
                            // Show success message
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.trans.successfully_updated}`
                            })
                            // reset selectedCountry in store
                            // this.$store.commit('setSelectedCountry', {})

                            // this.$router.push({name: 'listCountries'});
                        }
                    });
                } else {
                    console.log('Nahhh');
                }

            },
        }
    }
</script>
