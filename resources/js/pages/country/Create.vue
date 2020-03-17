<template>
    <v-container pa-0>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">language
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.addNewCountry}` }}
                </div>
            </div>
            <div class="r-tab-content" :class="[showForm ? 'open' : '']">

                <v-form
                    ref="countryForm"
                    v-model="valid"
                    lazy-validation>

                    <v-layout row wrap>
                        <v-flex xs12 sm3 wrap class="mr-2">
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="trans.name"
                                v-model="country.name"
                                :rules="[v => !!v ||  `${trans.countryNameIsRequired}` ]"
                                solo box flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 class="mr-2">
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="trans.code"
                                v-model="country.code"
                                :rules="[v => !!v || `${trans.countryCodeIsRequired}`]"
                                solo box flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 class="mr-2">
                            <v-select
                                :items="seatingPosition"
                                :color="themeOption.inputColor"
                                :label="trans.seatingPosition"
                                v-model="country.seating_position"
                                :rules="[v => !!v ||  `${trans.seatingPositionIsRequired}`]"
                                solo box flat
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 sm3 class="mr-2">
                            <v-switch
                                :color="themeOption.switchOnColor"
                                :label="trans.status"
                                v-model="country.status"
                                :true-value="1"
                                :false-value="0"
                            ></v-switch>
                        </v-flex>
                        <v-flex xs12 sm3 class="pa-3">
                            <v-btn
                                :color="themeOption.buttonDangerColor"
                                class="rounded-btn"
                                small
                                dark
                                @click="createCountry()"
                            >
                                {{ trans.create }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-form>
            </div>
        </div>
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
                },
                showForm: false,
            }

        },

        watch:{
            updateComponent() {
                this.initialize()
            }
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
                            // Show success message
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.trans.successfullyUpdated}`
                            })
                            // reset selectedCountry in store
                            // this.$store.commit('setSelectedCountry', {})


                            // push country to store to update list
                            this.$store.commit('setUpdateComponent')
                        }
                    });
                } else {

                }

            },

            toggleForm() {
                this.showForm = !this.showForm
            }
        }
    }
</script>
