<template>
        <AdminDashboard v-if="authUser.level === 'admin'"></AdminDashboard>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AdminDashboard from './AdminDashboard'

    export default {
        components: {
            AdminDashboard
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
                authUser: 'getAuthUser'
            })
        }),
    }
</script>
