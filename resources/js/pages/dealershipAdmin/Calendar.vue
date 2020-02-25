<template>
    <v-container fluid px-5>
        <v-layout row wrap px-4>
            <v-flex xs6>
                <h2>{{ trans.bookAnAppointment }}</h2>
            </v-flex>

            <v-flex xs6 align-self-end v-if="authUser.level === 'dealership'">
                <v-layout row wrap justify-end>
                    <v-btn outline round
                           @click="onGoBack()"
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        <v-icon left dark>reply</v-icon>
                        {{ `${trans.back}` }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout mt-4 v-if="isFiltering && authUser.level === 'dealership'">
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

        <v-layout mt-4 v-if="showDatePicker">
            <v-flex xs12 sm4>
                <v-card class="r-border-round pa-3">
                    <v-dialog
                        ref="dialog"
                        v-model="modal"
                        :return-value.sync="date"
                        persistent
                        lazy
                        full-width
                        width="290px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                :color="themeOption.primaryColor"
                                v-model="date"
                                :label="`${trans.select} ${trans.date}`"
                                prepend-icon="calendar_today"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="date"
                                       :allowed-dates="val => allowDates.indexOf(val) !== -1"
                                       :show-current="showCurrent"
                                       :color="themeOption.primaryColor"
                                       scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat
                                   :color="themeOption.primaryColor"
                                   @click="modal = false">{{ trans.cancel }}
                            </v-btn>

                            <v-btn flat
                                   :color="themeOption.primaryColor"
                                   @click="onDateChange(date)">{{ trans.ok }}
                            </v-btn>
                        </v-date-picker>
                    </v-dialog>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout mt-4 v-if="saleExecutive && isFiltering">
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

        <div class="r-tab open" v-if="isUserSelected">
            <div class="r-tab-title">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">more_horiz
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.appointment}` }}
                </div>
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">close
                    </v-icon>
                </div>
            </div>

            <div class="r-tab-content open">
                <v-container fluid pa-0 grid-list-xl>
                    <v-layout row wrap>
                        <v-flex xs6>
                            <h2>{{ selectedUser.firstname }}</h2>
                        </v-flex>
                        <v-flex xs6 class="text-xs-right">
                            <v-btn round
                                   :color="themeOption.adminNavIconColor"
                                   class="ma-0">
                                <span style="color:#fff;">{{ `${trans.download}` }}</span>
                            </v-btn>
                        </v-flex>

                        <v-flex xs12>
                            <User :user="selectedUser"></User>
                        </v-flex>
                    </v-layout>
                </v-container>
            </div>
        </div>

        <FilterByDate v-if="filterByDate"
                      :date="date"
                      :filterByDate="filterByDate">
        </FilterByDate>

        <AppointmentDialog></AppointmentDialog>
        <AssignToSaleExecutiveDialog></AssignToSaleExecutiveDialog>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'
    import User from '@/components/Appointment/User'
    import FilterByDate from "@/components/Appointment/FilterByDate";
    import AppointmentDialog from "@/components/Appointment/AppointmentDialog"
    import AssignToSaleExecutiveDialog from "@/components/Appointment/AssignToSaleExecutiveDialog"
    import CONST from '@/utils/const'

    export default {

        components: {
            User,
            AppointmentDialog,
            AssignToSaleExecutiveDialog,
            FilterByDate
        },

        data() {
            return {
                date: new Date().toISOString().substr(0, 10),
                menu: false,
                modal: false,


                teamMemberShow: false,
                selectedTeamMemberType: null,
                saleExecutive: false,
                saleExecutiveDropdown: false,
                isUserSelected: false,
                isFiltering: true,

                showDatePicker: false,
                filterByDate: false,
                allowDates: [],
                showCurrent: '',


                isSaleExecutive: false
            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedEvent: 'getSelectedEvent',
                users: 'getUsers',
                appointments: 'getAppointments',
                selectedUser: 'getSelectedUser',
                updateComponent: 'getUpdateComponent',
                authUser: 'getAuthUser',
            })
        }),

        watch: {
            selectedEvent() {
                this.fetchEventUser()
                this.allowDateForDatePicker()
            },

            updateComponent() {
                this.fetchAllAppointmentByEventId(this.selectedUser)
                if (this.authUser.level === CONST.SALE_EXECUTIVE) {
                    return
                }

                if(this.showDatePicker){
                    return
                }
                
                this.onGoBack()
            },

            selectedUser() {
                this.initializeCalender()
            },

            authUser() {
                this.initializeCalender()
            },

            users() {
                this.initializeCalender()
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', this.trans.calendar)
            this.initializeCalender()
            this.fetchEventUser()
            this.allowDateForDatePicker()
        },

        methods: {
            initializeCalender() {
                if (
                    this.authUser &&
                    this.authUser.level === CONST.SALE_EXECUTIVE &&
                    this.selectedUser.id &&
                    this.selectedEvent.id
                ) {
                    this.isSaleExecutive = true
                    this.isUserSelected = true
                    this.fetchAllAppointmentByEventId(this.authUser)
                }
            },

            onTeamMemberSelect() {
                this.teamMemberShow = !this.teamMemberShow
            },

            onSelectTeamMember(type) {
                if(type === 'date'){
                    this.showDatePicker = true
                }
                this.selectedTeamMemberType = type
                this.teamMemberShow = !this.teamMemberShow
            },

            getTeamMemberTitle() {
                switch (this.selectedTeamMemberType) {
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

            onSaleExecutiveClick() {
                this.saleExecutiveDropdown = !this.saleExecutiveDropdown
            },

            fetchEventUser() {
                const dealershipId = this.dealership.id
                const eventId = this.selectedEvent.id
                this.$store.dispatch('fetchUsersForEvent', {
                    dealershipId: dealershipId,
                    eventId: eventId,
                    themeOption: this.themeOption,
                    trans: this.trans
                })
            },

            onSelectSaleExecutive(saleExecutive) {
                this.isUserSelected = false
                this.$store.commit('setSelectedUser', saleExecutive)
                this.isUserSelected = true
                this.fetchAllAppointmentByEventId(saleExecutive)

                // reset all list
                this.isFiltering = false
            },

            fetchAllAppointmentByEventId(saleExecutive) {
                const eventId = this.selectedEvent.id
                this.$store.dispatch('fetchAppointmentByEventId', {eventId: eventId, saleExecutiveId: saleExecutive.id})
            },

            onGoBack() {
                this.teamMemberShow = false
                this.selectedTeamMemberType = null
                this.saleExecutive = false
                this.saleExecutiveDropdown = false
                this.isUserSelected = false
                this.isFiltering = true
                this.showDatePicker = false
                this.filterByDate = false
            },

            onDateChange(date) {
                const eventId = this.selectedEvent.id
                this.$store.dispatch('fetchAppointmentByEventId', {eventId: eventId, date: date})
                this.$refs.dialog.save(date)
                this.filterByDate = true
                this.$store.commit('setInitAppointmentByDate')
            },

            allowDateForDatePicker() {
                const event = this.selectedEvent
                const dealership = this.dealership

                if (event && dealership) {
                    this.allowDates = [...fn.allowedDates(event, dealership)]
                    this.date = this.allowDates[0]
                }
            }
        }
    }
</script>
