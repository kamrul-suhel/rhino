<template>
    <v-layout row wrap>
        <v-flex xs12>
            <div class="r-tab open no-title view-all">
                <div class="r-tab-content open">
                    <v-container fluid pa-0 grid-list-xl>
                        <div style="overflow-x:auto;">
                        <table class="appointmentAllView" style="overflow-x:scroll;">
                            <tr>
                                <th class="w-200">Date / slot</th>
                                <th class="w-200" v-for="(user, index) in users" :key="index">
                                    {{ `${user.firstname} ${user.surname}` }}
                                </th>
                            </tr>

                            <tr v-for="date in dates" :key="date">
                                <td :colspan="users.length+1">
                                    <h4>{{ date|dateFormat('d M Y') }}</h4>
                                    <table style="width:100%;">
                                        <tr v-for="appointmentSlot in initializeUserAppointment(date)" style="display: flex;">
                                            <td class="w-200">
                                                {{ appointmentSlot.start|dateFormat('LT') }} - {{ appointmentSlot.end| dateFormat('LT') }}
                                            </td>

                                            <td class="w-200" v-for="user in users" :key="user.id">
                                                <ViewAllAppointmentUser :appointmentSlot="appointmentSlot" :user="user">
                                                </ViewAllAppointmentUser>
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </v-container>
                </div>
            </div>
            <div class="mobile-message">
                Please view on larger screen size
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UserAppointment from './UserAppointment'
    import fn from '@/utils/function'
    import UserAppointmentSlot from '@/components/Appointment/UserAppointmentSlot'
    import ViewAllAppointmentUser from "./ViewAllAppointmentUser";

    export default {
        components: {
            ViewAllAppointmentUser,
            UserAppointment,
            UserAppointmentSlot
        },

        data() {
            return {
                isClose: false,
                appointmentSlots: []
            }
        },

        props: {
            dates: {
                type: Array,
                required: true
            }
        },

        watch:{

        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedUsers: 'getUsers',
                selectedUser: 'getSelectedUser',
                selectedEvent: 'getSelectedEvent',
                update: 'getInitializeAppointment',
                appointmentUsers: 'getAppointmentUsers',
                existingAppointments: 'getAppointments',
                users: 'getUsers',
                selectedLanguage: 'getSelectedLanguage'
            })
        }),

        created() {
            this.initializeUserAppointment()
        },

        methods: {
            initializeUserAppointment(date) {
                const time = fn.getStartTimeEndTime(date, this.dealership)
                return [...fn.getTimeSlotsForDay(time, this.selectedEvent)]
            },


            onDownloadCSV(){
                this.$emit('onDownload', this.date)
            },

            onGoBack(){
                this.$emit('onGoBack')
            }
        }
    }
</script>

<style>

.view-all  {
    display:none!important
}
@media (min-width: 768px){
    .view-all  {
        display:block!important
    }


    .mobile-message { display: none;}
}

</style>
