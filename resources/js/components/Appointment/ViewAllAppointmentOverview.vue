<template>
    <p>
        <span v-if="appointment.status === 3">{{ `${trans.notAvailable}`}}</span>
        <span v-if="appointment.status === 4">{{ `${trans.breakTime}`}}</span>
        <span v-if="appointment.status === 1">{{ `${trans.confirmed}`}}</span>
        <span v-if="appointment.guest_id">{{ appointment.guest_first_name }}</span>
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
            console.log('appointment status: ', this.appointment.status)
        },

        methods: {
        }
    }
</script>
