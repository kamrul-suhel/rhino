<template>
    <div class="rhino-admin-header" style="background-image:url('/images/admin-banner.jpg')">
        <div class="toggle-nav" @click="onToggleNav">
            <v-icon class="text-white">menu</v-icon>
        </div>

        <v-layout
            align-center
            justify-space-between
            row
            wrap
            fill-height
            class="header"
            v-if="authUser.level !== 'admin'">

            <v-flex xs12 sm4 >
                <div class="brands-carousel align-center">
                    <v-carousel height="120"
                                hide-controls
                                hide-delimiters
                                >
                        <v-carousel-item
                            lazy
                            v-for="(brand,i) in brands"
                            :key="brand.id"
                            :src="brand.logo === 'null' ? themeOption.brandDefaultImage : brand.logo"

                        ></v-carousel-item>
                    </v-carousel>
                </div>
            </v-flex>

            <v-flex xs12 sm4 my-2>
                <div class="text-xs-center">
                    <h2>{{ title }}</h2>
                </div>
            </v-flex>

            <v-flex xs10 sm4>
                <v-spacer></v-spacer>
                <v-layout row>
                    <v-autocomplete
                        dark
                        class="language-picker icon-left"
                        :color="themeOption.primaryColor"
                        :placeholder="trans.selectALanguage"
                        :prepend-icon="`flag-icon-${selectedLanguage.language_code.toLowerCase()}`"
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

        <v-layout
            align-center
            justify-space-between
            row
            wrap
            fill-height
            class="header"
            v-if="authUser.level === 'admin'"
            >
            <v-flex xs12 class="text-xs-center">
                <h2>{{ title }}</h2>
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
                selectedLanguage: 'getSelectedLanguage',
                brands: 'getEventBrands'
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
                    this.authUser.level === CONST.MANAGER ||
                    this.authUser.level === CONST.SALE_EXECUTIVE ||
                    this.authUser.level === CONST.CALL_HANDLER ||
                    this.authUser.level === CONST.RECEPTIONIST
                ){
                    return true
                }
                return false
            },

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
