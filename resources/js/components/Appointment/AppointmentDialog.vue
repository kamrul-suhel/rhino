<template>
    <v-dialog
        v-model="dialog"
        width="500"
    >
        <v-card>
            <v-card-title
                class="headline"
                :style="{backgroundColor: themeOption.primaryColor, color: themeOption.primaryTextColor}"
                primary-title
            >
                <span :style="{color: themeOption.primaryTextColor}">
                    {{ `${selectedUser.firstname} ${selectedUser.surname}` }}
                </span>
            </v-card-title>

            <v-card-text>
                <template v-if="available">
                    <AvailableDialogContent :appointment="slot"></AvailableDialogContent>
                </template>

                <template v-if="unAvailable">
                    <UnavailableDialogContent :appointment="slot" ></UnavailableDialogContent>
                </template>

            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    @color="themeOption.primaryColor"
                    flat
                    @click="dialog = false"
                >
                    {{ trans.cancel }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UnavailableDialogContent from "./UnavailableDialogContent"
    import AvailableDialogContent from "./AvailableDialogContent"

    export default {
        components:{
            UnavailableDialogContent,
            AvailableDialogContent
        },

        data() {
            return {
                appointment:{}
            }
        },

        props: {
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedUser: 'getSelectedUser',
                existingAppointments: 'getAppointments',
                available: 'getAppointmentAvailable',
                unAvailable: 'getAppointmentUnavailable',
                slot: 'getAppointmentDialogSlot'
            }),

            dialog: {
                get: function(){
                    return this.$store.getters.getAppointmentDialog
                }, set: function(value){
                    this.$store.commit('setAppointmentDialog', value)
                }
            }
        }),

        created() {
        },

        methods: {
        }
    }
</script>
