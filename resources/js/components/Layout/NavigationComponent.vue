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

            <v-flex xs12 sm8 class="px-4">
                <h2 :style="{color: themeOption.adminNavIconColor}">{{ title }}</h2>
            </v-flex>

            <v-flex xs12 sm4>
                <v-layout row>
                    <v-autocomplete
                        :placeholder="trans.selectALanguage"
                        :color="themeOption.primaryColor"
                        :items="languages"
                        item-text="code2"
                        @change="onSelectLanguage"
                        item-value="id"
                        v-model="languageId"
                        return-object
                    >
                        <template v-slot:selection="data">
                            {{ `${data.item.code2}` }}
                        </template>

                        <template v-slot:item="data">
                            <v-list-tile-avatar>
                                <flag :iso="data.item.code2"></flag>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                            </v-list-tile-content>
                        </template>
                    </v-autocomplete>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-divider class="my-2"></v-divider>

        <v-list>
            <v-list-tile @click="$router.push({name: 'dashboard'})">
                <v-list-tile-action>
                    <v-icon :color="themeOption.adminNavIconColor">home</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>{{ trans.dashboard |trans }}</v-list-tile-title>
            </v-list-tile>

            <template v-for="(nav, i) in navs">
                <v-list-tile
                    :key="i"
                    v-if="onCheckAccessLevel(nav)"
                    @click="onPageChange(nav)"
                >
                    <v-list-tile-action>
                        <v-icon v-text="nav.icon" :color="themeOption.adminNavIconColor"></v-icon>
                    </v-list-tile-action>

                    <v-list-tile-title >{{nav.text|trans}}</v-list-tile-title>

                </v-list-tile>
                <v-divider v-if="nav.divider" class="my-2"></v-divider>
            </template>

            <v-list-tile @click="onLogout">
                <v-list-tile-action>
                    <v-icon :color="themeOption.adminNavIconColor">power_settings_new
                    </v-icon>
                </v-list-tile-action>

                <v-list-tile-title>{{ trans.logOut | trans }}</v-list-tile-title>
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
                openNavigation: 'getIsNavigationOpen',
                navs: 'getNavigationBar',
                authUser: 'getAuthUser',
                title: 'getNavTitle',
                selectedLanguage: 'getSelectedLanguage'
            })
        },

        data() {
            return {
                drawer: true,
                languageId: null
            }
        },

        watch:{
            openNavigation(){
                this.drawer = this.openNavigation
            },

            trans(){
                this.$store.commit('setNavigation', this.trans)
            },

            selectedLanguage(){
                this.languageId = this.selectedLanguage.id
            }
        },

        created() {
            this.$store.dispatch('dispatchNavigation', this.trans) // Dispatch to navigation store
            this.languageId = this.selectedLanguage.id
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
            onSelectLanguage(value) {
                this.$store.commit('setSelectedLanguage', value)
                this.$store.dispatch('fetchSettingFields', {languageId: value.id})
            },

            onLogout() {
                axios.post('/logout').then((response) => {

                    if(response.data.success){
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
