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
                  align-content-start
                  class="navigation-content"
        >
            <v-flex xs12>
                <v-layout>
                    <v-flex xs8>
                        <brand-carousel-component></brand-carousel-component>
                    </v-flex>

                    <v-flex xs4 class="language-select stroke-dropdown">
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
                <h4 :style="{color:color}">{{ event.start | dateFormat('LL', selectedLanguage.language_code) }} - {{
                    event.end| dateFormat('LL', selectedLanguage.language_code) }}</h4>
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
                        <v-avatar :style="{borderColor: color, color:color}">{{ numberFormat(1) }}</v-avatar>
                        <span :style="{color: color}">{{ `${trans.selectModel}` | trans }}</span>
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="bookYourSlot"
                        value="bookYourSlot"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">{{ numberFormat(2) }}</v-avatar>
                        <span :style="{color: color}">{{ `${trans.bookYourAppointment}` | trans }}</span>
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="partExchange"
                        value="partExchange"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">{{ numberFormat(3) }}</v-avatar>
                        <span :style="{color: color}">{{ `${trans.partExchangeDetails}` | trans }}</span>
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="confirmYourDetail"
                        value="confirmYourDetail"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">{{ numberFormat(4) }}</v-avatar>
                        <span :style="{color: color}">{{ `${trans.confirmYourDetails}` | trans }}</span>
                        <span class="link" :style="{backgroundColor: color}"></span>
                    </v-tab>

                    <v-tab
                        key="bookingConfirmation"
                        value="bookingConfirmation"
                    >
                        <v-avatar :style="{borderColor: color, color:color}">{{ numberFormat(5) }}</v-avatar>
                        <span :style="{color: color}">{{ `${trans.bookingConfirmation}`| trans }}</span>
                    </v-tab>
                </v-tabs>
            </v-flex>

            <v-flex xs12
                    class="navigation-footer">
                <v-layout row wrap align-bottom>
                    <v-flex xs6>
                        <h2 class="name-button"
                            @click="onEditGuestDetail()"
                            :style="{color: color}">
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
                drawer: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                guest: 'getBookingGuest',
                color: 'getFrontendColor',
                event: 'getSelectedEvent',
                selectedLanguage: 'getSubSelectedLanguage',
                vehicles: 'getBookingSelectedVehicles',
                slot: 'getSelectedSlot',
                saleExecutive: 'getBookingSelectedSaleExecutive',
                bringGuest: 'getBookingBringGuest',
                partExchange: 'getBookingPartExchange',
                date: 'getBookingSelectedDate',
                isDisable: 'getDisableEditing'
            }),

            step: {
                get() {
                    switch (this.$store.getters.getBookingStep) {
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

                set(value) {
                    if(!this.isDisable){
                        // validate before forward
                        switch (value) {
                            case 1:
                                // check vehicle selected of not
                                if (this.vehicles.length <= 0) {
                                    return
                                }

                            case 2:
                                if (
                                    !this.slot.slotId ||
                                    !this.saleExecutive.id ||
                                    !this.date
                                ) {
                                    return
                                }

                            case 3:
                                if (
                                    typeof this.partExchange.noVehicleExchange === 'undefined' ||
                                    this.partExchange.noVehicleExchange === false

                                ) {
                                    if (
                                        typeof this.partExchange.registrationNumber === 'undefined' &&
                                        typeof this.partExchange.makeAndModel === 'undefined'
                                    ) {
                                        return
                                    }
                                }

                            case 4:
                                if (this.vehicles.length <= 0) {
                                    return
                                }

                                if (
                                    !this.slot.slotId ||
                                    !this.saleExecutive.id ||
                                    !this.date
                                ) {
                                    return
                                }
                                if (
                                    typeof this.partExchange.noVehicleExchange === 'undefined' ||
                                    this.partExchange.noVehicleExchange === false

                                ) {
                                    if (
                                        typeof this.partExchange.registrationNumber === 'undefined' &&
                                        typeof this.partExchange.makeAndModel === 'undefined'
                                    ) {
                                        return
                                    }
                                }
                        }
                    }
                    this.$store.commit('setBookingStep', value)
                }
            }
        }),

        watch: {
            selectedLanguage() {
            }
        },

        created() {
            if ( window.innerWidth > 960 ) {
                this.drawer = true;
            }
        },

        methods: {
            onGuestLogout() {
                axios.post('/guests/logout').then((response) => {
                    if (response.data.success) {
                        this.$router.push({name: 'login'})
                    }
                });
            },

            onEditGuestDetail() {
                this.$store.commit('setEditGuest', true)
                this.$store.commit('setBookingStep', 3)
            },

            numberFormat(number) {
                if (this.selectedLanguage.id) {
                    return number.toLocaleString(`${this.selectedLanguage.language_code}-${this.selectedLanguage.country_code}`)
                }

                return number
            },
        }
    }
</script>
