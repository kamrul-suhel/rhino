<template>
    <div id="app">
        <v-app
            id="inspire"
            dark
            v-if="isLoading"
        >
            <navigation-component></navigation-component>
            <header-component></header-component>
            <v-content>
                <v-container fill-height>
                    <v-layout >
                        <v-flex>
                            <SnackBar></SnackBar>
                            <router-view></router-view>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>
</template>

<script>
    import  HeaderComponent  from './Layout/HeaderComonent.vue';
    import  NavigationComponent  from './Layout/NavigationComponent.vue';
    import SnackBar from "./SnackBar";
    import {mapGetters} from 'vuex';

    export default {
        name: 'App',
        components: {
            NavigationComponent,
            HeaderComponent,
            SnackBar
        },

        data: () => ({
            login:false,
            initialize: false
        }),

        computed:{
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading',
                themeOption: 'getThemeOption'
            })
        },

        watch: {
          themeOption(value){
              console.log('theme option is change', value);
              this.$vuetify.theme = this.themeOption.theme
            }
        },

        async created() {
        },

        methods: {
        }
    }
</script>
