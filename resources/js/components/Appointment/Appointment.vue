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
                                label="Picker in menu"
                                prepend-icon="event"
                                readonly
                                v-on="on"
                            ></v-text-field>
                        </template>
                        <v-date-picker v-model="date"
                                       :color="themeOption.inputColor"
                                       no-title
                                       scrollable>
                            <v-spacer></v-spacer>
                            <v-btn flat
                                   :color="themeOption.buttonSecondaryColor"
                                   @click="menu = false"
                            >Cancel</v-btn>

                            <v-btn flat
                                   :color="themeOption.buttonPrimaryColor"
                                   @click="$refs.menu.save(date)"
                            >OK</v-btn>
                        </v-date-picker>
                    </v-menu>
                </v-card-text>
            </v-card>
        </v-flex>

        <v-flex xs12 md4 pl-2>
            <AddUser subComponent></AddUser>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";
    import AddUser from '@/components/Dealership/AddUser'

    export default {
        components:{
            AddUser
        },

        data(){
            return {
                date: null,
                menu: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedUser: 'getSelectedUser',
                selectedEvent: 'getSelectedEvent',
                update: 'getInitializeAppointment'
            })
        }),

        props:{

        },

        watch:{
            update(){
                console.log('update now generate appointment')
            }
        },

        created() {

        },

        methods:{

        }
    }
</script>
