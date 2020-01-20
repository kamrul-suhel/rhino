<template>
    <v-layout column
              class="book-step"
              v-if="vehicleType !== 'unsure'"
              align-center>
        <v-flex xs12>
            <h6 class="headline text-xs-center">
                {{ `${trans.choose} ${trans.a}` }} <b> {{ `${trans.time}`}} </b>
            </h6>
        </v-flex>

        <v-flex xs12>
            <v-layout row justify-end style="width:70%" class="mt-4">
                <v-flex>
                    <button :style="{color: color}"
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
                            <h6 class="body-2">{{ slot.start | dateFormat('HH')}}-<br>{{ slot.end | dateFormat('HH')}}
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
                        :label="`${trans.guest} ${trans.name}`"
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
                                        value="yes"
                                        v-model="guestInterestedYes"
                            ></v-checkbox>
                            <label class="body-2 mr-5 ml-2">{{ trans.yes }}</label>
                        </v-flex>
                        <v-flex>
                            <v-checkbox :color="color"
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
            },

            selectedSaleExecutive() {
                // generate slot
                this.generateSlots()
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                saleExecutives: 'getUsers',
                event: 'getSelectedEvent',
                dealership: 'getSelectedDealership',
                slots: 'getAllAppointmentSlot',
                vehicleType: 'getBookingVehicleType',
                selectedDate: 'getBookingSelectedDate',
                selectedSaleExecutive: 'getBookingSelectedSaleExecutive',
                existingAppointments: 'getAllBookingAppointments',
                bringGuest: 'getBookingBringGuest'
            })
        }),

        methods: {
            generateSlots() {
                const start = moment(this.event.start)
                const end = moment(this.event.end)
                const dates = fn.getDates(start, end, this.dealership)

                // If selected sale executive
                if (this.selectedSaleExecutive.id) {
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
                // Check availability
                if (selectedSlot.status === 'unavailable') {
                    return
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
                if(this.selectedSaleExecutive.id){
                    return
                }

            },

            onClick() {
                console.log(this.bringGuest)
            }
        }
    }
</script>
