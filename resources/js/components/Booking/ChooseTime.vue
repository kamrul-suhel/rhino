<template>
    <v-layout column
              class="book-step"
              v-if="vehicleType !== 'unsure'"
              align-center>
        <v-flex xs12>
            <h6 class="headline text-lg-center">
                {{ `${trans.choose} ${trans.a} ${trans.time}`}}
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
                    <v-flex xs6 md3
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
                                    <h6 class="body-2">{{ slot.start | dateFormat('HH')}}-<br>{{ slot.end | dateFormat('HH')}}</h6>
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
                        outline
                        style="width:100%"
                    ></v-text-field>
                </v-flex>

                <v-flex xs12>
                    <h6 class="body-2" style="width:100%">
                        {{ trans.mightYourGuestAlsoBeInterested }}
                    </h6>

                    <v-checkbox class="mt-1" style="flex-grow:0"
                    ></v-checkbox>

                    <label class="body-2 mt-2 mr-5">{{ trans.yes }}</label>
                    <v-checkbox class="mt-1" style="flex-grow:0"
                    ></v-checkbox>

                    <label class="body-2 mt-2 mr-4">{{ trans.no }}</label>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {
        data(){
            return {
            }
        },

        created(){
        },

        watch: {
            event(){
                this.generateSlots()
            },

            selectedDate(){
                // generate slot
                this.generateSlots()
            },

            selectedSaleExecutive(){
                // generate slot
                console.log('generate slot')
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
                vehicleType : 'getBookingVehicleType',
                selectedDate : 'getBookingSelectedDate',
                selectedSaleExecutive: 'getBookingSelectedSaleExecutive',
                existingAppointments: 'getAllBookingAppointments'
            })
        }),

        methods:{
            generateSlots(){
                const start = moment(this.event.start)
                const end = moment(this.event.end)
                const dates = fn.getDates(start, end, this.dealership)

                // If select sale executive
                if(this.selectedSaleExecutive.id){
                    // get the user existing appointments
                    const existingAppointments = _.filter(this.existingAppointments, (existingAppointment) => {
                        return existingAppointment.user_id === this.selectedSaleExecutive.id
                    })

                    if(this.selectedDate === ''){
                        let appointmentSlots = []
                        // not selected date, iterate all open date
                        _.forEach(dates, (date)=>{
                            const time = fn.getStartTimeEndTime(date, this.dealership)

                            const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                            appointmentSlots.push([...daysSlot])
                        })

                        console.log('Appointment slot in array: ', appointmentSlots)
                    }else{
                        // selected date
                    }
                    return
                }

                let appointmentSlots = []
                let allSlots = []
                let appointments = []

                // Check if selected date is set
                if(this.selectedDate === ''){
                    _.forEach(dates, (date)=>{
                        const time = fn.getStartTimeEndTime(date, this.dealership)

                        const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                        appointmentSlots.push([...daysSlot])
                    })

                    appointments = [..._.flatten(appointmentSlots)]
                }else{
                    const time = fn.getStartTimeEndTime(this.selectedDate, this.dealership)
                    const daysSlot = fn.getTimeSlotsForDay(time, this.event)
                    appointments = [...daysSlot]
                }

                this.$store.commit('setAllAppointmentTime', appointments)

                _.forEach(appointments, (appointment) => {
                    if(allSlots.length > 0){
                        const found = _.find(allSlots, {slotId: appointment.slotId})
                        if(typeof found === 'undefined'){
                            allSlots.push({
                                status: 'available',
                                ...appointment
                            })
                        }
                    }else{
                        allSlots.push({
                            status: 'available',
                            ...appointment
                        })
                    }
                })

                this.$store.commit('setAllAppointmentSlots', allSlots)
            },

            onSelectSlot(selectedSlot){
                let totalSlot = []
                _.forEach(this.slots, (slot) => {
                    if(slot.slotId === selectedSlot.slotId){
                        totalSlot.push({
                            ...slot,
                            status: 'selected'
                        })
                    }else{
                        if(slot.status === 'selected'){
                            totalSlot.push({
                                ...slot,
                                status: 'available'
                            })
                        }else{
                            totalSlot.push({...slot})
                        }
                    }
                })
                this.$store.commit('setSelectedSlot', selectedSlot)
                this.$store.commit('setAllAppointmentSlots', totalSlot)
            }
        }
    }
</script>
