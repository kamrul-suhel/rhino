<template>
    <v-container grid-list-md class="dashboard">
        <v-layout row wrap class="mb-5">
            <v-flex xs12 class="pa-0 text-xs-center">
                <h2>{{`${trans.dashboard}`.toUpperCase()|trans}}</h2>
                <h2><v-btn @click="onEmailSend()">Send mail Test</v-btn></h2>
            </v-flex>
        </v-layout>

        <v-container pt-0>
            <v-layout row wrap justify-space-around>
                <v-flex xs12 md5>
                    <v-layout row wrap mb-4>
                        <v-flex xs12 class="text-xs-center">
                            <span class="title">{{trans.events}}</span>
                        </v-flex>

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
                                :placeholder="`${trans.searchUserByEmail}`"
                                open-on-clear
                                return-object
                                class="search-user"
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

                    <v-layout column mb-3>
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                :to="{name: 'listUsers'}">
                            <v-layout row align-center>
                                <v-flex>
                                    <v-img aspect-ratio="2.0"
                                           contain
                                           src="/images/icons/book_a_guest.jpg"/>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <span class="title">{{ `${trans.manageUsers}`|trans }}</span>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <span class="body-2">{{ `${trans.addEditOrRemoveUser}` |trans }}</span>
                                    </v-card-text>
                                </v-flex>

                                <v-flex align-self-center>
                                    <v-icon large>keyboard_arrow_right</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-layout>

                    <v-layout column mb-3>
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                :to="{name: 'listVehicles'}">
                            <v-layout row justify-space-around>
                                <v-flex align-self-center>
                                    <v-img aspect-ratio="2.0"
                                           contain
                                           src="/images/icons/book_a_guest.jpg"/>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <span class="title">{{ `${trans.manageVehicles}` |trans }}</span>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <span class="body-2">{{ `${trans.addEditOrRemoveVehicle}` |trans }}</span>
                                    </v-card-text>
                                </v-flex>

                                <v-flex align-self-center>
                                    <v-icon large>keyboard_arrow_right</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-layout>

                    <v-layout column mb-3>
                        <v-card class="elevation-8 py-4 text-xs-center rounded-10"
                                :to="{name: 'listEvents'}">
                            <v-layout row justify-space-around>
                                <v-flex align-self-center>
                                    <v-img aspect-ratio="2.0"
                                           contain
                                           src="/images/icons/book_a_guest.jpg"/>
                                </v-flex>

                                <v-flex>
                                    <v-card-title text-sm-left class="pa-0">
                                        <span class="title">{{ `${trans.manageEvents}` |trans }}</span>
                                    </v-card-title>
                                    <v-card-text class="text-sm-left pa-0">
                                        <span class="body-2">{{ `${trans.addEditOrRemoveEvents}`|trans }}</span>
                                    </v-card-text>
                                </v-flex>

                                <v-flex align-self-center>
                                    <v-icon large>keyboard_arrow_right</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-card>
                    </v-layout>
                </v-flex>

                <v-flex xs12 md5 class="py-0">
                    <v-layout row wrap>
                        <v-flex xs6 pa-2>
                            <v-card class="elevation-8 pa-4 rounded-10 text-xs-center " :to="{name: 'listCompanies'}">
                                <v-icon large color="#000">business</v-icon>
                                <v-card-text class="px-2">
                                    <span class="title">{{ `${trans.companies}`|trans }}</span>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6 pa-2>
                            <v-card class="elevation-8 pa-4 rounded-10 text-xs-center" :to="{name: 'listBrands'}">
                                <v-icon large color="#000">access_time</v-icon>
                                <v-card-text class="px-2">
                                    <span class="title">{{ `${trans.brands}`|trans }}</span>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6 pa-2>
                            <v-card class="elevation-8 rounded-10 pa-4 text-xs-center" :to="{name: 'listCountries'}">
                                <v-img width="36"
                                       height="36"
                                       class="mx-auto"
                                       contain
                                       src="/images/icons/country.jpg"/>
                                <v-card-text class="px-2">
                                    <span class="title">{{ `${trans.countries}`|trans }}</span>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6 pa-2>
                            <v-card class="elevation-8 pa-4 rounded-10 text-xs-center" :to="{name: 'listCompanies'}">
                                <v-icon large color="#000">bar_chart</v-icon>
                                <v-card-text class="px-2">
                                    <span class="title">{{ `${trans.regions}`|trans }}</span>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6 pa-2>
                            <v-card class="elevation-8 pa-4 rounded-10 text-xs-center" :to="{name: 'listDealershipsGroups'}">
                                <v-icon large color="#000">contacts</v-icon>
                                <v-card-text class="px-2">
                                    <span class="title">{{ `${trans.groups}`|trans }}</span>
                                </v-card-text>
                            </v-card>
                        </v-flex>

                        <v-flex xs6 pa-2>
                            <v-card class="elevation-8 rounded-10 pa-4 text-xs-center" :to="{name: 'listDealerships'}">
                                <v-icon large color="#000">contacts</v-icon>
                                <v-card-text class="px-2">
                                    <span class="title">{{ `${trans.dealerships}`|trans }}</span>
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
            },

            onEmailSend(){
                axios.get('/admin/sendMail').then((response) => {
                    console.log('response', response)
                })
            }
        }
    }

</script>
