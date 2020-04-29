<template>
    <v-layout row wrap justify-center align-center>
        <v-flex xs12 v-if="selectedEvent.id === appointment.event_id">
            <div class="appointment-button disable"
                 @click="onAppointmentDetail()">
                <span v-if="appointment.status === 3">{{ `${trans.notAvailable}`}}</span>
                <span v-if="appointment.status === 4">{{ `${trans.breakTime}`}}</span>
                <span v-if="appointment.status === 1">
                    <span v-if="appointment.guest_id">
                        {{ appointment.guest_first_name }} {{ appointment.guest_surname }}
                        {{ appointment.scheduled_start && appointment.scheduled_end ? '*' : ''  }}
                    </span>
                </span>
            </div>
        </v-flex>

        <v-flex xs12 v-else>
            <div class="appointment-button disable">
                <span>{{ trans.atOtherEvent }}</span>
            </div>
        </v-flex>
    </v-layout>
    <!-- unavailable -->
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        components: {

        },

        data() {
            return {

            }
        },

        props: {
            appointment: {
                type: Object,
                required: true
            },

            user:{
                type:Object,
                required:false,
                default: null
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
            onAppointmentDetail(){
                if(this.user){
                    this.$store.commit('setSelectedUser', this.user)
                }

                this.$store.commit('setAppointmentAvailable', false)
                this.$store.commit('setAppointmentUnavailable', true)
                this.$store.commit('setAppointmentDialog', true)
                this.$store.commit('setAppointmentDialogSlot', this.appointment)
            }
        }
    }
</script>
