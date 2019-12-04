<template>
    <router-view></router-view>
</template>

<script>
    export default {
        data(){
            return {

            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize(){
                this.$store.dispatch('fetchDealershipsForDropdown')
                this.$store.dispatch('fetchTypesForDropdown')
            }
        }
    }
</script>
