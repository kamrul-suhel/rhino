<template>
    <v-navigation-drawer
        v-model="drawer"
        :width="themeOption.drawerWidthF"
        fixed
        clipped
        mobile-break-point="960"
        class="navigation-drawer">

        <v-layout row wrap
                  fill-height
        >
            <v-flex xs12>
                <v-layout>
                    <v-flex xs6>
                        <brand-carousel-component></brand-carousel-component>
                    </v-flex>

                    <v-flex class="language-select stroke-dropdown">
                        <language-picker
                            :languageId="guest.language_id"
                            isFrontend
                        ></language-picker>
                    </v-flex>
                </v-layout>
            </v-flex>

            <v-flex xs12>
                <h1 :style="{color:color}"
                    class='font-weight-black event-title'>
                    {{ event.name }}
                </h1>
            </v-flex>

            <v-flex xs12>
                <h4 :style="{color:color}">{{ event.start | dateFormat('LL') }} - {{ event.end| dateFormat('LL') }}</h4>
            </v-flex>

            <v-flex xs12>
                <v-tabs
                    v-model="step"
                    class="rhinoNavigationStepper"
                >
                    <v-tab
                        key="selectModel"
                        value="selectModel"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">1</v-avatar>
                        {{ `${trans.selectModel}` }}
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="bookYourSlot"
                        value="bookYourSlot"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">2</v-avatar>
                        {{ `${trans.bookYourSlot}` }}
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="partExchange"
                        value="partExchange"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">3</v-avatar>
                        {{ `${trans.partExchange}` }}
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="confirmYourDetail"
                        value="confirmYourDetail"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">4</v-avatar>
                        {{ `${trans.confirm} ${trans.your_details}` }}
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="bookingConfirmation"
                        value="bookingConfirmation"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">5</v-avatar>
                        {{ `${trans.bookingConfirmation}` }}
                    </v-tab>
                </v-tabs>
            </v-flex>

            <v-flex my-5 xs12>
                <v-layout row wrap align-bottom>
                    <v-flex xs6>
                        <h2 class="my-1 mr-4 name-button" :style="{color: color}">
                            {{ guest.first_name }}
                            <v-icon small :color="color">settings</v-icon>
                        </h2>
                    </v-flex>

                    <v-flex xs6>
                        <div>
                            <v-btn class="border-medium rounded-25"
                                   outline
                                   :color="color"
                                   @click="onGuestLogout()"
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
                drawer: true
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                guest: 'getBookingGuest',
                color: 'getFrontendColor',
                event: 'getSelectedEvent'
            }),

            step: {
                get(){
                    switch(this.$store.getters.getBookingStep){
                        case 'selectModel':
                            return 0
                            break
                        case 'bookYourSlot':
                            return 1
                            break

                        case 'partExchange':
                            return 2
                            break

                        case 'confirmYourDetail':
                            return 3
                            break
                        case 'bookingConfirmation':
                            return 4
                            break
                    }
                    return this.$store.getters.getBookingStep
                },

                set(value){
                    this.$store.commit('setBookingStep', value)
                }
            }
        }),

        watch: {
            guest() {
            }
        },

        created() {

        },

        methods: {
            onGuestLogout() {
                axios.post('guests/logout').then((response) => {
                    if (response.data.success) {
                        this.$router.push({name: 'login'})
                    }
                });
            }
        }
    }
</script>
