<template>
    <div class="rhino-admin-header">
        <v-layout
            align-center
            justify-space-between
            row
            wrap
            fill-height
            class="header"
            pa-5
            :style="{height : `${themeOption.adminHeaderHeight}px`}">

<!--            <v-flex xs1 class="menu-toggle hidden-lg" @click="onToggleNav">-->
<!--                <v-icon class="text-white">menu</v-icon>-->
<!--            </v-flex>-->

            <div
                    :sm4="authUser.level === 'dealership'"
                    v-if="authUser.level === 'dealership'">
                <div class="brands-carousel">
                    <v-carousel height="80"
                                hide-controls
                                hide-delimiters>
                        <v-carousel-item
                            lazy
                            v-for="(brand,i) in brands"
                            :key="brand.id"
                            :src="brand.logo"
                        ></v-carousel-item>
                    </v-carousel>

                    <div :style="{backgroundColor: getBadgeBackgroundColor(), }"
                         class="badge">
                        {{ brands.length }}
                    </div>
                </div>
            </div>

            <div>
                <div class="text-xs-center">
                    <h2>{{ title }}</h2>
                </div>
            </div>

            <div>
                <v-spacer></v-spacer>
                <v-layout row>
                    <v-autocomplete
                        dark
                        class="language-picker icon-left"
                        :color="themeOption.primaryColor"
                        :placeholder="trans.select_a_language"
                        :prepend-icon="`flag-icon-${selectedLanguage.code2.toLowerCase()}`"
                        :items="languages"
                        item-text="name"
                        item-value="id"
                        v-model="selectedLanguageId"
                        @change="onSelectLanguage"
                        return-object
                    ></v-autocomplete>
                </v-layout>
            </div>
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
                console.log('selected language: ', this.selectedLanguage)
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
                    this.authUser.level === 'dealership' ||
                    this.authUser.level === 'sales_executive'
                ){
                    return true
                }
                return false
            },

            getBadgeBackgroundColor(){
                let color = '#444'
                if(this.brands.length > 0){
                    color = this.brands[0].colour
                }
                return color
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
