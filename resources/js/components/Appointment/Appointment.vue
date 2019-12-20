<template>
    <v-layout row wrap>
        <v-flex xs12 md8>
            <v-card>
                <v-card-text>
                    <v-menu
                        ref="menu"
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        :return-value.sync="date"
                        lazy
                        transition="scale-transition"
                        offset-y
                        full-width
                        min-width="290px"
                    >
                        <template v-slot:activator="{ on }">
                            <v-text-field
                                :color="themeOption.inputColor"
                                v-model="date"
                                :label="`${trans.select} ${trans.date}`"
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="date"
                                       :date="date"
                                       :color="themeOption.inputColor"
                                       :min="selectedEvent.start"
                                       :max="selectedEvent.end"
                                       no-title
                                       scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat
                                   :color="themeOption.buttonSecondaryColor"
                                   @click="menu = false"
                            >{{ trans.cancel }}</v-btn>

                            <v-btn flat
                                   :color="themeOption.buttonPrimaryColor"
                                   @click="onChangeDate(date)"
                            >{{ trans.ok }}</v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-card-text>
            </v-card>

            <v-layout row wrap class="pt-3">
                <v-flex xs12>
                    <v-expansion-panel
                        v-model="appointmentOpen"
                        >
                        <v-expansion-panel-content
                            v-for="user in appointmentUsers"
                            :key="user.id"
                        >
                            <template v-slot:header>
                                <v-avatar
                                    class="appointmentAvatar"
                                    :tile="false"
                                    :size="36"
                                    color="grey lighten-4"
                                >
                                    <img :src="user.profile_image | image(themeOption.brandDefaultImage)">
                                </v-avatar>

                                <div>{{ user.firstname }}</div>
                            </template>

                           <appointment-user :user="user"></appointment-user>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-flex>
            </v-layout>
        </v-flex>

        <v-flex xs12 md4 pl-2>
            <AddUser subComponent
                model="appointment"
            ></AddUser>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";
    import AddUser from '@/components/Dealership/AddUser'
    import AppointmentUser from './User'

    export default {
        components:{
            AddUser,
            AppointmentUser
        },

        data(){
            return {
                date: null,
                menu: false,
                appointmentOpen: null
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedUsers: 'getUsers',
                selectedEvent: 'getSelectedEvent',
                update: 'getInitializeAppointment',
                appointmentUsers: 'getAppointmentUsers'
            })
        }),

        props:{

        },

        watch:{
            update(){
                console.log('update now generate appointment')
            },

            appointmentOpen(index){
                const user = {...this.selectedUsers[index]}
            },

            selectedEvent(){
                this.date = this.selectedEvent.start
            },

            selectedUsers(){
                this.$store.commit('setAppointmentUsers', this.selectedUsers)
            }
        },

        created() {

        },

        methods:{
            onChangeDate(date){
                this.$refs.menu.save(date)
                this.$store.commit('setAppointmentUsers', this.selectedUsers)
            }
        }
    }
</script>
