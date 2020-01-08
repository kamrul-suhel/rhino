<template>
    <div id="app" v-if="initialize">
        <v-app
            id="inspire"
            dark
            v-if="isAdmin"
        >
            <navigation-component></navigation-component>
            <header-component></header-component>
            <v-content>
                <v-container fill-height>
                    <v-layout>
                        <v-flex>
                            <SnackBar></SnackBar>
                            <router-view></router-view>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
        <template v-else>
            <router-view></router-view>
        </template>
    </div>
</template>

<script>
    import HeaderComponent from './Layout/HeaderComonent.vue'
    import NavigationComponent from './Layout/NavigationComponent.vue'
    import SnackBar from "./SnackBar"
    import {mapGetters} from 'vuex'

    export default {
        name: 'App',
        components: {
            NavigationComponent,
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
                initialize: 'getInitializeApp'
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
