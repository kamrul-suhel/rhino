<template>
    <v-layout row wrap>
        <v-flex xs12>
            <div class="r-tab open no-title view-all">
                <div class="r-tab-content open">
                    <v-container fluid pa-0 grid-list-xl>
                        <div style="overflow-x:scroll; height: 600px; position: relative;">
                            <div class="flex-headers" style=" height:50px; border: solid 1px #cecece; position: sticky; top: 0;z-index: 10;">
                                    <div style="width: 200px; height: 100%; border-left: solid 1px #cecece; border-right: solid 1px #cecece; align-items: center; display: flex; justify-content: center; background: #616161; color: white">Date / slot</div>
                                    <div style="width: 200px; height: 100%; border-left: solid 1px #cecece; border-right: solid 1px #cecece; align-items: center; display: flex; justify-content: center; background: #616161; color: white"
                                         v-for="(user, index) in users" :key="index">
                                        {{ `${user.firstname} ${user.surname}` }}
                                    </div>
                            </div>

                            <div v-for="(date, index) in dates"
                                 :key="index"
                                 class="appointments">
                                <div v-for="(appointmentSlot, index) in initializeUserAppointment(date)" :key="index"
                                    style="display:flex; width:fit-content; position:relative; align-items:center; height: 48px;  border: solid 1px #cecece;">

                                    <div style="width: 200px; height: 48px; border-bottom: solid 1px #8f8f8f; text-align: center; position:sticky;left:0; background: #ddd">
                                        <strong style="margin-top:20px">{{ date|dateFormat('d m y')}}</strong> <br > {{ appointmentSlot.start|dateFormat('LT') }} - {{ appointmentSlot.end| dateFormat('LT') }}
                                    </div>

                                    <div class="flex-slots"
                                         style="width: 200px; height: 48px;; border-left: solid 1px #cecece; border-right: solid 1px #cecece; display: flex; justify-content: center; align-items: center"
                                         v-for="(user, index) in users"
                                         :key="index">
                                        <ViewAllAppointmentUser :appointmentSlot="appointmentSlot" :user="user">
                                        </ViewAllAppointmentUser>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-container>
                </div>
            </div>

            <div class="mobile-message">
                {{ trans.largeScreenSize }}
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

<style scoped>

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
