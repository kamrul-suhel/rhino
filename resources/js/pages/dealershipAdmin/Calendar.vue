<template>
    <v-container fluid px-5 v-if="checkAccessUse()">
        <v-layout row wrap px-4
                  v-if="checkAccessLevel()">
            <v-flex xs12 sm6 py-3>
                <h2>{{ trans.bookAnAppointment }}</h2>
            </v-flex>

            <v-flex xs12 sm6 py-3 >
                <v-layout row wrap justify-end>
                    <v-btn outline round
                           v-if="authUser.level === 'dealership' || authUser.level === 'admin'"
                           class="ma-0 mr-2"
                           align-self-end :color="themeOption.adminNavIconColor"
                        @click="$router.push({name: 'editEvents', params: {id: selectedEvent.id}})">
                        <v-icon left dark>reply</v-icon>
                        {{ trans.backToEvent }}
                    </v-btn>

                    <v-btn outline round
                           @click="onGoBack()"
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        {{ `${trans.reset}` }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout mt-4 v-if="isFiltering && checkAccessLevel()">
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
                                    {{ `${trans.salesTeamMember}` }}
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

                        <v-list-tile
                            v-if="teamMemberShow"
                            avatar
                            @click="onSelectTeamMember('viewAll')"
                        >
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.viewAll}` }}
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
                                :label="`${trans.selectDate}`"
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
                <div class="r-tab-title-close">
                    <v-icon
                        @click="onGoBack()"
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
                                   @click="onDownloadCSV()"
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
                      @onDownload="onDownloadCSV"
                      @onGoBack="onGoBack"
                      :filterByDate="filterByDate">
        </FilterByDate>

        <v-layout row warp
                  mt-5
                  v-if="selectedTeamMemberType === 'viewAll'">
            <ViewAllAppointment :dates="allowDates"/>
        </v-layout>

        <AppointmentDialog></AppointmentDialog>
        <AssignToSaleExecutiveDialog></AssignToSaleExecutiveDialog>
    </v-container>

    <v-container fluid px-5 v-else>
    <v-layout row wrap px-4>
        <v-flex xs12 sm6 py-3>
            <h2>{{trans.calenderAccessDenied}}</h2>
        </v-flex>
    </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'
    import User from '@/components/Appointment/User'
    import FilterByDate from "@/components/Appointment/FilterByDate";
    import AppointmentDialog from "@/components/Appointment/AppointmentDialog"
    import AssignToSaleExecutiveDialog from "@/components/Appointment/AssignToSaleExecutiveDialog"
    import ViewAllAppointment from "@/components/Appointment/ViewAllAppointment";
    import CONST from '@/utils/const'

    export default {

        components: {
            User,
            AppointmentDialog,
            AssignToSaleExecutiveDialog,
            FilterByDate,
            ViewAllAppointment
        },

        props: {
            rhinoAdmin: {
                type: Boolean,
                default: false
            }
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

                viewAll: false,
                viewAllDates: [],

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
                otherAppointments: 'getOtherAppointments',
            })
        }),

        watch: {
            selectedEvent() {
                this.fetchEventUser()
                this.allowDateForDatePicker()
                this.onGoBack()
            },

            updateComponent() {
                if(this.selectedTeamMemberType === 'viewAll'){
                    this.fetchDataForViewAll(this.selectedTeamMemberType, false)
                    return
                }
                this.fetchAllAppointmentByEventId(this.selectedUser)

                if (this.authUser.level === CONST.SALE_EXECUTIVE) {
                    return
                }

                if (this.showDatePicker) {
                    return
                }

                return
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
            this.initializeCalender()
            this.fetchEventUser()
            this.allowDateForDatePicker()

            this.$store.commit('setHeaderTitle', `${this.trans.welcomeBack}`)
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
                if (this.rhinoAdmin) {
                    this.fetchEventUser()
                }
                // if view all
                if(type === 'viewAll'){
                    this.fetchDataForViewAll(type)
                    return
                }

                if (type === 'date') {
                    this.showDatePicker = true
                }else{
                    this.showDatePicker = false
                }
                this.selectedTeamMemberType = type
                this.teamMemberShow = !this.teamMemberShow
            },

            getTeamMemberTitle() {
                switch (this.selectedTeamMemberType) {
                    case 'team':
                        this.saleExecutive = true
                        return `${this.trans.salesTeamMember}`

                    case 'date':
                        this.saleExecutive = false
                        return `${this.trans.date}`

                    default:
                        this.saleExecutive = false
                        return `${this.trans.teamMemberDate}`
                }
            },

            onSaleExecutiveClick() {
                this.saleExecutiveDropdown = !this.saleExecutiveDropdown
            },

            fetchEventUser() {
                let dealershipId = null
                let eventId = null
                if (this.rhinoAdmin) {
                    dealershipId = this.$route.params.dealershipId
                    eventId = this.$route.params.eventId
                } else {
                    dealershipId = this.dealership.id
                    eventId = this.selectedEvent.id
                }

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
            },

            onDownloadCSV(date = null) {
                let appointments = []
                let modifyAppointments = []

                if (date) {
                    const time = fn.getStartTimeEndTime(date, this.dealership)
                    appointments = [...fn.getTimeSlotsForDay(time, this.selectedEvent)]

                    _.map(this.users, (user) => {
                        _.map(appointments, (currentSlot) => {
                            let status = this.trans.available
                            let guest = ''

                            let selectedUser = {...user}

                            let isSlotAvailable = true

                            if (this.appointments.length > 0) {
                                _.map(this.appointments, (appointment) => {
                                    if (
                                        appointment.start === currentSlot.start &&
                                        selectedUser.id === appointment.user_id
                                    ) {
                                        isSlotAvailable = false

                                        guest = `${appointment.guest_first_name} ${appointment.guest_surname}`

                                        switch (appointment.status) {
                                            case 1:
                                                status = this.trans.confirmed
                                                break

                                            case 3:
                                                status = this.trans.notAvailable
                                                guest = ''
                                                break

                                            case 4:
                                                status = this.trans.breakTime
                                                guest = ''
                                                break
                                        }
                                    }
                                })
                            }

                            if (isSlotAvailable) {
                                if (this.otherAppointments.length > 0) {
                                    _.map(this.otherAppointments, (otherAppointment) => {
                                        if (otherAppointment.user_id === selectedUser.id) {

                                            const startTimeStart = new Date(currentSlot.start).getTime()
                                            const startTimeEnd = new Date(currentSlot.end).getTime() - 1000

                                            const endTimeStart = new Date(currentSlot.start).getTime() + 1000
                                            const endTimeEnd = new Date(currentSlot.end).getTime()

                                            const otherAppointmentStart = new Date(otherAppointment.start).getTime()
                                            const otherAppointmentEnd = new Date(otherAppointment.end).getTime()

                                            if (
                                                otherAppointmentStart >= startTimeStart &&
                                                otherAppointmentStart <= startTimeEnd ||
                                                otherAppointmentEnd >= endTimeStart &&
                                                otherAppointmentEnd <= endTimeEnd
                                            ) {
                                                isSlotAvailable = false
                                                status = this.trans.unavailable
                                                guest = `${otherAppointment.guest_first_name} ${otherAppointment.guest_surname}`
                                            }
                                        }

                                    })
                                }
                            }

                            const newAppointment = {
                                'event': this.selectedEvent.name,
                                'country': this.selectedEvent.country,
                                'sales executive': `${selectedUser.firstname} ${selectedUser.surname}`,
                                'date': moment(currentSlot.start).format('YYYY-MM-DD'),
                                'start': moment(currentSlot.start).format('LT'),
                                'end': moment(currentSlot.end).format('LT'),
                                'status': status,
                                'guest': guest
                            }

                            modifyAppointments.push(newAppointment)
                        })
                    })




                } else {
                    const dates = fn.allowedDates(this.selectedEvent, this.dealership)
                    _.map(dates, (date) => {
                        const time = fn.getStartTimeEndTime(date, this.dealership)
                        const currentAppointments = fn.getTimeSlotsForDay(time, this.selectedEvent)

                        appointments = [
                            ...appointments,
                            ...currentAppointments
                        ]
                    })

                    _.map(appointments, (currentSlot) => {
                        let status = this.trans.available
                        let guest = ''

                        let selectedUser = {...this.selectedUser}

                        let isSlotAvailable = true

                        if (this.appointments.length > 0) {
                            _.map(this.appointments, (appointment) => {
                                if (
                                    appointment.start === currentSlot.start &&
                                    selectedUser.id === appointment.user_id
                                ) {
                                    isSlotAvailable = false

                                    guest = `${appointment.guest_first_name} ${appointment.guest_surname}`

                                    switch (appointment.status) {
                                        case 1:
                                            status = this.trans.confirmed
                                            break

                                        case 3:
                                            status = this.trans.notAvailable
                                            guest = ''
                                            break

                                        case 4:
                                            status = this.trans.breakTime
                                            guest = ''
                                            break
                                    }
                                }
                            })
                        }

                        if (isSlotAvailable) {
                            if (this.otherAppointments.length > 0) {
                                _.map(this.otherAppointments, (otherAppointment) => {
                                    if (otherAppointment.user_id === selectedUser.id) {

                                        const startTimeStart = new Date(currentSlot.start).getTime()
                                        const startTimeEnd = new Date(currentSlot.end).getTime() - 1000

                                        const endTimeStart = new Date(currentSlot.start).getTime() + 1000
                                        const endTimeEnd = new Date(currentSlot.end).getTime()

                                        const otherAppointmentStart = new Date(otherAppointment.start).getTime()
                                        const otherAppointmentEnd = new Date(otherAppointment.end).getTime()

                                        if (
                                            otherAppointmentStart >= startTimeStart &&
                                            otherAppointmentStart <= startTimeEnd ||
                                            otherAppointmentEnd >= endTimeStart &&
                                            otherAppointmentEnd <= endTimeEnd
                                        ) {
                                            isSlotAvailable = false
                                            status = this.trans.unavailable
                                            guest = `${otherAppointment.guest_first_name} ${otherAppointment.guest_surname}`
                                        }
                                    }

                                })
                            }
                        }

                        const newAppointment = {
                            'event': this.selectedEvent.name,
                            'country': this.selectedEvent.country,
                            'sales executive': `${this.selectedUser.firstname} ${this.selectedUser.surname}`,
                            'date': moment(currentSlot.start).format('YYYY-MM-DD'),
                            'start': moment(currentSlot.start).format('LT'),
                            'end': moment(currentSlot.end).format('LT'),
                            'status': status,
                            'guest': guest
                        }

                        modifyAppointments.push(newAppointment)
                    })
                }

                let fileName = ''
                if(date){
                    fileName = moment().format('YYYY-MM-DD')
                }else{
                    fileName = `${this.selectedUser.firstname}-${this.selectedUser.surname}-appointments`
                }

                return fn.downloadCSV(modifyAppointments, fileName)
            },

            checkAccessLevel(){
                if(
                    this.authUser.level === CONST.ADMIN ||
                    this.authUser.level === CONST.MANAGER ||
                    this.authUser.level === CONST.RECEPTIONIST ||
                    this.authUser.level === CONST.CALL_HANDLER ||
                    this.rhinoAdmin
                ){
                    return true;
                }

                return false
            },

            checkAccessUse(){
                const authUserLevel = this.authUser.level
                switch(authUserLevel){
                    case CONST.ADMIN:
                    case CONST.CALL_HANDLER:
                    case CONST.MANAGER:
                    case CONST.RECEPTIONIST:
                        return true

                    case CONST.SALE_EXECUTIVE:
                        if(this.dealership.calendar_access === 1){
                            return true
                        }else{
                            return false
                        }
                }
            },

            async fetchDataForViewAll(type, changeTeamMemberShow = true){
                // get all date in this event
                const allowDates = fn.allowedDates(this.selectedEvent, this.dealership)
                this.viewAllDates = [...allowDates]

                // Fetch all Appointment
                const eventId = this.selectedEvent.id
                await this.$store.dispatch('fetchAppointmentByEventId', {eventId: eventId})

                if(changeTeamMemberShow){
                    this.teamMemberShow = !this.teamMemberShow
                }
                this.selectedTeamMemberType = type

            }
        }
    }
</script>
