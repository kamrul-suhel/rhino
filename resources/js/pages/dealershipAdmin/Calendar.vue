<template>
    <v-container fluid px-5>
        <v-layout row wrap px-4>
            <v-flex xs6>
                <h2>{{ trans.bookAnAppointment }}</h2>
            </v-flex>

            <v-flex xs6 align-self-end>
                <v-layout row wrap justify-end>
                    <v-btn outline round
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        <v-icon left dark>reply</v-icon>
                        {{ `${trans.back}` }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout mt-4>
            <v-flex xs12 sm4>
                <v-card class="r-border-round">
                    <v-list>
                        <v-list-tile
                            avatar
                            @click="onTeamMemberSelect()"
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                        :color="themeOption.adminNavIconColor">event_note
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ getTeamMemberTitle() }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile
                            v-if="teamMemberShow"
                            avatar
                            @click="onSelectTeamMember('team')"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.sales} ${trans.teamMember}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile
                            v-if="teamMemberShow"
                            avatar
                            @click="onSelectTeamMember('date')"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.date}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout mt-4 v-if="saleExecutive">
            <v-flex xs12 sm4>
                <v-card class="r-border-round">
                    <v-list>
                        <v-list-tile
                            avatar
                            @click="onSaleExecutiveClick()"
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                    :color="themeOption.adminNavIconColor">event_note
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ trans.choose }}...
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile
                            v-for="user in users"
                            :key="user.id"
                            v-if="saleExecutiveDropdown"
                            avatar
                            @click="onSelectSaleExecutive(user)"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${user.firstname} ${user.surname}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {

        components: {},

        data() {
            return {
                teamMemberShow: false,
                selectedTeamMemberType: null,
                saleExecutive: false,
                saleExecutiveDropdown: false
            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedEvent: 'getSelectedEvent',
                users: 'getUsers'
            })
        }),

        watch: {
            selectedEvent(){
                this.fetchEventUser()
            }
        },

        created() {
        },

        methods: {
            onTeamMemberSelect(){
                this.teamMemberShow = !this.teamMemberShow
            },

            onSelectTeamMember(type){
                this.selectedTeamMemberType = type
                this.teamMemberShow = !this.teamMemberShow
            },

            getTeamMemberTitle(){
                switch(this.selectedTeamMemberType){
                    case 'team':
                        this.saleExecutive = true
                        return `${this.trans.sales} ${this.trans.teamMember}`

                    case 'date':
                        this.saleExecutive = false
                        return `${this.trans.date}`

                    default:
                        this.saleExecutive = false
                        return `${this.trans.teamMember} / ${this.trans.date}`
                }

            },

            onSaleExecutiveClick(){
                this.saleExecutiveDropdown = !this.saleExecutiveDropdown
            },

            fetchEventUser(){
                const dealershipId = this.dealership.id
                const eventId = this.selectedEvent.id
                this.$store.dispatch('fetchUsersForEvent', {
                    dealershipId: dealershipId,
                    eventId: eventId,
                    themeOption: this.themeOption,
                    trans: this.trans
                })
            },

            onSelectSaleExecutive(saleExecutive){
                this.onSelectSaleExecutive = false
                console.log('sale executive: ', saleExecutive)
            }
        }
    }
</script>
