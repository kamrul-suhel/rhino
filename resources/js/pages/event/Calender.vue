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
            this.selectedDealership()
        },

        methods:{
            selectedDealership(){
                this.$store.dispatch('fetchDealership', {id: this.$route.params.dealershipId})
                this.$store.dispatch('fetchEvent', {id: this.$route.params.eventId})
            }
        }
    }
</script>
