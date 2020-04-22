<template>
    <v-layout row wrap v-if="filterByDate">
        <v-flex xs12>
            <div class="r-tab open">
                <div class="r-tab-title">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">more_horiz
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.appointment}` }}
                    </div>
                    <div>
                        <v-icon
                            @click="onGoBack()"
                            :color="themeOption.adminNavIconColor">close
                        </v-icon>
                    </div>
                </div>

                <div class="r-tab-content open">
                    <v-container fluid pa-0 grid-list-xl>
                        <v-layout row wrap>
                            <v-flex xs6>
                                <h2>{{ date|dateFormat('LL') }}</h2>
                            </v-flex>

                            <v-flex xs6 class="text-xs-right">
                                <v-btn round
                                       :color="themeOption.adminNavIconColor"
                                       @click="onDownloadCSV()"
                                       class="ma-0">
                                    <span style="color:#fff;">{{ `${trans.download}` }}</span>
                                </v-btn>
                            </v-flex>

                            <v-flex xs12 v-for="(user, index) in users"
                                    :key="index">
                                <h2>{{ `${user.firstname} ${user.surname}` }}</h2>

                                <UserAppointment :date="date" :user="user"></UserAppointment>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </div>
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UserAppointment from './UserAppointment'

    export default {
        components: {
            UserAppointment
        },

        data() {
            return {
                isClose: false
            }
        },

        props: {
            date: {
                type: String,
                required: true
            },
            filterByDate: {
                type: Boolean,
                required: true,
                default: false
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
                users: 'getUsers'
            })
        }),

        created() {
        },

        methods: {
            onDownloadCSV(){
                this.$emit('onDownload', this.date)
            },

            onGoBack(){
                this.$emit('onGoBack')
            }
        }
    }
</script>
