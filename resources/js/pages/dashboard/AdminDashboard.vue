<template>

    <v-container grid-list-md>
        <v-layout row wrap class=" d-none d-md-block">
            <v-flex xs12 class="pa-0">
                <v-card-text class="pa-0 mb-4 text-xs-center">
                    <h2>{{trans.dashboard}}</h2>
                </v-card-text>
            </v-flex>

            <v-flex xs6 class="pa-0">
                <v-card-text class="px-0 text-xs-center">
                    <h4>{{trans.event}}</h4>
                </v-card-text>
            </v-flex>
            <v-flex xs6 class="pa-0">
                <v-card-text class="px-0 text-xs-center">
                    <h4>{{trans.reporting}}</h4>
                </v-card-text>
            </v-flex>
        </v-layout>

        <v-container pt-0>
            <v-layout row wrap justify-space-around>
                <v-flex xs12 md5>
                    <v-layout column mb-3>
                        <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listUsers'}">
                            <v-layout row justify-space-around>
                                <v-flex align-self-center>
                                    <v-icon color="#000">person</v-icon>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <h3>{{ `${trans.manageUsers}` }}</h3>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <small>{{ `${trans.addEditOrRemoveUser}` }}</small>
                                    </v-card-text>
                                </v-flex>

                                <v-flex align-self-center>
                                    <v-icon>keyboard_arrow_right</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-layout>
                    <v-layout column mb-3>
                        <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listVehicles'}">
                            <v-layout row justify-space-around>
                                <v-flex align-self-center>
                                    <v-icon color="#000">person</v-icon>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <h3>{{ `${trans.manageVehicles}` }}</h3>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <small>{{ `${trans.addEditOrRemoveVehicle}` }}</small>
                                    </v-card-text>
                                </v-flex>

                                <v-flex align-self-center>
                                    <v-icon>keyboard_arrow_right</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-layout>
                    <v-layout column mb-3>
                        <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listEvents'}">
                            <v-layout row justify-space-around>
                                <v-flex align-self-center>
                                    <v-icon color="#000">person</v-icon>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <h3>{{ `${trans.manageEvents}` }}</h3>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <small>{{ `${trans.addEditOrRemoveEvents}` }}</small>
                                    </v-card-text>
                                </v-flex>

                                <v-flex align-self-center>
                                    <v-icon>keyboard_arrow_right</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-layout>
                </v-flex>

                <v-flex xs12 md5 class="py-0">
                    <v-layout row wrap>
                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listCompanies'}">
                                <v-icon color="#000">business</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.companies}` }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listBrands'}">
                                <v-icon color="#000">access_time</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.brands}` }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listCountries'}">
                                <v-icon color="#000">languages</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.countries}` }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listCompanies'}">
                                <v-icon color="#000">bar_chart</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.regions}` }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listDealershipsGroups'}">
                                <v-icon color="#000">contacts</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.groups}` }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listDealerships'}">
                                <v-icon color="#000">contacts</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.dealerships}` }}
                                </v-card-text>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>

        </v-container>

    </v-container>

</template>

<script>

    import {mapGetters} from 'vuex'

    export default {
        components: {

        },

        data() {
            return {

            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
            })
        }),

        watch: {

        },

        created() {
            this.$store.commit( 'setHeaderTitle', `${this.trans.dashboard}`)
            this.$store.commit( 'setNavTitle', `${this.trans.dashboard}`)
        },

        methods: {
        }
    }

</script>
