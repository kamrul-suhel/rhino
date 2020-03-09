<template>
    <v-dialog
        v-model="dialog"
        width="800"
    >
        <v-card>
            <v-card-title
                class="headline"
                :style="{backgroundColor: themeOption.primaryColor, color: themeOption.primaryTextColor}"
                primary-title
            >
                <span :style="{color: themeOption.primaryTextColor}">
                    {{ `${selectedUser.firstname} ${selectedUser.surname}` }}
                </span>
            </v-card-title>

            <v-card-text>
                <v-container grid-list-md>

                    <v-layout row wrap>
                        <v-flex xs12 sm6>
                            <v-select
                                :items="saleExecutives"
                                item-text="firstname"
                                :color="themeOption.inputColor"
                                :label="`${trans.select} ${trans.sales_executive}`"
                                v-model="selectedSaleExecutive"
                                @change="onSelectSaleExecutive"
                                return-object
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 sm6>
                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        v-model="selectedDate"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.select} ${trans.date}`"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                    ></v-text-field>
                                </template>

                                <v-date-picker :color="themeOption.calenderToolbarColor"
                                               :show-current="currentDate"
                                               :allowed-dates="val => allowedDates.indexOf(val) !== -1"
                                               v-model="selectedDate"
                                               @input="menu = false">
                                </v-date-picker>
                            </v-menu>
                        </v-flex>

                        <v-flex xs12>
                            <v-layout row wrap class="assign-to-sale-executive">
                                <v-flex xs12 sm3
                                        v-for="slot in slots"
                                        :class="[slot.selected ? 'selected' : '', slot.status]"
                                        :key="slot.slotId">
                                    <v-card :hover="slot.status !== 'unavailable'"
                                            @click="onSelectSlot(slot)">
                                        <v-card-text>
                                            <v-flex xs12 text-xs-center>{{ slot.start | dateFormat('HH')}}</v-flex>
                                            <v-flex xs12 text-xs-center>{{ slot.end | dateFormat('HH')}}</v-flex>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    @color="themeOption.primaryColor"
                    :disabled="!selectedSlot.slotId"
                    flat
                    @click="onAssignAppointment()"
                >
                    {{ trans.assign }}
                </v-btn>

                <v-btn
                    @color="themeOption.primaryColor"
                    flat
                    @click="dialog = false"
                >
                    {{ trans.cancel }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UnavailableDialogContent from "./UnavailableDialogContent"
    import AvailableDialogContent from "./AvailableDialogContent"
    import fn from '@/utils/function'

    export default {
        components: {
            UnavailableDialogContent,
            AvailableDialogContent
        },

        data() {
            return {
                saleExecutives: [],
                selectedDate: new Date().toISOString().substr(0, 10),
                selectedSaleExecutive: {},
                allowedDates: [],
                selectedSlot: {},
                slots: [],
                currentDate: true,
                menu: false,
                modal: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                existingAppointments: 'getAppointments',
                appointment: 'getAssignToSaleExecutiveAppointment',
                users: 'getUsers',
                selectedEvent: 'getSelectedEvent',
                dealership: 'getSelectedDealership',
            }),

            dialog: {
                get: function () {
                    return this.$store.getters.getAssignToSaleExecutiveDialog
                }, set: function (value) {
                    this.$store.commit('setAssignToSaleExecutiveDialog', value)
                }
            }
        }),

        watch: {
            appointment() {
                this.setSaleExecutives()
            },

            selectedEvent() {
                this.generateAllowedDates()
            },

            dealership() {
                this.generateAllowedDates()
            },

            selectedDate() {
                this.selectedSlot = {}
                this.generateAppointmentSlot()
            }

        },
        created() {
            this.generateAllowedDates()
        },

        methods: {
            onSelectSaleExecutive() {
                this.selectedSlot = {}
                this.generateAppointmentSlot()
            },

            generateAllowedDates() {
                if (this.selectedEvent.id && this.dealership.id) {
                    this.allowedDates = [...fn.allowedDates(this.selectedEvent, this.dealership)]
                    this.currentDate = this.allowedDates[0]
                    this.selectedDate = this.allowedDates[0]
                }
            },

            setSaleExecutives() {
                this.saleExecutives = [...this.users]
            },

            generateAppointmentSlot() {
                if (this.selectedDate && this.selectedSaleExecutive.id) {
                    const time = fn.getStartTimeEndTime(this.selectedDate, this.dealership)
                    const slots = fn.getTimeSlotsForDay(time, this.selectedEvent)

                    let checkTimeForm = new FormData()
                    _.map(slots, (slot, key) => {
                        checkTimeForm.append(`slots[${key}][slotId]`, slot.slotId)
                        checkTimeForm.append(`slots[${key}][start]`, slot.start)
                        checkTimeForm.append(`slots[${key}][end]`, slot.end)
                    })
                    checkTimeForm.append('saleExecutiveId', this.selectedSaleExecutive.id)
                    checkTimeForm.append('selectedDate', this.selectedDate)

                    const URL = `/api/booking/${this.selectedSaleExecutive.id}/availability`
                    axios.post(URL, checkTimeForm).then((response) => {
                        if (response.data.success) {
                            this.slots = [...response.data.slots]
                        }
                    })
                }
            },

            onSelectSlot(slot) {
                if (slot.status === 'unavailable') {
                    return
                }
                let modifySlots = []
                _.map(this.slots, (currentSlot) => {
                    let modifySlot = {
                        ...currentSlot,
                        selected: false
                    }
                    if (currentSlot.slotId === slot.slotId) {
                        modifySlot = {
                            ...modifySlot,
                            selected: true
                        }

                        this.selectedSlot = {...modifySlot}
                    }
                    modifySlots.push(modifySlot)
                })

                this.slots = [...modifySlots]
            },

            onAssignAppointment() {
                let appointmentForm = new FormData()
                appointmentForm.append('delete_vehicle', false) // do not need to update appointment vehicle table
                _.forOwn(this.appointment, (value, key) => {
                    switch (key) {
                        case 'id':
                            appointmentForm.append('appointment_id', value)
                            break

                        case 'user_id':
                            appointmentForm.append('user_id', this.selectedSaleExecutive.id)
                            break

                        case 'start':
                            appointmentForm.append('start', this.selectedSlot.start)
                            break

                        case 'end':
                            appointmentForm.append('end', this.selectedSlot.end)
                            break

                        case 'slot_id':
                            appointmentForm.append('slot_id', this.selectedSlot.slotId)
                            break
                        default:
                            appointmentForm.append(key, value)
                    }
                })

                appointmentForm.append('_method', 'PUT')

                const appointmentId = this.appointment.id
                const URL = `/api/appointments/${appointmentId}`
                axios.post(URL, appointmentForm).then((response) => {
                    if (response.data.success) {
                        this.resetComponent()
                        this.$store.commit('setAssignToSaleExecutiveDialog', false)
                        this.$store.commit('setAppointmentAvailable', false)
                        this.$store.commit('setAppointmentUnavailable', false)
                        this.$store.commit('setAppointmentDialog', false)
                        this.$store.commit('setAppointmentDialogSlot', {})
                        this.$store.commit('setUpdateComponent')
                    }
                })
            },

            resetComponent() {
                this.saleExecutives = []
                this.selectedDate = this.allowedDates[0]
                this.selectedSaleExecutive = {}
                this.selectedSlot = {}
                this.slots = []
            }
        }
    }
</script>
