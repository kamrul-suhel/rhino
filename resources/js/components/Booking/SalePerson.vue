<template>
    <v-layout column class="book-step" align-center style="border-right: 1px solid rgb(240,240,240)">
        <v-layout>
            <h6 class="headline text-lg-center">Choose a <b>sales person</b></h6>
        </v-layout>

        <v-layout row justify-end style="width:70%" class="mt-4">
            <button :style="{color:color}"
                    style="opacity:0.7">Clear
            </button>
        </v-layout>

        <v-layout row wrap
                  justify-center
                  style="width:70%"
                  class="mt-2"
                  align-center>
            <v-card flat
                    max-height="250px"
                    height="250px">
                <v-card-text>
                    <v-flex xs12 mt-3
                            v-for="saleExecutive in saleExecutives"
                            :key="saleExecutive.id">
                        <v-avatar
                            size="28"
                            color="grey lighten-4">
                            <img :src="saleExecutive.profile_image"
                                 :alt="saleExecutive.firstname">
                        </v-avatar>

                        <div>{{ saleExecutive.firstname}}</div>
                    </v-flex>
                </v-card-text>
            </v-card>
        </v-layout>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return {
            }
        },

        created(){

        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                saleExecutives: 'getUsers'
            })
        }),

        methods:{

        }
    }
</script>
