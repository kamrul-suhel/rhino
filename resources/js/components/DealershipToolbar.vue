<template>
    <v-layout pl-5 pr-5 class="dealershipAdminToolbar">
        <v-flex xs12>
            <v-card elevation="20"
                    class="toolbar"
            >
                <v-card-text class="toolbar-content">
                    <v-layout row wrap fill-height align-center>
                        <v-flex xs12 sm8>
                            <v-layout row wrap fill-height align-center>
                                <v-flex xs12 sm4>
                                    VIP Event
                                </v-flex>

                                <v-flex xs12 sm4>
                                    <v-autocomplete
                                        :items="events"
                                        class="eventDropdown"
                                        :color="themeOption.inputColor"
                                        append-icon="keyboard_arrow_down"
                                        :item-text="selectedEvent.event ? 'event': 'name'"
                                        v-model="selectedEvent"
                                        return-object
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12 sm4>
                                    {{ selectedEvent.start | dateFormat('DD')}} - {{ selectedEvent.end |
                                    dateFormat('DD')}} {{ selectedEvent.end | dateFormat('MMMM')}} {{ selectedEvent.end
                                    | dateFormat('YYYY') }}
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 sm4>
                            search found
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        watch: {},

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                isLogin: 'getIsLogin',
                dealership: 'getSelectedDealership',
                events: 'getEventsForDropDown'
            }),

            selectedEvent:{
                get: function() {
                    return this.$store.getters.getSelectedEvent
                },
                set:function(value) {
                    this.$store.commit('setSelectedEvent', value)
                }
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchEventForDropDown', {dealershipId: this.dealership.id, selectFirst: true})
            },

            onNavigationToggle() {
                this.$store.commit('setIsNavigationOpen')
            }
        }
    }
</script>
