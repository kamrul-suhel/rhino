<template>
    <v-container fluid px-5>
        <v-layout row wrap>
            <v-flex xs12>
                <v-data-table
                    hide-headers
                    :items="appointmentsTable"
                    hide-actions
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <tr>
                            <td><strong>{{ trans.surName }}:</strong> {{ guest.surname }}</td>
                            <td class="text-xs-left"> <strong>{{ trans.firstName }}:</strong> {{ guest.first_name }}</td>
                        </tr>

                        <tr>
                            <td><strong>{{ trans.email }}:</strong> {{ guest.email }}</td>
                            <td class="text-xs-left"><strong>{{ trans.mobile }}:</strong> {{ guest.mobile }}</td>
                        </tr>

                        <tr>
                            <td><strong>{{ trans.postcode }}:</strong> {{ guest.postcode }}</td>
                            <td class="text-xs-left"><strong>{{ trans.landline }}:</strong> {{ guest.landline }}</td>
                        </tr>

                        <tr>
                            <td><strong>{{ `${trans.address_line} 1` }}:</strong> {{ guest.address_line_1 }}</td>
                            <td class="text-xs-left"><strong>{{ `${trans.landline} 2` }}:</strong> {{ guest.address_line_2 }}</td>
                        </tr>
                    </template>
                </v-data-table>
            </v-flex>

            <v-flex xs12 class="mt-5">
                <h2 class="mb-2">{{ trans.appointments }}</h2>

                <v-layout row wrap>
                    <v-flex xs12
                            v-for="appointment in guest.appointment"
                            :key="appointment.id">
                        <v-card>
                            <v-card-title>
                                <strong>{{ trans.name }}:</strong> {{ appointment.event.event_name}}
                                <v-spacer></v-spacer>
                                <strong>{{ trans.status }}: </strong> {{ getAppointmentStatus(appointment) }}
                            </v-card-title>

                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs6>
                                        <strong>{{ trans.start }}:</strong> {{ appointment.start|dateFormat('LLLL') }}
                                    </v-flex>

                                    <v-flex xs6>
                                        <strong>{{ trans.end }}:</strong> {{ appointment.end|dateFormat('LLLL') }}
                                    </v-flex>
                                </v-layout>

                                <v-divider class="my-2"></v-divider>

                                <v-layout row wrap>
                                    <v-flex xs6>
                                        <strong>{{ trans.sales_executive }}:</strong> {{ `${appointment.user.firstname} ${appointment.user.surname}`}}
                                    </v-flex>

                                    <v-flex xs5>
                                        <strong>{{ trans.email }}</strong>{{ appointment.user.email }}
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                            <v-divider light></v-divider>

                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn :color="themeOption.primaryColor"
                                       flat
                                       v-if="appointment.status === 1"
                                       @click="onCancel(appointment)">
                                    <span :style="{color: themeOption.primaryColor}">{{ `${trans.cancel} ${trans.appointment}` }}</span>
                                </v-btn>

                                <v-btn :color="themeOption.primaryColor"
                                       flat
                                       v-if="appointment.status === 6"
                                       @click="onReebok(appointment)">
                                    <span :style="{color: themeOption.primaryColor}">
                                        {{ `${trans.reebok} ${trans.appointment}` }}
                                    </span>
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-flex>
        </v-layout>


        <v-dialog
            v-model="dialog"
            width="500"
        >
            <v-card>
                <v-card-title
                    class="headline"
                    :style="{backgroundColor: themeOption.primaryColor, color: themeOption.primaryTextColor}"
                    primary-title
                >
                <span :style="{color: themeOption.primaryTextColor}">
                    {{ `${dialogTitle}` }}
                </span>
                </v-card-title>

                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout row wrap>
                            <v-flex xs12 sm6 class="text-xs-center">
                                {{ dialogDescription }}
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        @color="themeOption.primaryColor"
                        flat
                        @click="onConfirmAction('confirmedCancel')"
                    >
                        {{ `${trans.confirmed} ${trans.cancel}` }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {

        data() {
            return {
                appointmentsTable: [
                    {
                        name: ''
                    }
                ],
                dialog: false,
                dialogTitle: null,
                dialogDescription: null,
                selectedAppointment: {}
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                guest: 'getGuestDetail'
            })
        }),

        watch: {

        },

        created() {
            this.initialize()
        },

        mounted() {

        },

        methods: {
            initialize(){
                this.$store.dispatch('fetchGuestDetailInfo', {guestId: this.$route.params.guestId})
            },

            getAppointmentStatus(appointment){
                return fn.appointmentStatusString(appointment, this.trans)
            },

            onCancel(appointment){
                this.dialogTitle = `${this.trans.cancel} ${this.trans.appointment}`
                // this.dialogDescription = `${this.trans.}`
                this.selectedAppointment = {...appointment}
                this.dialog = true
            },

            onReebok(appointment){
                this.selectedAppointment = {...appointment}
                this.dialog = true
            },

            onConfirmAction(type){

            }
        }
    }
</script>
