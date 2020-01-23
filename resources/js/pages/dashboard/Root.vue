<template>
    <div>
        <AdminDashboard v-if="authUser.level === 'admin'"></AdminDashboard>
        <DealershipDashboard v-if="authUser.level === 'dealership'"
        ></DealershipDashboard>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AdminDashboard from './AdminDashboard'
    import DealershipDashboard from "./DealershipDashboard";

    export default {
        components: {
            AdminDashboard,
            DealershipDashboard
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
