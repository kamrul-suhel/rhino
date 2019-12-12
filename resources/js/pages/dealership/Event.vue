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
                trans: 'getFields'
            })
        }),

        watch: {},

        created() {

        },

        methods: {}
    }
</script>
