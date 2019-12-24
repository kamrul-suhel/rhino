
<template>
    <div id="app">
        <v-app
            id="inspire"
            white
            v-if="isLoading"
        >
            <template>
                <v-content>
                    <FDrawer></FDrawer>
                    <v-container class="frontend-container" fill-height fluid>
                        <v-layout>
                            <v-flex :style="{marginLeft: themeOption.drawerWidthF}">

                                <v-tabs-items v-model="model">
                                    <v-tab-item
                                        v-for="i in 3"
                                        :key="i"
                                        :value="`tab-${i}`"
                                    >
                                        <v-card flat>
                                            <v-card-text>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, aspernatur dolorum eaque eum ipsum nihil omnis quam qui quia quis quisquam quo, quod recusandae sapiente veniam voluptate voluptatem. Maiores, molestias?</v-card-text>
                                        </v-card>
                                    </v-tab-item>
                                </v-tabs-items>

                                <!-- step 1 -->
                                <FSelectCar></FSelectCar>
                                <!-- step 2 -->
                                <!--<FBookAppointment></FBookAppointment>-->
                                <!-- step 3 -->
                                <!--<FPartExchange></FPartExchange>-->
                                <!-- step 4 -->
                                <!--<FPersonalDetails></FPersonalDetails>-->
                                <!-- step 5 -->
                                <!--<FConfirmDetails></FConfirmDetails>-->
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-content>
            </template>
        </v-app>
    </div>
</template>

<script>

    import FDrawer from './drawer'
    import FSelectCar from './selectModel'
    import FBookAppointment from './bookAppointment'
    import FPartExchange from './partExchange'
    import FPersonalDetails from './personalDetails'
    import FConfirmDetails from './confirmDetails'
    import {mapGetters} from 'vuex';

    export default {
        name: 'App',
        components: {
            FDrawer,
            FSelectCar,
            FBookAppointment,
            FPartExchange,
            FPersonalDetails,
            FConfirmDetails
        },

        data: () => ({
            model: 'tab-2'
        }),

        computed:{
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading',
                themeOption: 'getThemeOption',
                isAdmin : 'getIsAdmin'
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
