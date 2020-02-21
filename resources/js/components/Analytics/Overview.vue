<template>
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
                <span>Appointment Show</span> <span class="text-xs-right">{{ analyticGuestInfo.arrived ? analyticGuestInfo.arrived : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between">
                <span>Appointment no show</span> <span class="text-xs-right">{{ analyticGuestInfo.no_show ? analyticGuestInfo.no_show : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between">
                <span>Sales made</span> <span class="text-xs-right">{{ analyticGuestInfo.sale_made ?  analyticGuestInfo.sale_made : 0 }}</span>
            </div>
        </v-flex>
    </v-layout>
</template>
<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                analyticsData: 'getAnalyticsData',
                analyticsTotalGuest: 'getAnalyticsTotalGuest',
                analyticGuestInfo: 'getAnalyticsTotalInfo'
            })
        }),

        created() {

        },

        methods: {}
    }
</script>
