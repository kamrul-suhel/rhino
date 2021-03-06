<template>
    <v-container pa-0 grid-list-lg>
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

                    <!-- Language Selector for translations -->
                    <v-layout row wrap justify-end>
                        <v-flex xs12 sm8 v-if="editType">
                            <Language :solo="false"
                                      :flat="false"
                                      :chip="false"
                                      :languageId="selectedCountry.language_id">
                            </Language>
                        </v-flex>
                    </v-layout>
                </v-toolbar>
            </v-flex>
        </v-layout>

        <v-layout row wrap>
            <v-flex xs12>
                <v-card>
                    <v-card-title
                        primary-title
                    >
                        <h3 :class="themeOption.textHeadingColor+'--text'">
                            {{ trans.edit }} {{ selectedCountry.full_name }}
                        </h3>
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex xs12 sm6 wrap>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    :label="trans.name"
                                    v-model="selectedCountry.name"
                                ></v-text-field>
                            </v-flex>


                            <v-flex xs12 sm6>
                                <v-text-field
                                    :color="themeOption.inputColor"
                                    :label="trans.code"
                                    v-model="selectedCountry.country_code"
                                ></v-text-field>
                            </v-flex>

                            <v-flex xs12 sm6>
                                <v-switch
                                    :color="themeOption.switchOnColor"
                                    v-model="selectedCountry.status"
                                    :label="trans.status"
                                ></v-switch>
                            </v-flex>

                            <v-flex xs12 sm6>
                                <v-select
                                    :items="seatingPosition"
                                    :color="themeOption.inputColor"
                                    v-model="selectedCountry.driver_seating_position"
                                    :label="trans.seatingPosition"
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
                            @click="updateCountry()"
                        >
                            {{ trans.update }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import Regions from "@/components/Brand/Regions"
    import FileUpload from '@/components/ImageUpload'
    import Language from "@/components/Language"

    export default {
        components:{
            Regions,
            FileUpload,
            Language
        },

        data() {
            return {
                active: null,
                seatingPosition:[],
                editType: true,
            }

        },

        watch:{
            selectedLanguage(){
                this.initialize()
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                headers: 'getCountriesListHeader',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                selectedLanguage: 'getSubSelectedLanguage'
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
                const Id = this.$route.params.id;
                this.$store.dispatch('fetchCountry', {id: Id,edit:true, languageId: this.selectedLanguage.id})
            },

            updateCountry(){
                const selectedCountry = this.selectedCountry
                const ID = selectedCountry.id
                const URL = `/api/countries/${ID}/update`
                axios.post(URL, selectedCountry).then((response)=>{
                    if(response.data.success){
                        // Show success message
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.selectedCountry.name}  ${this.trans.successfullyUpdated}`
                        })
                        // reset selectedCountry in store
                        // this.$store.commit('setSelectedCountry', {})

                        // this.$router.push({name: 'listCountries'});
                    }
                })
            }
        }
    }
</script>
