<template>
    <v-layout row wrap fill-height>
        <v-flex xs12>
            <h5 class="headline mt-5 text-xs-center">
                {{ trans.forbidden }}
            </h5>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data(){
            return{

            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages'
            })
        }),
    }
</script>
