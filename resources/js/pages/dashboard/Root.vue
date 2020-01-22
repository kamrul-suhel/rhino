<template>
    <div>
        <DealershipDashboard v-if="authUser.level === 'dealership'"
        ></DealershipDashboard>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import DealershipDashboard from "./DealershipDashboard";

    export default {
        components: {
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

        watch: {

        },

        created() {
        },

        methods: {
        }
    }
</script>
