<template>
    <div id="app" v-if="initialize && isSettingFieldLoaded">
        <v-app
            id="rhino"
            v-if="isAdmin"
        >
            <navigation-component v-if="authUser.level === 'admin'"
            ></navigation-component>

            <DealershipNavigation v-if="authUser.level === 'dealership'"
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
                trans: 'getFields'
            })
        },

        watch: {
            themeOption(value) {
                this.$vuetify.theme = this.themeOption.theme
            }
        },

        async created() {
            axios.get('/auth/me').then((response) => {
                if(response.data.success){
                    const authUser = response.data.authUser

                    // If auth user is dealership manager, then set dealership & regions for manager
                    if(authUser.level === 'dealership'){
                        const dealership = {...response.data.dealership}
                        const regions = [...response.data.regions]
                        this.$store.commit('setSelectedDealership', dealership)
                        this.$store.commit('setRegions', regions)
                    }

                    this.$store.commit('setAuthUser', authUser)
                    this.$store.commit('setUserRole', true)
                    this.$store.commit('setInitialize', true)
                }else{
                    this.$store.commit('setUserRole', false)
                    this.$store.commit('setInitialize', true)
                }
            })
        },

        methods: {}
    }
</script>
