<template>
    <EditEvent subComponent
               model="dealership"
    ></EditEvent>
</template>

<script>
    import EditEvent from '../event/Edit'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            EditEvent
        },

        data() {
            return {}
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                update: 'getInitialize',
                selectedUsers: 'getUsers'
            })
        }),

        watch: {
            update() {
                this.initialize()
            },

            selectedUsers() {
                this.initialize()
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchUsersByDealershipId', {dealershipId: this.$route.params.dealershipId})
            }
        }
    }
</script>
