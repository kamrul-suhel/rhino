<template>
    <v-layout column class="book-step sales-person" align-center style="border-right: 1px solid rgb(240,240,240)">
        <v-flex>
            <v-layout>
                <h6 class="headline text-xs-center">{{ trans.choose + ' ' + trans.a}} <b>{{ trans.sales + ' ' + trans.person }}</b></h6>
            </v-layout>
        </v-flex>

        <v-flex>
            <v-layout row justify-end class="mt-4">
                <button :style="{color:color}"
                        style="opacity:0.7">{{ trans.clear }}
                </button>
            </v-layout>
        </v-flex>

        <v-flex>
            <v-layout row wrap
                      justify-center
                      class="mt-2"
                      align-center>
                <v-card flat
                        max-height="250px"
                        height="250px">
                    <v-card-text>
                        <v-flex xs12 mt-3
                                class="salesperson-container"
                                :class="saleExecutive.selected && saleExecutive.selected === 'selected' ? 'active' : ''"
                                :style="{backgroundColor: saleExecutive.selected && saleExecutive.selected === 'selected' ? color : ''}"
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
        </v-flex>
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
                this.$store.commit('setBookingSelectedSaleExecutive', saleExecutive)
                this.$store.commit('updateUserForBooking', saleExecutive)
            }
        }
    }
</script>
