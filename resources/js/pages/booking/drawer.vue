<template>
    <v-navigation-drawer
        v-model="drawer"
        :width="themeOption.drawerWidthF"
        fixed
        clipped
        mobile-break-point="960"
        class="navigation-drawer">

        <v-layout row wrap
                  align-content-start
                  fill-height
        >
            <v-flex xs12>
                <v-layout>
                    <v-flex xs6>
                        <v-avatar
                            :tile="tile"
                            :size="themeOption.companyIconSizeF"
                            color="grey lighten-4"
                        >
                            <v-img src="http://vuetifyjs.com/apple-touch-icon-180x180.png" alt="avatar"></v-img>
                        </v-avatar>
                    </v-flex>

                    <v-flex xs6 class="language-select stroke-dropdown">
                        <v-select
                            v-model="e1"
                            :items="languages"
                            menu-props="auto"
                            :label="trans.language"
                            hide-details
                            prepend-icon="map"
                            append-icon="expand_more"
                        ></v-select>
                    </v-flex>
                </v-layout>
            </v-flex>

            <v-flex xs12>
                <h1 :style="{color:themeOption.secondaryColor}"
                    class='font-weight-black event-title'>Vauxhall Platinum Event
                </h1>
            </v-flex>

            <v-flex xs12>
                <h4 :style="{color:themeOption.brandColor}">XX.XX.XX - XX.XX.XX</h4>
            </v-flex>

            <v-flex xs12>
                <v-tabs
                    v-model="model"
                    class="rhinoNavigationStepper"
                >
                    <v-tab
                        key="selectModel"
                    >
                        <v-avatar>1</v-avatar>
                        {{ `${trans.bookYourSlot}` }}
                    </v-tab>

                    <v-tab
                        key="partExchange"
                    >
                        <v-avatar>2</v-avatar>
                        {{ `${trans.partExchange}` }}
                    </v-tab>

                    <v-tab
                        key="confirmYourDetail"
                    >
                        <v-avatar>3</v-avatar>
                        {{ `${trans.confirmYourDetails}` }}
                    </v-tab>

                    <v-tab
                        key="BookingConfirmation"
                    >
                        <v-avatar>4</v-avatar>
                        {{ `${trans.bookingConfirmation}` }}
                    </v-tab>
                </v-tabs>
            </v-flex>

            <v-flex class="navFooter">
                <v-layout row wrap>
                    <v-flex xs6>
                        <h2 class="my-1 mr-4">Jordan
                            <v-icon medium>settings</v-icon>
                        </h2>
                    </v-flex>

                    <v-flex xs6>
                        <div>
                            <v-btn class="border-medium rounded-25 theme-color" depressed>LOG OUT</v-btn>
                        </div>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-navigation-drawer>
</template>


<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                drawer: true,
                tile: false,
                e1: 1,
                e6: 1,
                model: 'tab-2',

                items: [
                    {title: 'Book your slot', icon: 'dashboard'},
                    {title: 'Part exchange', icon: 'question_answer'},
                    {title: 'Confirm your details', icon: 'question_answer'},
                    {title: 'Booking confirmation', icon: 'question_answer'}
                ]
            }
        },

        created() {

        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
            })
        }),

        methods: {}
    }
</script>
