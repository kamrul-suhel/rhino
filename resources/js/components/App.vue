<template>
    <div id="app" v-if="isInitialize()">
        <v-app
            id="rhino"
            v-if="isAdmin"
        >
            <navigation-component v-if="authUser.level === 'admin'"
            ></navigation-component>

            <DealershipNavigation v-if="checkUserAccess()"
            ></DealershipNavigation>

            <v-content>
                <SnackBar></SnackBar>
                <header-component></header-component>
                <v-container>
                    <router-view></router-view>
                </v-container>
            </v-content>
        </v-app>

        <template v-else>
            <SnackBar></SnackBar>
            <router-view></router-view>
        </template>
    </div>
</template>

<script>
    import HeaderComponent from './Layout/HeaderComonent'
    import NavigationComponent from './Layout/NavigationComponent'
    import DealershipNavigation from "./Layout/DealershipNavigation"
    import CONST from '@/utils/const'
    import SnackBar from "./SnackBar"
    import {mapGetters} from 'vuex'

    export default {
        name: 'App',
        components: {
            NavigationComponent,
            DealershipNavigation,
            HeaderComponent,
            SnackBar
        },

        data: () => ({
            redirectTo: null
        }),

        computed: {
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading',
                isSettingFieldLoaded: 'getIsSettingLoaded',
                themeOption: 'getThemeOption',
                isAdmin: 'getIsAdmin',
                initialize: 'getInitializeApp',
                authUser: 'getAuthUser',
                trans: 'getFields',
                languages: 'getLanguages',
                isSettingLanguageLoaded: 'getSettingLanguage',
                updateComponent: 'getUpdateComponent'
            })
        },

        watch: {
            themeOption(value) {
                this.$vuetify.theme = this.themeOption.theme
            },

            isSettingLanguageLoaded() {
                this.initializeData()
            },

            initialize() {
                this.isInitialize()
            }
        },

        created() {
            this.initializeData();
        },

        methods: {
            initializeData() {
                if (this.languages.length > 0) {
                    axios.get('/auth/me').then((response) => {
                        if (response.data.success) {
                            const authUser = response.data.authUser

                            // set Bearer token in axios headers
                            axios.defaults.headers = {
                                ...axios.defaults.headers,
                                Authorization: `Bearer ${response.data.token}`
                            }

                            // If auth user is dealership manager, then set dealership & regions for manager
                            if (
                                authUser.level === CONST.MANAGER ||
                                authUser.level === CONST.SALE_EXECUTIVE
                            ) {
                                const dealership = {...response.data.dealership}
                                const regions = [...response.data.regions]
                                this.$store.commit('setSelectedDealership', dealership)
                                this.$store.commit('setRegions', regions)

                                if(authUser.level === CONST.SALE_EXECUTIVE){
                                    this.$store.commit('setSelectedUser', authUser)
                                }
                            }

                            this.$store.commit('setAuthUser', authUser)
                            this.$store.commit('setUserRole', true)
                            this.$store.commit('setInitialize', true)

                            // Get selected language from auth user
                            _.map(this.languages, (language) => {
                                if (language.id === this.authUser.language_id) {
                                    this.$store.commit('setSelectedLanguage', {...language})
                                    this.$store.dispatch('fetchSettingFields', {languageId: language.id});
                                }
                            })

                        } else {
                            this.$store.commit('setUserRole', false)
                            this.$store.commit('setInitialize', true)
                        }
                    })
                }
            },

            isInitialize() {
                if (this.initialize) {
                    return true
                }
                return false
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
