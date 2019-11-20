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
    import {mapGetters} from 'vuex';

    export default {
        name: 'App',
        components: {
            NavigationComponent,
            HeaderComponent,
        },

        data: () => ({
            login:false,
            initialize: false
        }),

        computed:{
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading'
            })
        },

        async created() {
        },

        methods: {
        }
    }
</script>
