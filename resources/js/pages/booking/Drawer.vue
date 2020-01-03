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
                        <brand-carousel-component></brand-carousel-component>
                    </v-flex>

                    <v-flex xs6 class="language-select stroke-dropdown">
                       <language-picker :languageId="guest.language_id"></language-picker>
                    </v-flex>
                </v-layout>
            </v-flex>

            <v-flex xs12>
                <h1 :style="{color:color}"
                    class='font-weight-black event-title'>Vauxhall Platinum Event
                </h1>
            </v-flex>

            <v-flex xs12>
                <h4 :style="{color:color}">XX.XX.XX - XX.XX.XX</h4>
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
                        {{ `${trans.confirm} ${trans.your_details}` }}
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
                        <h2 class="my-1 mr-4" :style="{color: color}">
                            {{ guest.first_name }}
                            <v-icon medium :color="color">settings</v-icon>
                        </h2>
                    </v-flex>

                    <v-flex xs6>
                        <div>
                            <v-btn class="border-medium rounded-25"
                                   outline
                                   :color="color"
                                   depressed>
                                {{ trans.logOut }}
                            </v-btn>
                        </div>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-navigation-drawer>
</template>


<script>
    import {mapGetters} from 'vuex'
    import BrandCarouselComponent from "./BrandCarouselComponent";
    import LanguagePicker from '@/components/Language'

    export default {
        components: {
            BrandCarouselComponent,
            LanguagePicker
        },

        data() {
            return {
                drawer: true,
                tile: false,
                e6: 1,
                model: 'tab-2'
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                guest: 'getBookingGuest',
                color: 'getFrontendColor'
            })
        }),

        watch:{
          guest(){
              console.log(this.guest)
          }
        },

        created() {

        },

        methods: {}
    }
</script>
