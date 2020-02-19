<template>
    <v-card flat
        tile>
        <v-card-text class="appointmentSlot">
            <div>{{ appointmentSlot.start|dateFormat('LT', 'en') }} -  {{ appointmentSlot.end| dateFormat('LT', 'en') }}</div>
        </v-card-text>

        <v-card-actions>
            <v-layout v-if="checkAvailability(appointmentSlot)"
                      row
                      wrap
                      justify-center
                      align-center>
                <v-flex xs12>
                    <div class="appointment-button available">Available</div>
                </v-flex>
            </v-layout>
             <!-- Available slot -->

            <v-layout v-else row wrap justify-center align-center>
                <v-flex xs12>
                    <div class="appointment-button disable">
                        {{ `${appointment.guest_first_name} ${appointment.guest_surname}`}}
                    </div>
                </v-flex>
            </v-layout>
            <!-- unavailable -->
        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                appointment:{}
            }
        },

        props: {
            appointmentSlot: {
                type: Object,
                required: true
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                existingAppointments: 'getAppointments'
            })
        }),

        created() {
        },

        methods: {
            checkAvailability(currentSlot){
                const selectedUser = {...this.selectedUser}
                let isSlotAvailable = true

                if (this.existingAppointments.length > 0) {
                    _.map(this.existingAppointments, (appointment) => {
                        if (
                            appointment.start === currentSlot.start &&
                            selectedUser.id === appointment.user_id
                        ) {
                            this.appointment = {...appointment}
                            isSlotAvailable = false
                        }
                    })
                    return isSlotAvailable

                }else{
                    return isSlotAvailable
                }
            }
        }
    }
</script>
