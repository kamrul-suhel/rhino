<template>
    <v-dialog
        v-model="updatedScheduleDialog"
        width="500"
    >
        <v-card>
            <v-card-title
                class="headline"
                :style="{backgroundColor: themeOption.primaryColor, color: themeOption.primaryTextColor}"
                primary-title
            >
                <span :style="{color: themeOption.primaryTextColor}">
                    {{ `${trans.updateArrivedLeaveTime}` }}
                </span>
            </v-card-title>

            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs11 sm5>
                        <v-menu
                            ref="menu"
                            v-model="scheduledStartDialog"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="scheduledStart"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="scheduledStart"
                                    :label="trans.guestArrived"
                                    :color="themeOption.primaryColor"
                                    prepend-icon="access_time"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-time-picker
                                format="24hr"
                                :color="themeOption.primaryColor"
                                v-if="scheduledStartDialog"
                                v-model="scheduledStart"
                                full-width
                                @click:minute="$refs.menu.save(scheduledStart)"
                            ></v-time-picker>
                        </v-menu>
                    </v-flex>

                    <v-spacer></v-spacer>

                    <v-flex xs11 sm5>
                        <v-menu
                            ref="menu2"
                            v-model="scheduledEndDialog"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            :return-value.sync="scheduledEnd"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="scheduledEnd"
                                    :label="trans.guestLeave"
                                    :color="themeOption.primaryColor"
                                    prepend-icon="access_time"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-time-picker
                                format="24hr"
                                :color="themeOption.primaryColor"
                                v-if="scheduledEndDialog"
                                v-model="scheduledEnd"
                                full-width
                                @click:minute="$refs.menu2.save(scheduledEnd)"
                            ></v-time-picker>
                        </v-menu>
                    </v-flex>


                </v-layout>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    @color="themeOption.primaryColor"
                    flat
                    @click="onUpdateSchedule()"
                >
                    {{ trans.update }}
                </v-btn>

                <v-btn
                    @color="themeOption.primaryColor"
                    flat
                    @click="updatedScheduleDialog = false"
                >
                    {{ trans.cancel }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        components:{
        },

        data() {
            return {
                updatedScheduleDialog: false,
                scheduledStart: null,
                scheduledStartDialog: false,
                scheduledEnd: null,
                scheduledEndDialog: false
            }
        },

        props: {
            appointment:{
                type: Object,
                required: true,
                default:{}
            },
            dialog:{
                type: Boolean,
                required: true,
                default: false
            }
        },

        watch:{
            dialog(){
                if(this.dialog){
                    this.updatedScheduleDialog = true
                }
            },

            updatedScheduleDialog(){
                if(!this.updatedScheduleDialog){
                    this.$emit('onUpdateSchedule', false)
                }
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                slot: 'getAppointmentDialogSlot'
            }),
        }),

        created() {
            this.scheduledStart = this.appointment.scheduled_start !== 'null' ? moment(this.appointment.scheduled_start).format('HH:mm') :''
            this.scheduledEnd = this.appointment.scheduled_end !== 'null' ? moment(this.appointment.scheduled_end).format('HH:mm') :''
        },

        methods: {
            onUpdateSchedule(){
                let scheduleStart = `${moment(this.appointment.start).format('YYYY-MM-DD').toString()} ${this.scheduledStart}:00`
                let scheduleEnd = `${moment(this.appointment.end).format('YYYY-MM-DD').toString()} ${this.scheduledEnd}:00`

                let scheduleUpdateForm = new FormData();
                scheduleUpdateForm.append('type', 'scheduleUpdate')
                scheduleUpdateForm.append('scheduleStart', scheduleStart)
                scheduleUpdateForm.append('scheduleEnd', scheduleEnd)
                scheduleUpdateForm.append('_method', 'put')

                const URL = `/api/appointments/${this.appointment.id}/update`

                axios.post(URL, scheduleUpdateForm).then((response)=> {
                    this.$store.commit('setSnackbarMessage', {
                        openMessage: true,
                        timeOut: this.themeOption.snackBarTimeout,
                        message: `${this.trans.successfullyUpdated}`
                    })
                    this.updatedScheduleDialog = false
                }, error => {

                })
            }
        }
    }
</script>
