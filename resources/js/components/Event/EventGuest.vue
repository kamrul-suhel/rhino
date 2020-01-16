<template>
    <GuestList subComponent
               model="event"
    ></GuestList>
</template>

<script>
    import {mapGetters} from 'vuex'
    import GuestList from '@/pages/guest/List'

    export default {
        components: {
            GuestList
        },

        data() {
            return {

            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
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
