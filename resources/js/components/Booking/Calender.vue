<template>
    <v-layout row wrap
              align-center
              class="book-step calenderComponent"
              style="border-right: 1px solid rgb(240,240,240)">
        <v-layout style="flex-grow:0">
            <v-flex xs12>
                <h6 class="headline text-lg-center">{{ selectedEvent.start | dateFormat('MMMM')}} <b>{{
                    selectedEvent.start | dateFormat('YYYY')}}</b></h6>

                <label class="caption text-lg-center font-weight-bold ml-2 mt-1"
                       :style="{color:color}">
                    {{ selectedEvent.start | dateFormat('MMMM Do')}} -
                    {{ selectedEvent.end | dateFormat('MMMM Do') }}
                </label>
            </v-flex>
        </v-layout>

        <v-layout row wrap
                  style="width:70%; flex-grow:0"
                  class="mt-4">
            <v-flex xs4>
                <label class="body-2">
                    {{ trans.available }}
                    {{ trans.dates }}
                </label>
            </v-flex>

            <v-flex xs4>
                <div style="width:12px;height:12px;border:1px solid rgb(100,0,0); border-radius:6px; margin:4px"></div>
                <label class="body-2 ml-2">
                    {{ trans.no }}
                    {{ trans.available }}
                    {{ trans.times }}
                </label>
            </v-flex>

            <v-flex xs4>
                <div
                    style="width:12px;height:12px; background-color:rgb(160,160,160); border-radius:6px; margin:4px"></div>

                <v-layout justify-end>
                    <button :style="{color:color}" style="opacity:0.7">{{ trans.clear }}</button>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout row wrap>
            <v-flex xs12>
                <v-date-picker
                    class="calender mt-3"
                    full-width
                    no-title
                    :color="color"
                    v-model="selectedDate"
                    :allowed-dates="val => allowDates.indexOf(val) !== -1"
                    :min="selectedEvent.start"
                    :max="selectedEvent.end"
                ></v-date-picker>
            </v-flex>
        </v-layout>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {
        data() {
            return {
                type: 'month',
                selectedDate: '',
                allowDates:[]
            }
        },

        created() {
        },

        watch: {

            selectedDate() {
                this.$store.commit('setBookingSelectedDate', this.selectedDate)
            },

            selectedEvent(){
                this.allowedDates()
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                color: 'getFrontendColor',
                selectedEvent: 'getSelectedEvent',
                dealership: 'getSelectedDealership'
            })
        }),

        methods: {
            allowedDates() {
                let start = moment(this.selectedEvent.start)
                let end = moment(this.selectedEvent.end)

                const dates = fn.getDates(start, end, this.dealership)
                this.allowDates = [...dates]
            }
        }
    }
</script>
