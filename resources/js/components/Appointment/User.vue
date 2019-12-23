<template>
    <v-container grid-list-sm fluid>
        <v-layout row wrap>
            <v-flex
                v-for="(date, n) in dates"
                :key="date"
                xs12
            >
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-toolbar :color="themeOption.toolbarColor"
                                   dense
                                   tabs
                                   dark>
                            <v-toolbar-title>{{ date|dateFormat('LL') }}</v-toolbar-title>
                            <v-spacer></v-spacer>

                            <v-btn icon>
                                <v-icon>calendar_today</v-icon>
                            </v-btn>
                        </v-toolbar>
                    </v-flex>

                    <v-flex xs12>
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
                appointmentUsers: 'getAppointmentUsers'
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
                const dates = this.getDates(start, end)
                this.dates = [...dates]
            },

            /**
             * Generate dates between start date & end dates
             * @param startDate
             * @param stopDate
             * @returns {[]}
             */
            getDates(startDate, stopDate) {
                let dateArray = [];
                let currentDate = startDate;
                while (currentDate <= stopDate) {
                    dateArray.push(moment(currentDate).format('YYYY-MM-DD'))
                    currentDate = moment(currentDate).add(1, 'days');
                }
                return dateArray;
            }
        }
    }
</script>
