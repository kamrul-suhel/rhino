<template>
    <div>
        <v-layout
            align-center
            justify-space-between
            row
            wrap
            fill-height
            class="header"
            pa-5
            :style="{height : `${themeOption.adminHeaderHeight}px`}">
            <v-flex xs12 sm4>
                <h2>Logo</h2>
            </v-flex>

            <v-flex xs12 sm4>
                <div class="text-xs-center">
                    {{ title }}
                </div>
            </v-flex>

            <v-flex xs12 sm4>
                <v-spacer></v-spacer>
                <span>languaage</span>
            </v-flex>
        </v-layout>

        <dealership-toolbar
            v-if="authUser.level === 'dealership'">
        </dealership-toolbar>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import DealershipToolbar from '@/components/DealershipToolbar'

    export default {
        components: {
            DealershipToolbar
        },
        data() {
            return {}
        },

        watch: {},

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                isLogin: 'getIsLogin',
                title: 'getHeaderTitle',
                authUser: 'getAuthUser'
            })
        },

        created() {
        },

        methods: {
            onNavigationToggle() {
                this.$store.commit('setIsNavigationOpen')
            }
        }
    }
</script>
