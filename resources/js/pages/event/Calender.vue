<template>
    <Calender :rhinoAdmin="true"></Calender>
</template>

<script>
    import {mapGetters} from 'vuex'
    import Calender from '@/pages/dealershipAdmin/Calendar'
    export default {
        components:{
            Calender
        },

        data() {
            return {
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                types: 'getTypes',
                dealerships: 'getDealerships'
            })
        }),

        watch: {
        },

        created() {
        },

        methods:{

        }
    }
</script>
