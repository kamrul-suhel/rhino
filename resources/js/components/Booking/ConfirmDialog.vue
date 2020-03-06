<template>
    <v-dialog
        v-model="dialog"
        width="500"
    >
        <v-card>
            <v-card-title
                class="headline"
                :style="{backgroundColor: color}"
                primary-title
            >
                <span :style="{color: '#fff'}">
                    {{ trans.thankYou }}
                </span>
            </v-card-title>

            <v-card-text class="text-xs-center">
                {{ trans.yourReservationConfirmed|capitalize }}
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    @color="themeOption.primaryColor"
                    flat
                    @click="onDialogStatusChange()"
                >
                    {{ trans.ok }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
            }
        },

        props: {
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                color: 'getFrontendColor'
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
            onDialogStatusChange(){
                this.dialog = false

            }
        }
    }
</script>
