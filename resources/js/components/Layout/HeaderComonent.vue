<template>
    <div>
        <v-toolbar flat
            height="150">
            <v-toolbar-side-icon @click.stop="onNavigationToggle()"></v-toolbar-side-icon>
            <v-icon class="mx-3">fab fa-youtube</v-icon>
            <v-toolbar-title class="mr-5 align-center">
                <span class="title">{{ title }}</span>
            </v-toolbar-title>
        </v-toolbar>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
            }
        },

        watch: {},

        computed: {
            ...mapGetters({
                trans: 'getFields',
                isLogin: 'getIsLogin',
                title: 'getHeaderTitle'
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
