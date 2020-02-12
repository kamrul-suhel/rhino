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
                eventsForDropDown: 'getEventsForDropDown',
                updateComponent: 'getUpdateComponent'
            })
        },

        watch:{
            updateComponent(){
                if(this.$route.params.eventId === this.selectedEvent.id){
                    return
                }

                this.$router.push({
                    name: 'editDealershipsEvent',
                    params:{
                        eventId: this.selectedEvent.id,
                        dealershipId: this.authUser.dealership_id
                    }
                })
            }
        },

        created(){
        },

        methods: {

        }
    }
</script>
