<template>
    <v-container grid-list-sm fluid>
        <v-layout row wrap>
            <v-flex
                v-for="(date, n) in dates"
                :key="date"
                v-if="selectedAppointmentDate == date || selectedAppointmentDate === null"
                xs12
            >
                <v-layout row wrap>
                    <v-flex xs12>
                        <h3>{{ date|dateFormat('dddd') }}, {{ date|dateFormat('LL') }} </h3>
                    </v-flex>

                    <v-flex xs12 v-if="isClosed(date)">
                        <h2>close date</h2>
                        <h2>{{ trans.close }}</h2>
                    </v-flex>

                    <v-flex xs12 v-else>
                        <user-appointment :date="date"></user-appointment>
                    </v-flex>
                </v-layout>

                <div class="pt-4"></div>
                <v-divider></v-divider>
                <div class="pt-4"></div>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
    import {mapGetters} from 'vuex'
    import UserAppointment from './UserAppointment'
    import fn from '@/utils/function'

    export default {
        data(){
            return {
                dates:[]
            }
        },

        components:{
          UserAppointment
        },

        props:{
          user:{
              type: Object,
              required: true
          }
        },

        computed:({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedUsers: 'getUsers',
                selectedEvent: 'getSelectedEvent',
                update: 'getInitializeAppointment',
                appointmentUsers: 'getAppointmentUsers',
                selectedAppointmentDate: 'getAppointmentDate'
            }),

        }),

        watch:{
            selectedEvent(){
            }
        },

        created() {
            this.generateDate()
        },

        methods:{
            generateDate(){
                const start = moment(this.selectedEvent.start)
                const end = moment(this.selectedEvent.end)
                const dates = fn.getDates(start, end, this.dealership)
                this.dates = [...dates]
            },

            /**
             * Get the open & close day based on dealership opening times
             * @param curDate
             * @returns {boolean}
             */
            isClosed(curDate){
                const date = `${moment(curDate).format('dddd').toLowerCase()}_start`
                if(this.dealership[date] === '00:00:00'){
                    return true
                }
                return false
            }
        }
    }
</script>
