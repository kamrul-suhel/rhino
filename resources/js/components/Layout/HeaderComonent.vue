<template>
    <div>
        <v-layout
            align-center
            row
            wrap
            fill-height
            class="header"
            pa-5
            :style="{height : `${themeOption.adminHeaderHeight}px`}">

<!--            <v-flex xs1 class="menu-toggle hidden-lg" @click="onToggleNav">-->
<!--                <v-icon class="text-white">menu</v-icon>-->
<!--            </v-flex>-->

            <v-flex xs6
                    :sm4="authUser.level === 'dealership'"
                    v-if="authUser.level === 'dealership'">
                <div>
                    <h2>Brands</h2>
                </div>
            </v-flex>

            <v-flex xs6 :sm4="authUser.level === 'dealership'">
                <div class="text-xs-center">
                    <h2>{{ title }}</h2>
                </div>
            </v-flex>

            <v-flex xs6
                    :sm4="authUser.level === 'dealership'"
                    v-if="authUser.level === 'dealership'">
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
                        v-model="selectedLanguageId"
                        @change="onSelectLanguage"
                        return-object
                    ></v-autocomplete>
                </v-layout>
            </v-flex>
        </v-layout>

        <dealership-toolbar
            v-if="checkUserAccess()">
        </dealership-toolbar>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import DealershipToolbar from '@/components/DealershipToolbar'
    import CONST from '@/utils/const'

    export default {
        components: {
            DealershipToolbar
        },
        data() {
            return {
                selectedLanguageId: null
            }
        },

        watch: {
            selectedLanguage(){
                this.selectedLanguageId = this.selectedLanguage.id
            }
        },

        computed: {
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                isLogin: 'getIsLogin',
                title: 'getHeaderTitle',
                authUser: 'getAuthUser',
                selectedLanguage: 'getSelectedLanguage'
            })
        },

        created() {
            this.selectedLanguageId = this.selectedLanguage.id
        },

        methods: {
            onNavigationToggle() {
                this.$store.commit('setIsNavigationOpen')
            },

            checkLevel(){
                if(this.authUser.level === CONST.MANAGER){
                    return true
                }
                return false
            },

            /**
             * Language change render all translation
             * @param value
             */
            onSelectLanguage(value) {
                this.$store.commit('setSelectedLanguage', value)
                this.$store.dispatch('fetchSettingFields', {languageId: value.id})
            },

            onToggleNav(){

                this.$store.commit('setIsNavigationOpen');
            },

            checkUserAccess(){
                if(
                    this.authUser.level === 'dealership' ||
                    this.authUser.level === 'sales_executive'
                ){
                    return true
                }
                return false
            }
        }
    }
</script>

<style scoped>
.menu-toggle {
    cursor: pointer;
}

@media ( min-width: 1263px) {
    .menu-toggle {
        display:none;
    }
}
</style>
