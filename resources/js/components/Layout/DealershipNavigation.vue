<template>
    <v-navigation-drawer
            fixed
            clipped
            v-model="drawer"
            app
            width="300"
    >

        <v-layout row wrap align-content-center>
            <v-flex xs12>
                <v-img 
                    src="/images/rhino-events-logo.png" 
                    aspect-ratio="1"
                    max-width="70%"
                    max-height="30px"
                    contain
                    class="py-5 mx-auto">
                </v-img>
            </v-flex>

            <v-flex xs12 sm8>
                <h2 :style="{color: themeOption.adminNavIconColor}">{{ title }}</h2>
            </v-flex>

            <v-flex xs12 sm4>
                <v-layout row>
                    <v-autocomplete
                        :placeholder="trans.select_a_language"
                        prepend-icon="search"
                        :items="languages"
                        item-text="name"
                        @change="selectedLanguage"
                        item-value="id"
                        return-object
                    ></v-autocomplete>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-divider class="my-2"></v-divider>

        <v-list>
            <v-list-tile @click="$router.push({name: 'dashboard'})">
                <v-list-tile-action>
                    <v-icon :color="themeOption.dealershipAdminNavColor">home</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>{{ trans.dashboard }}</v-list-tile-title>
            </v-list-tile>

            <div v-for="(navGroup, i) in navs" :key="i">
                <h2>{{ navGroup.text }}</h2>

                <template v-for="(nav, i) in navGroup.subGroups">
                    <v-list-tile
                        :key="i"
                        v-if="onCheckAccessLevel(nav)"
                        @click="onPageChange(nav)"
                    >
                        <v-list-tile-action>
                            <v-icon v-text="nav.icon" :color="themeOption.dealershipAdminNavColor"></v-icon>
                        </v-list-tile-action>

                        <v-list-tile-title v-text="nav.text"></v-list-tile-title>
                    </v-list-tile>

                    <v-divider v-if="nav.divider"></v-divider>
                </template>
            </div>

            <v-list-tile @click="onLogout">
                <v-list-tile-action>
                    <v-icon :color="themeOption.dealershipAdminNavColor">power_settings_new
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-title>{{ trans.logOut }}</v-list-tile-title>
            </v-list-tile>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        computed: {
            ...mapGetters({
                themeOption: 'getThemeOption',
                trans: 'getFields',
                languages: 'getLanguages',
                openNavigation: 'getDealershipIsNavigationOpen',
                navs: 'getDealershipNavigation',
                authUser: 'getAuthUser',
                title: 'getNavTitle'
            })
        },

        data() {
            return {
                drawer: true
            }
        },
        created() {
            this.$store.commit('setDealershipNavigation', this.trans) // set dealership navigation
        },

        watch:{
            openNavigation(){
                this.drawer = this.openNavigation
            }
        },

        methods: {
            async onPageChange(item) {
                if(item.link === this.$route.name){
                    return
                }else{
                    this.$router.push({name: item.link});
                }
            },

            /**
             * Language change render all translation
             * @param value
             */
            selectedLanguage(value) {
                this.$store.commit('setSelectedLanguage', value)
                this.$store.dispatch('fetchSettingFields', {languageId: value.id})
            },

            onLogout() {
                axios.post('/logout').then((response) => {

                    if(response.data.success){
                        // reset auth user
                        this.$store.commit('setAuthUser', {})
                        window.location = '/admin'
                    }
                })
            },

            onCheckAccessLevel(nav){
                let accessLevel = [...nav.access]
                const authUserRole = this.authUser.level
                const canAccess = _.findIndex(accessLevel, function(level){
                    return level === authUserRole
                })

                if(canAccess === -1){
                    return false
                }else{
                    return true
                }
            }
        }
    }
</script>
