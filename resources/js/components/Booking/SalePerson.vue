<template>
    <v-layout class="book-step sales-person"
              row wrap
              align-center>
        <v-flex xs12>
            <h6 class="headline text-xs-center">{{ trans.chooseA}} <b>{{ trans.salesPerson }}</b></h6>
        </v-flex>

        <v-flex xs12>
            <v-layout row justify-end class="mt-4 ma-1">
                <button :style="{color:color}"
                        @click="onSalePersonRemove()"
                        style="opacity:0.7">{{ trans.clear }}
                </button>
            </v-layout>
        </v-flex>

        <v-flex xs12>
            <v-layout row wrap
                      justify-center
                      class="mt-2"
                      align-center>
                <v-flex xs12>
                    <v-card flat
                            max-height="250px"
                            height="350px" id="sales-scroller">
                        <v-card-text id="mover">
                            <v-flex xs12 mt-3
                                    class="salesperson-container"
                                    :class="saleExecutive.selected && saleExecutive.selected === 'selected' ? 'active' : ''"
                                    :style="{backgroundColor: saleExecutive.selected && saleExecutive.selected === 'selected' ? color : ''}"
                                    @click="onSelectSaleExecutive(saleExecutive)"
                                    v-for="saleExecutive in saleExecutives"
                                    v-if="saleExecutive.availability"
                                    :key="saleExecutive.id">

                                <v-layout row>
                                    <v-flex class="avatar-flex">
                                        <v-avatar
                                            size="28"
                                            color="grey lighten-4">
                                            <img :src="saleExecutive.profile_image"
                                                 v-if="saleExecutive.profile_image === ''"
                                                 :alt="saleExecutive.firstname">
                                            <v-icon :color="color">account_circle</v-icon>
                                        </v-avatar>
                                    </v-flex>

                                    <v-flex class="text-flex">
                                        <label>{{ `${saleExecutive.firstname} ${saleExecutive.surname}`}}</label>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-card-text>
                    </v-card>
                </v-flex>
                <v-flex v-if="saleExecutives.length > 5" xs12 style="text-align:center; margin-top:20px; cursor: pointer">
                    <span><small>Scroll for more names</small><br><i class="fas fa-chevron-down"></i></span>
                </v-flex>
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
                saleExecutives: 'getUsers',
                vehicleType: 'getBookingVehicleType',
                isDisable: 'getDisableEditing',
            })
        }),

        methods:{
            onSelectSaleExecutive(saleExecutive){
                if(this.isDisable){
                    return
                }
                this.$store.commit('setBookingSelectedSaleExecutive', saleExecutive)
                this.$store.commit('updateUserForBooking', saleExecutive)
            },

            onSalePersonRemove(){
                this.$store.commit('setBookingSelectedSaleExecutive', {})
                this.$store.commit('updateUserForBooking', {})
            },

        }
    }
</script>
<style scoped>
    #sales-scroller {
        overflow-y: scroll;
    }

    #sales-scroller::-webkit-scrollbar {
    display: none;
    }

    /* Hide scrollbar for IE and Edge */
    #sales-scroller {
    -ms-overflow-style: none;
    }
</style>
