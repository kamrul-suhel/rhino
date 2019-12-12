<template>

</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return{

            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        }),

        created() {

        }
    }
</script>
