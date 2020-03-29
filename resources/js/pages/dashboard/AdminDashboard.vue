<template>
    <v-container grid-list-md>
        <v-layout row wrap class=" d-none d-md-block">
            <v-flex xs12 class="pa-0">
                <v-card-text class="pa-0 mb-4 text-xs-center">
                    <h2>{{`${trans.dashboard}`|trans}}</h2>
                </v-card-text>
            </v-flex>

            <v-flex xs6 class="pa-0">
                <v-card-text class="px-0 text-xs-center">
                    <h4>{{trans.event |trans}}</h4>
                </v-card-text>
            </v-flex>
            <v-flex xs6 class="pa-0">
                <v-card-text class="px-0 text-xs-center">
                    <h4>{{trans.reporting |trans}}</h4>
                </v-card-text>
            </v-flex>
        </v-layout>

        <v-container pt-0>
            <v-layout row wrap justify-space-around>
                <v-flex xs12 md5>
                    <v-layout column mb-4>
                            <v-layout row justify-space-around>
                                <v-flex xs12>
                                    <v-autocomplete
                                        v-model="selectedUser"
                                        :items="users"
                                        :loading="isLoading"
                                        :color="themeOption.primaryColor"
                                        append-icon="search"
                                        :search-input.sync="search"
                                        clearable
                                        outline
                                        small
                                        hide-details
                                        hide-selected
                                        item-text="email"
                                        item-value="id"
                                        :label="`${trans.searchUserByEmail}`"
                                        open-on-clear
                                        return-object
                                        class="search-guests"
                                        @change="onSelectUser()"
                                    >
                                        <template v-slot:no-data>
                                            <v-list-tile>
                                                <v-list-tile-title>
                                                    {{ `${trans.searchUserByEmail}` }}
                                                </v-list-tile-title>
                                            </v-list-tile>
                                        </template>
                                        <template v-slot:selection="{ item, selected }">
                                            <span :selected="selected" v-text="item.name"></span>
                                        </template>
                                        <template v-slot:item="{ item }">
                                            <v-list-tile-avatar
                                                :color="themeOption.primaryColor"
                                                class="headline font-weight-light white--text"
                                            >
                                                {{ item.name.charAt(0) }}
                                            </v-list-tile-avatar>
                                            <v-list-tile-content>
                                                <v-list-tile-title v-html="getNameWithStatus(item)"></v-list-tile-title>
                                                <v-list-tile-sub-title v-text="item.email"></v-list-tile-sub-title>
                                            </v-list-tile-content>
                                            <v-list-tile-action>
                                                <v-icon>mdi-coin</v-icon>
                                            </v-list-tile-action>
                                        </template>
                                    </v-autocomplete>
                                </v-flex>
                            </v-layout>
                    </v-layout>

                    <v-layout column mb-3>
                        <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listUsers'}">
                            <v-layout row justify-space-around>
                                <v-flex align-self-center>
                                    <v-icon color="#000">person</v-icon>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <h3>{{ `${trans.manageUsers}`|trans }}</h3>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <small>{{ `${trans.addEditOrRemoveUser}` |trans }}</small>
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
                                        <h3>{{ `${trans.manageVehicles}` |trans }}</h3>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <small>{{ `${trans.addEditOrRemoveVehicle}` |trans }}</small>
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
                                        <h3>{{ `${trans.manageEvents}` |trans }}</h3>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <small>{{ `${trans.addEditOrRemoveEvents}`|trans }}</small>
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
                                    {{ `${trans.companies}`|trans }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listBrands'}">
                                <v-icon color="#000">access_time</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.brands}`|trans }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listCountries'}">
                                <v-icon color="#000">languages</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.countries}`|trans }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listCompanies'}">
                                <v-icon color="#000">bar_chart</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.regions}`|trans }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listDealershipsGroups'}">
                                <v-icon color="#000">contacts</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.groups}`|trans }}
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6>
                            <v-card class="elevation-12 py-4 text-xs-center" :to="{name: 'listDealerships'}">
                                <v-icon color="#000">contacts</v-icon>
                                <v-card-text class="px-2">
                                    {{ `${trans.dealerships}`|trans }}
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
    import fn from '@/utils/function'

    export default {
        components: {

        },

        data() {
            return {
                selectedUser:{},
                users:[],
                isLoading: false,
                search:''
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
            search(val) {
                if (this.users.length > 0) return
                this.isLoading = true
                // Lazily load input items
                const URL = `/api/users/dropdown?search=${val}`
                axios.get(URL).then((response) => {
                    if (response.data) {
                        this.users = [...response.data.users]
                        this.isLoading = false
                    }
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            }

        },

        created() {
            this.$store.commit( 'setHeaderTitle', `${this.trans.dashboard}`)
            this.$store.commit( 'setNavTitle', `${this.trans.dashboard}`)
        },

        methods: {

            onSelectUser(){
                if(typeof this.selectedUser === "undefined"){
                    return
                }

                this.$router.push({
                    name: 'editUsers',
                    params: {
                        id: this.selectedUser.id
                    }
                })
            },

            getNameWithStatus(guest){
                return fn.getGuestNameWithStatus(guest, this.trans)
            }
        }
    }

</script>
