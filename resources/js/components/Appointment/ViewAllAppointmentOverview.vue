<template>
    <p v-if="selectedEvent.id === appointment.event_id" style="margin-bottom: 0;padding: 10px; background: #a5e0a5; border-radius: 20px;">
        <span  @click="onAppointmentDetail()">
            <span v-if="appointment.status === 3">{{ `${trans.notAvailable}`}}</span>
            <span v-if="appointment.status === 4">{{ `${trans.breakTime}`}}</span>
            <span v-if="appointment.guest_id">{{ appointment.guest_first_name }} {{ appointment.guest_surname }}</span>
        </span>
    </p>
    <p v-else>
        <span>{{ trans.atOtherEvent }}</span>
    </p>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        components: {},

        data() {
            return {}
        },

        props: {
            appointment: {
                type: Object,
                required: true
            },

            user: {
                type: Object,
                required: false,
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
