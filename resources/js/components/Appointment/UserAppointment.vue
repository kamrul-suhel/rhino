<template>
    <v-flex xs3>
        <v-card flat tile class="d-flex">
            <v-img
                :src="`https://picsum.photos/500/300?image=${1 * 5 + 10}`"
                :lazy-src="`https://picsum.photos/10/6?image=${1 * 5 + 10}`"
                aspect-ratio="1"
                class="grey lighten-2"
            >
                <template v-slot:placeholder>
                    <v-layout
                        fill-height
                        align-center
                        justify-center
                        ma-0
                    >
                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                    </v-layout>
                </template>
            </v-img>
        </v-card>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
        data(){
            return {

            }
        },

        props:{
          date: {
              type: String,
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
            })
        }),

        created() {

        },

        methods:{

        }
    }
</script>
