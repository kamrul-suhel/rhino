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
            this.$store.dispatch('fetchGuest', {id: 4})
        }
    }
</script>
