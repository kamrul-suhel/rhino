<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-layout row wrap justify-center align-item-center mb-2>
                <v-avatar size="150">
                    <img :src="selectedUser.profile_image|image(themeOption.userDefaultImage)"/>
                </v-avatar>
            </v-layout>

            <v-layout row wrap justify-center align-item-center mb-2>
                <strong>{{ trans.email }}: </strong><span>{{ selectedUser.email }}</span>
            </v-layout>

            <v-layout row wrap justify-center align-item-center>
                <v-btn :color="themeOption.primaryColor"
                       @click="onBookAGuest('withoutUniqueCode')"
                       :style="{color: themeOption.primaryTextColor}">{{ `${trans.bookWithoutUniqueCode}`}}
                </v-btn>

                <v-btn :color="themeOption.primaryColor"
                       @click="onBookAGuest('withUniqueCode')"
                       :style="{color: themeOption.primaryTextColor}">{{ `${trans.bookWithUniqueCode}`}}
                </v-btn>

                <v-btn :color="themeOption.primaryColor"
                       @click="onAppointmentUnavailable(3)"
                       :style="{color: themeOption.primaryTextColor}">{{ trans.unavailable}}
                </v-btn>

                <v-btn :color="themeOption.primaryColor"
                       @click="onAppointmentUnavailable(4)"
                       :style="{color: themeOption.primaryTextColor}">{{ trans.breakTime}}
                </v-btn>
            </v-layout>
        </v-flex>

        <BookAGuestDialog :appointment="appointment" :existingGuest="existingGuest"></BookAGuestDialog>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import BookAGuestDialog from "@components/Appointment/BookAGuestDialog";
    export default {
        data() {
            return {
                existingGuest: true
            }
        },

        components:{
          BookAGuestDialog
        },

        props: {
            appointment: {
                type: Object,
                required: true
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                existingAppointments: 'getAppointments',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        created() {
        },

        methods: {
            onAppointmentUnavailable(type){
                // Make slot is unavailable
                let appointmentForm = new FormData()
                appointmentForm.append('user_id', this.selectedUser.id)
                appointmentForm.append('event_id', this.selectedEvent.id)
                appointmentForm.append('slot_id', this.appointment.slotId)
                appointmentForm.append('start', this.appointment.start)
                appointmentForm.append('end', this.appointment.end)
                appointmentForm.append('status', type)
                appointmentForm.append('date', this.appointment.start)

                axios.post('/api/booking', appointmentForm).then((response) => {
                    if(response.data.success){

                        this.$store.commit('setAppointmentAvailable', false)
                        this.$store.commit('setAppointmentUnavailable', false)
                        this.$store.commit('setAppointmentDialog', false)
                        this.$store.commit('setAppointmentDialogSlot', {})

                        this.$store.commit('setUpdateComponent')
                    }
                })
            },

            onBookAGuest(type){
                switch(type){
                    case 'withUniqueCode':
                        this.existingGuest = true
                        break

                    case 'withoutUniqueCode':
                        this.existingGuest = false
                        break
                }

                this.$store.commit('setBookAGuestDialog', true)
            }
        }
    }
</script>
