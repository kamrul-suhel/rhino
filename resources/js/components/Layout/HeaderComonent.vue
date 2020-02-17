<template>
    <div>
        <v-layout
            align-center
            justify-space-between
            row
            wrap
            fill-height
            class="header"
            pa-5
            :style="{height : `${themeOption.adminHeaderHeight}px`}">
            <v-flex xs12 sm4 v-if="checkLevel()">

            </v-flex>

            <v-flex xs12 :sm4="authUser.level === 'dealership'">
                <div class="text-xs-center">
                    <h2>{{ title }}</h2>
                </div>
            </v-flex>

            <v-flex xs12 sm4 v-if="authUser.level === 'dealership'">
                <v-spacer></v-spacer>
                <v-layout row>
                    <v-autocomplete
                        dark
                        :color="themeOption.primaryColor"
                        :placeholder="trans.select_a_language"
                        :prepend-icon="`flag-icon-${selectedLanguage.code2}`"
                        :items="languages"
                        item-text="name"
                        item-value="id"
                        @change="selectedLanguage"
                        return-object
                    ></v-autocomplete>
                </v-layout>
            </v-flex>
        </v-layout>

        <dealership-toolbar
            v-if="authUser.level === 'dealership'">
        </dealership-toolbar>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import DealershipToolbar from '@/components/DealershipToolbar'

    export default {
        components: {
            DealershipToolbar
        },
        data() {
            return {}
        },

        watch: {},

        computed: {
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                isLogin: 'getIsLogin',
                title: 'getHeaderTitle',
                authUser: 'getAuthUser',
            })
        },

        created() {
        },

        methods: {
            onNavigationToggle() {
                this.$store.commit('setIsNavigationOpen')
            },

            checkLevel(){
                if(this.authUser.level !== 'admin'){
                    return true
                }
                return false
            },

            /**
             * Language change render all translation
             * @param value
             */
            selectedLanguage(value) {
                this.$store.commit('setSelectedLanguage', value)
                this.$store.dispatch('fetchSettingFields', {languageId: value.id})
            }
        }
    }
</script>
