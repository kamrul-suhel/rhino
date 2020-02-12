<template>
    <router-view></router-view>
</template>

<script>
    import { mapGetters } from 'vuex'
    export default {
        data: () => {
            return {

            }
        },

        computed: {
            ...mapGetters({
                selectedEvent: 'getSelectedEvent',
                authUser: 'getAuthUser',
                eventsForDropDown: 'getEventsForDropDown'
            })
        },

        watch:{
        },

        created(){
        },

        methods: {

        }
    }
</script>
