<template>
    <v-layout class="book-step"
              row wrap
              align-center>
        <v-flex xs12>
            <h6 class="headline text-xs-center">
                {{ `${trans.chooseA}` }} <b> {{ `${trans.time}`}} </b>
            </h6>
        </v-flex>

        <v-flex xs12>
            <v-layout row wrap
                      class="mt-4">
                <v-flex xs12 class="text-xs-right">
                    <button :style="{color: color}"
                            @click="onClearSlot()"
                            style="opacity:0.7">{{ trans.clear }}
                    </button>
                </v-flex>
            </v-layout>

            <v-layout row wrap
                      class="appointmentSlot"
                      style="width:100%; flex-grow:0"
                      mx-1>
                <v-flex xs6 sm3 md4 xl3
                        class="slot"
                        v-for="slot in slots"
                        :key="slot.slotId">
                    <v-responsive aspect-ratio="1">
                        <v-layout align-center row wrap
                                  justify-center
                                  class="pa-2 ma-2"
                                  :class="slot.status"
                                  @click="onSelectSlot(slot)"
                                  :style="{
                                        border: '1px solid rgb(220,220,220)',
                                         backgroundColor: slot.status === 'selected' ? color: ''
                                      }">
                            <h6 class="body-2">{{ slot.start | dateFormat('HH', selectedLanguage.language_code)}}-<br>{{ slot.end | dateFormat('HH', selectedLanguage.language_code)}}
                            </h6>
                        </v-layout>
                    </v-responsive>
                </v-flex>
            </v-layout>
        </v-flex>

        <v-flex xs12>
            <v-layout row wrap mx-2>
                <v-flex xs12>
                    <h6 class="body-2 mt-4 mb-2" style="width:100%">
                        {{ trans.wouldYouLikeToBringGuest }}
                    </h6>

                    <v-text-field
                        :disabled="isDisable"
                        :label="`${trans.guestName}`"
                        :color="color"
                        v-model="bringGuest.name"
                        outline
                        style="width:100%"
                    ></v-text-field>
                </v-flex>

                <v-flex xs12>
                    <h6 class="body-2" style="width:100%">
                        {{ trans.mightYourGuestAlsoBeInterested }}
                    </h6>

                    <v-layout row class="checkboxes">
                        <v-flex>
                            <v-checkbox :color="color"
                                        :disabled="isDisable"
                                        value="yes"
                                        v-model="guestInterestedYes"
                            ></v-checkbox>
                            <label class="body-2 mr-5 ml-2">{{ trans.yes }}</label>
                        </v-flex>
                        <v-flex>
                            <v-checkbox :color="color"
                                        :disabled="isDisable"
                                        value="no"
                                        v-model="guestInterestedNo"
                                        style="flex-grow:0"
                            ></v-checkbox>
                            <label class="body-2 mr-5 ml-2">{{ trans.no }}</label>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {
        data() {
            return {
                guestInterestedYes: false,
                guestInterestedNo: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                event: 'getSelectedEvent',
                dealership: 'getSelectedDealership',
                slots: 'getAllAppointmentSlot',
                vehicleType: 'getBookingVehicleType',
                selectedDate: 'getBookingSelectedDate',
                saleExecutives: 'getUsers',
                selectedSaleExecutive: 'getBookingSelectedSaleExecutive',
                existingAppointments: 'getAllBookingAppointments',
                bringGuest: 'getBookingBringGuest',
                selectedSlot: 'getSelectedSlot',
                isDisable: 'getDisableEditing',
                selectedLanguage: 'getSubSelectedLanguage'
            })
        }),

        created() {
        },

        watch: {
            guestInterestedYes() {
                if (this.guestInterestedYes) {
                    const guest = {
                        name: this.bringGuest.name,
                        changingCar: true
                    }

                    this.$store.commit('setBookingBringGuest', guest)
                    this.guestInterestedNo = false
                }
            },

            guestInterestedNo() {
                if (this.guestInterestedNo) {
                    const guest = {
                        name: this.bringGuest.name,
                        changingCar: false
                    }
                    this.$store.commit('setBookingBringGuest', guest)
                    this.guestInterestedYes = false
                }
            },

            event() {
                this.generateSlots()
            },

            selectedDate() {
                // generate slot
                this.generateSlots()
                this.checkCascadeTime()
            },

            selectedSaleExecutive() {
                if (
                    this.vehicleType === 'unsure' &&
                    this.selectedDate != ''
                ) {
                    return
                }
                // generate slot
                this.generateSlots()
                this.checkCascadeTime()
            }
        },

        methods: {
            generateSaleExecutive(selectedSlot) {

                const time = fn.getStartTimeEndTime(this.selectedDate, this.dealership)
                const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                let foundSaleExecutive = {}

                let modifySlots = []

                _.map(daysSlot, (slot) => {
                    let takenSlot = []

                    _.map(this.saleExecutives, (saleExecutive) => {
                        let isSaleExecutiveExists = true
                        _.map(this.existingAppointments, (existingAppointment) => {
                            if (
                                slot.start === existingAppointment.start &&
                                saleExecutive.id === existingAppointment.user_id
                            ) {
                                isSaleExecutiveExists = false
                            }
                        })

                        if (isSaleExecutiveExists) {
                            takenSlot.push(true)
                        } else {
                            takenSlot.push(false)
                        }
                    })

                    if (_.includes(takenSlot, true)) {
                        modifySlots.push({
                            ...slot,
                            status: 'available'
                        })
                    } else {
                        modifySlots.push({
                            ...slot,
                            status: 'unavailable'
                        })
                    }
                })

                this.$store.commit('setAllAppointmentSlots', modifySlots)
            },

            generateSlots() {
                if (
                    this.vehicleType === 'unsure' &&
                    this.selectedDate != ''
                ) {
                    this.generateSaleExecutive()
                    return
                }


                const start = moment(this.event.start)
                const end = moment(this.event.end)
                const dates = fn.getDates(start, end, this.dealership)

                // If selected sale executive
                if (this.selectedSaleExecutive.id) {
                    // Check is slot is selected or no
                    if (this.selectedSlot.start) {
                        // if date is not selected then generate dates
                        if (this.selectedDate === '') {

                        }
                        return
                    }

                    // get the user existing appointments
                    const existingAppointments = _.filter(this.existingAppointments, (existingAppointment) => {
                        return existingAppointment.user_id === this.selectedSaleExecutive.id
                    })

                    if (this.selectedDate === '') {
                        let appointmentSlots = []
                        // not selected date, iterate all open date
                        _.forEach(dates, (date) => {
                            const time = fn.getStartTimeEndTime(date, this.dealership)

                            const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                            appointmentSlots.push([...daysSlot])
                        })

                    } else {
                        // selected date
                        const selectedDate = this.selectedDate
                        const selectedSaleExecutiveId = this.selectedSaleExecutive.id
                        const time = fn.getStartTimeEndTime(selectedDate, this.dealership)
                        const slots = fn.getTimeSlotsForDay(time, this.event)
                        let modifySlots = []

                        _.map(slots, (slot) => {
                            let currentSlot = {
                                ...slot,
                                status: 'available'
                            }
                            // iterate into appointment
                            if (this.existingAppointments.length > 0) {
                                _.map(this.existingAppointments, (appointment) => {
                                    if (
                                        appointment.start === slot.start &&
                                        selectedSaleExecutiveId === appointment.user_id
                                    ) {
                                        currentSlot = {
                                            ...currentSlot,
                                            status: 'unavailable'
                                        }
                                    }
                                })
                            } else {
                                currentSlot = {
                                    ...currentSlot,
                                    status: 'available'
                                }
                            }
                            modifySlots.push(currentSlot)
                        })

                        this.$store.commit('setAllAppointmentSlots', modifySlots)
                    }

                    return
                }

                let appointmentSlots = []
                let allSlots = []
                let appointments = []

                // Check if selected date is set
                if (this.selectedDate === '') {
                    _.forEach(dates, (date) => {
                        const time = fn.getStartTimeEndTime(date, this.dealership)

                        const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                        appointmentSlots.push([...daysSlot])
                    })

                    appointments = [..._.flatten(appointmentSlots)]
                } else {
                    const time = fn.getStartTimeEndTime(this.selectedDate, this.dealership)
                    const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                    appointments = [...daysSlot]
                }

                this.$store.commit('setAllAppointmentTime', appointments)

                _.forEach(appointments, (appointment) => {
                    if (allSlots.length > 0) {
                        const found = _.find(allSlots, {slotId: appointment.slotId})
                        if (typeof found === 'undefined') {
                            allSlots.push({
                                status: 'available',
                                ...appointment
                            })
                        }
                    } else {
                        allSlots.push({
                            status: 'available',
                            ...appointment
                        })
                    }
                })

                this.$store.commit('setAllAppointmentSlots', allSlots)
            },

            onSelectSlot(selectedSlot) {
                if(this.isDisable) return

                // Check availability
                if (selectedSlot.status === 'unavailable') {
                    return
                }

                if (
                    this.vehicleType === 'unsure' &&
                    this.selectedDate != ''
                ) {
                    let selectedSaleExecutive = {}
                    _.map(this.saleExecutives, (saleExecutive) => {
                        _.map(this.existingAppointments, (appointment) => {
                            if(
                                saleExecutive.id !== appointment.user_id
                            ){
                                selectedSaleExecutive = {...saleExecutive}
                            }
                        })
                    })


                    this.$store.commit('setBookingSelectedSaleExecutive', selectedSaleExecutive)
                    this.$store.commit('setSelectedSlot', selectedSlot)
                }

                let totalSlot = []
                _.forEach(this.slots, (slot) => {
                    if (slot.slotId === selectedSlot.slotId) {
                        totalSlot.push({
                            ...slot,
                            status: 'selected'
                        })
                    } else {
                        if (slot.status === 'selected') {
                            totalSlot.push({
                                ...slot,
                                status: 'available'
                            })
                        } else {
                            totalSlot.push({...slot})
                        }
                    }
                })
                this.$store.commit('setSelectedSlot', selectedSlot)
                this.$store.commit('setAllAppointmentSlots', totalSlot)

                // Check sale person availability
                if (!this.selectedSaleExecutive.id) {
                    let saleExecutives = []
                    // Check date is selected or no
                    if (this.selectedDate === '') {
                        // not selected data, Iterate all date and check is user exists
                        const start = moment(this.event.start)
                        const end = moment(this.event.end)
                        const dates = fn.getDates(start, end, this.dealership)
                        _.map(this.saleExecutives, (saleExecutive) => {
                            let currentSaleExecutive = {...saleExecutive}

                            _.map(this.existingAppointments, (appointment) => {
                                const appointmentDate = moment(appointment.start).format('L')

                                _.map(dates, (date) => {
                                    const selectedDate = moment(date).format('L')
                                    if (
                                        selectedDate === appointmentDate &&
                                        saleExecutive.id === appointment.user_id &&
                                        selectedSlot.slotId === appointment.slot_id
                                    ) {
                                        currentSaleExecutive = {
                                            ...currentSaleExecutive,
                                            availability: false
                                        }
                                    } else {
                                        currentSaleExecutive = {
                                            ...currentSaleExecutive,
                                            availability: true
                                        }
                                    }
                                })

                            })

                            saleExecutives.push(currentSaleExecutive)
                        })

                    } else {
                        // selected date
                        _.map(this.saleExecutives, (saleExecutive) => {
                            let currentSaleExecutive = {...saleExecutive}

                            const foundAppointment = _.findIndex(this.existingAppointments, (appointment) => {
                                const selectedDate = moment(this.selectedDate).format('L')
                                const appointmentDate = moment(appointment.start).format('L')
                                if (
                                    selectedDate === appointmentDate &&
                                    saleExecutive.id === appointment.user_id &&
                                    selectedSlot.slotId === appointment.slot_id
                                ) {
                                    return appointment
                                }
                            })
                            if (foundAppointment === -1) {
                                currentSaleExecutive = {
                                    ...currentSaleExecutive,
                                    availability: true
                                }
                            } else {
                                currentSaleExecutive = {
                                    ...currentSaleExecutive,
                                    availability: false
                                }
                            }

                            saleExecutives.push(currentSaleExecutive)
                        })

                        // Update sale executive into store
                        this.$store.commit('setUsers', saleExecutives)
                    }
                }

            },

            onClick() {
                console.log(this.bringGuest)
            },

            onClearSlot() {
                this.onSelectSlot({})
                this.$store.commit('setSelectedSlot', {})
                this.generateSlots()
            },

            checkCascadeTime() {
                const selectedDate = this.selectedDate
                const selectedSaleExecutive = this.selectedSaleExecutive
                const selectedSlot = this.selectedSlot

                if (selectedSlot.start) {
                    return // do not run if time is taken
                }

                if (
                    !_.isEmpty(selectedDate) &&
                    selectedSaleExecutive.id
                ) {
                    const time = fn.getStartTimeEndTime(
                        moment(selectedDate).format('YYYY-MM-DD'),
                        this.dealership
                    )
                    const slots = fn.getTimeSlotsForDay(time, this.event)
                    let checkTimeForm = new FormData()
                    _.map(slots, (slot, key) => {
                        checkTimeForm.append(`slots[${key}][slotId]`, slot.slotId)
                        checkTimeForm.append(`slots[${key}][start]`, slot.start)
                        checkTimeForm.append(`slots[${key}][end]`, slot.end)
                    })
                    checkTimeForm.append('saleExecutiveId', selectedSaleExecutive.id)
                    checkTimeForm.append('selectedDate', selectedDate)

                    const URL = `/api/booking/${selectedSaleExecutive.id}/availability`
                    axios.post(URL, checkTimeForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setAllAppointmentSlots', response.data.slots)
                        }
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
                    })
                }
            }
        }
    }
</script>
