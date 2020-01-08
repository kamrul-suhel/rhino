<template>
    <div>

        <h2>Admin Dashboard</h2>

    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        components: {
            
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
