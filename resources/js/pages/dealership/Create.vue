<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>{{ trans.create_dealerships }}</v-toolbar-title>
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
                        <v-flex xs12>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="trans.name"
                                v-model="selectedCountry.full_name"
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="trans.capital"
                                v-model="selectedCountry.capital"
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="trans.code"
                                v-model="selectedCountry.iso_3166_2"
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12>
                            <v-switch
                                :color="themeOption.inputColor"
                                v-model="selectedCountry.status"
                                :label="trans.status"
                            ></v-switch>
                        </v-flex>
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

    export default {
        components:{
        },

        data() {
            return {}
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                headers: 'getCountriesListHeader',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption'
            })
        }),

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                const Id = this.$route.params.id;
                this.$store.dispatch('fetchCountry', {id: Id})
            }
        }
    }
</script>
