<template>
    <div id="app" v-if="initialize">
        <v-app
            id="inspire"
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
                themeOption: 'getThemeOption',
                isAdmin: 'getIsAdmin',
                initialize: 'getInitializeApp',
                authUser: 'getAuthUser'
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
                    this.$store.commit('setAuthUser', response.data.authUser)
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
