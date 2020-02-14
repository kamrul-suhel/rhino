<template>
    <v-container fluid px-5>
        <v-layout row py-5>
            <v-flex xs12 sm6 px-3>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments by online registration</span> <span class="text-xs-right">{{ analyticsData.online ? analyticsData.online : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments by telephone</span> <span class="text-xs-right">{{ analyticsData.phone ? analyticsData.phone : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments by email</span> <span class="text-xs-right">{{ analyticsData.email ? analyticsData.email : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments by social media</span> <span class="text-xs-right">{{ analyticsData.social ? analyticsData.social : 0}}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments by walk-in</span> <span class="text-xs-right">{{ analyticsData.walkin ? analyticsData.walkin : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments by SMS</span> <span class="text-xs-right">{{ analyticsData.sms ? analyticsData.sms : 0 }}</span>
                </div>
            </v-flex>
            <v-flex xs12 sm6 px-3>

                <div class="d-flex my-2 justify-between">
                    <span>Appointments by Prospecting</span> <span class="text-xs-right">{{ analyticsData.prospecting ? analyticsData.prospecting : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>New Customers</span> <span class="text-xs-right">{{ analyticsData.prosecting ? analyticsData.prospecting : 0 + analyticsData.walkin ? analyticsData.walkin : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointments confirmed</span> <span class="text-xs-right">{{ analyticGuestInfo.confirmed ? analyticGuestInfo.confirmed : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointment Show</span> <span class="text-xs-right">{{ analyticGuestInfo.show ? analyticGuestInfo.show : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Appointment no show</span> <span class="text-xs-right">{{ analyticGuestInfo.pending ? analyticGuestInfo.pending : 0 }}</span>
                </div>
                <v-divider class="pa-1"></v-divider>
                <div class="d-flex my-2 justify-between">
                    <span>Sales made</span> <span class="text-xs-right">{{ analyticGuestInfo.sale_made ?  analyticGuestInfo.sale_made : 0 }}</span>
                </div>
            </v-flex>
        </v-layout>

        <v-layout row >
            <v-flex xs12 sm4 class="text-xs-center">
                Confirmed Appointments
                <span class="graphNumber">{{confirmedPercent}}%</span>
                <graph :chartData="confirmed" :options="options" :styles="myStyles"></graph>
            </v-flex>
            <v-flex xs12 sm4 class="text-xs-center">
                Appointments Made
                <span class="graphNumber">{{madePercent}}%</span>
                <graph :chartData="made" :options="options" :styles="myStyles"></graph>
            </v-flex>
            <v-flex xs12 sm4 class="text-xs-center">
                Sales
                <span class="graphNumber">{{salesPercent}}%</span>
                <graph :chartData="sales" :options="options" :styles="myStyles"></graph>
            </v-flex>
        </v-layout>

    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import Graph from '@/components/Analytics/Graph'

    export default {

        data() {
            return {
                confirmedPercent: 0,
                confirmed: {
                    labels: ['Confirmed', 'Unconfirmed'],
                    datasets: [{
                        label: '# of Votes',
                        data: [50, 50],
                        backgroundColor: [
                            '#CDDEEA',
                            '#244252',
                        ],
                        borderColor: [
                            '#CDDEEA',
                            '#244252',
                        ],

                    }]
                },
                madePercent: 0,
                made: {
                    labels: ['Showed Up', 'Yet to appear'],
                    datasets: [{
                        label: '# of Votes',
                        data: [30, 70],
                        backgroundColor: [
                            '#CDDEEA',
                            '#244252',
                        ],
                        borderColor: [
                            '#CDDEEA',
                            '#244252',
                        ],

                    }]

                },
                salesPercent: 0,
                sales: {
                    labels: ['Sale', 'No Sale'],
                    datasets: [{
                        label: '# of Votes',
                        data: [50, 50],
                        backgroundColor: [
                            '#CDDEEA',
                            '#244252',
                        ],
                        borderColor: [
                            '#CDDEEA',
                            '#244252',
                        ],

                    }]

                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 85
                },
            }
        },

        components: {Graph},

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
                analyticsData: 'getAnalyticsData',
                analyticsTotalGuest: 'getAnalyticsTotalGuest',
                analyticGuestInfo: 'getAnalyticsTotalInfo'
            }),

            myStyles () {
                return {
                    height: `200px`,
                    position: 'relative'
                }
            },
        }),

        watch: {
            analyticsTotalGuest() {
                this.totalGuests()
            },
            analyticGuestInfo() {
                this.createConfirmedAppointmentsData()
                this.createAppointmentsMadeData()
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.analytics}`)
            this.$store.commit('setNavTitle', `${this.trans.analytics}`)
            this.fetchAnalytics()
        },

        mounted() {

        },

        methods: {
            totalGuests(){
                this.totalGuests = this.analyticsTotalGuest
            },

            fetchAnalytics() {
                this.$store.dispatch('fetchAnalytics', {
                    eventId: this.$route.params.eventId
                });
            },

            /**
             * Confirm guest calculate
             */
            createConfirmedAppointmentsData() {
                this.confirmedPercent = ((this.totalGuests - this.analyticGuestInfo.pending) / this.totalGuests) * 100
                this.confirmedPercent = this.confirmedPercent.toFixed(1)
                const arrayData = [this.confirmedPercent, 100-this.confirmedPercent]
                let modifyConfirmData = {}

                _.forOwn(this.confirmed, (value, key) => {
                    if(key === 'datasets'){
                        let datasets = []
                        _.map(value, (data) => {
                            datasets.push({
                                ...data,
                                data: [...arrayData]
                            })
                        })
                        modifyConfirmData.datasets = [...datasets]
                    }else{
                        modifyConfirmData[key] = value
                    }
                })

                this.confirmed = {...modifyConfirmData}
            },

            createAppointmentsMadeData() {

            },

            createSalesData() {

            },
        }

    }
</script>
