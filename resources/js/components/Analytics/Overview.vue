<template>
    <v-layout row wrap py-md-5 justify-space-between class="analyticsMetrics">
        <v-flex xs12 sm5 px-md-3>
            <div class="d-flex my-2  metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.onlineRegistration}` }}</span> <span class="text-xs-right">{{ analyticsData.online ? analyticsData.online : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.telephone}` }}</span> <span class="text-xs-right">{{ analyticsData.phone ? analyticsData.phone : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.email}` }}</span> <span class="text-xs-right">{{ analyticsData.email ? analyticsData.email : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.social_media}` }}</span> <span class="text-xs-right">{{ analyticsData.social ? analyticsData.social : 0}}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.walk_in}` }}</span> <span class="text-xs-right">{{ analyticsData.walkin ? analyticsData.walkin : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.sms}` }}</span> <span class="text-xs-right">{{ analyticsData.sms ? analyticsData.sms : 0 }}</span>
            </div>
        </v-flex>
        <v-flex xs12 sm5 px-md-3>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.by} ${trans.prospecting}` }}</span> <span class="text-xs-right">{{ analyticsData.prospecting ? analyticsData.prospecting : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.new_customers}` }}</span> <span class="text-xs-right">{{ analyticsData.prosecting ? analyticsData.prospecting : 0 + analyticsData.walkin ? analyticsData.walkin : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointments} ${trans.confirmed}` }}</span> <span class="text-xs-right">{{ analyticGuestInfo.confirmed ? analyticGuestInfo.confirmed : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointment} ${trans.show}` }}</span> <span class="text-xs-right">{{ analyticGuestInfo.arrived ? analyticGuestInfo.arrived : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.appointment} ${trans.noShow}` }}</span> <span class="text-xs-right">{{ analyticGuestInfo.no_show ? analyticGuestInfo.no_show : 0 }}</span>
            </div>
            <v-divider class="pa-1"></v-divider>
            <div class="d-flex my-2 justify-between metric">
                <span>{{ `${trans.salesMade}` }}</span> <span class="text-xs-right">{{ analyticGuestInfo.sale_made ?  analyticGuestInfo.sale_made : 0 }}</span>
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
