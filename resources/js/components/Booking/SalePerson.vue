<template>
    <v-layout column class="book-step sales-person" align-center style="border-right: 1px solid rgb(240,240,240)">
        <v-layout>
            <h6 class="headline text-lg-center">{{ trans.ChooseA }} <b>{{ trans.saleperson }}</b></h6>
        </v-layout>

        <v-layout row justify-end style="width:70%" class="mt-4">
            <button :style="{color:color}"
                    style="opacity:0.7">{{ trans.clear }}
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
                            class="salesperson-container"
                            @click="onSelectSaleExecutive(saleExecutive)"
                            v-for="saleExecutive in saleExecutives"
                            :key="saleExecutive.id">
                        <v-layout row>
                            <v-flex class="avatar-flex">
                                <v-avatar
                                    size="28"
                                    color="grey lighten-4">
                                    <img :src="saleExecutive.profile_image"
                                         :alt="saleExecutive.firstname">
                                </v-avatar>
                            </v-flex>
                            <v-flex class="text-flex">
                                <label>{{ saleExecutive.firstname}}</label>
                            </v-flex>
                        </v-layout>

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
            onSelectSaleExecutive(saleExecutive){
                console.log(saleExecutive)
            }
        }
    }
</script>
