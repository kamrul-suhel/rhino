<template>
    <AdminLoginComponent></AdminLoginComponent>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AdminLoginComponent from '@/components/Login/AdminLogin'

    export default {
        components: {
            AdminLoginComponent
        },

        data() {
            return {

            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
            })
        }),

        watch: {

        },

        created() {
        },

        methods: {
        }
    }
</script>
