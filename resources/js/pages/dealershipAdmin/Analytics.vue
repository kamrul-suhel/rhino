<template>
    <v-container fluid px-5>
        <Overview></Overview>

        <v-layout row v-if="analyticsTotalGuest > 0">
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
    import Overview from "@/components/Analytics/Overview";

    export default {
        components: {
            Graph,
            Overview
        },

        data() {
            return {
                confirmedPercent: 0,
                confirmed: {
                    labels: ['Confirmed', 'Unconfirmed'],
                    datasets: [{
                        label: '# of Votes',
                        data: [0, 0],
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
                        data: [0, 0],
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
                        data: [0, 0],
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

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
                analyticsData: 'getAnalyticsData',
                analyticsTotalGuest: 'getAnalyticsTotalGuest',
                analyticGuestInfo: 'getAnalyticsTotalInfo'
            }),

            myStyles() {
                return {
                    height: `200px`,
                    position: 'relative'
                }
            },
        }),

        watch: {
            analyticsTotalGuest() {
                this.createConfirmedAppointmentsData()
            },

            analyticGuestInfo() {
                this.createConfirmedAppointmentsData()
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

            fetchAnalytics() {
                this.$store.dispatch('fetchAnalytics', {
                    eventId: this.$route.params.eventId
                });
            },

            /**
             * Confirm guest calculate
             */
            createConfirmedAppointmentsData() {
                if(this.analyticsTotalGuest <= 0){
                    return
                }
                const guestPending = this.analyticGuestInfo.pending ? this.analyticGuestInfo.pending : 0
                const totalGuest = this.analyticsTotalGuest ? this.analyticsTotalGuest : 0
                this.confirmedPercent = _.round(((totalGuest - guestPending) / totalGuest) * 100, 1)
                let unConfirmed = _.round((100 - this.confirmedPercent), 1)


                const confirmedData = [
                    this.confirmedPercent,
                    unConfirmed
                ]
                // Confirmed data set
                let modifyConfirmData = {}
                _.forOwn(this.confirmed, (value, key) => {
                    if (key === 'datasets') {
                        let datasets = []
                        _.map(value, (data) => {
                            datasets.push({
                                ...data,
                                data: [...confirmedData]
                            })
                        })
                        modifyConfirmData.datasets = [...datasets]
                    } else {
                        modifyConfirmData[key] = value
                    }
                })
                this.confirmed = {...modifyConfirmData}

                // Arrived data set
                const guestArrived = this.analyticGuestInfo.arrived ? this.analyticGuestInfo.arrived : 0
                this.madePercent = _.round(((guestArrived / totalGuest) * 100), 1)
                const unMadePercent = _.round((100 - this.madePercent), 1)
                const madeData = [
                    this.madePercent,
                    unMadePercent
                ]
                console.log('made data: ', madeData)

                let modifyMadeData = {}
                _.forOwn(this.made, (value, key) => {
                    if (key === 'datasets') {
                        let datasets = []
                        _.map(value, (data) => {
                            datasets.push({
                                ...data,
                                data: [...madeData]
                            })
                        })
                        modifyMadeData.datasets = [...datasets]
                    } else {
                        modifyMadeData[key] = value
                    }
                })
                this.made = {...modifyMadeData}


                // Sale made analytics
                const saleMade = this.analyticGuestInfo.sale_made ? this.analyticGuestInfo.sale_made : 0
                this.salesPercent = _.round(((saleMade / totalGuest) * 100), 1)
                const unSalePercent = _.round((100 - this.salesPercent), 1)
                const saleData = [
                    this.salesPercent,
                    unSalePercent
                ]

                let modifySaleData = {}
                _.forOwn(this.sales, (value, key) => {
                    if (key === 'datasets') {
                        let datasets = []
                        _.map(value, (data) => {
                            datasets.push({
                                ...data,
                                data: [...saleData]
                            })
                        })
                        modifySaleData.datasets = [...datasets]
                    } else {
                        modifySaleData[key] = value
                    }
                })
                this.sales = {...modifySaleData}
            }
        }

    }
</script>
