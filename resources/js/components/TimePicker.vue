<template>
    <v-layout row wrap pt-3>
        <v-flex xs11 sm5>
            <v-layout row wrap align-center class="pa-0">
                <v-flex xs4>
                    <label for="">{{ `${trans.monday} ${trans.start}` }}</label>
                </v-flex>
                <v-flex xs4>
                    <v-select :items="hours" 
                        v-model="mondayStart.hours"
                        :label="`${trans.Hours}`">
                    </v-select>
                </v-flex>
                <v-flex xs4>
                    <v-select :items="minutes" 
                        v-model="mondayStart.minutes"
                        :label="`${trans.minutes}`">
                    </v-select>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex xs11 sm5>
            <v-layout row wrap align-center class="pa-0">
                <v-flex xs4>
                    <label for="">{{ `${trans.monday} ${trans.end}` }}</label>
                </v-flex>
                <v-flex xs4>
                    <v-select :items="hours" 
                        v-model="mondayEnd.hours"
                        :label="`${trans.Hours}`">
                    </v-select>
                </v-flex>
                <v-flex xs4>
                    <v-select :items="minutes" 
                        v-model="mondayEnd.minutes"
                        :label="`${trans.minutes}`">
                    </v-select>
                </v-flex>
            </v-layout>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="mondayStart"
                v-model="mondayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.monday_start"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        :color="themeOption.inputColor"
                        v-model="dealership.monday_start"
                        :label="`${trans.monday} ${trans.start}`"
                        prepend-icon="access_time"
                        readonly
                        :rules="[v => !!v || `${trans.selectATime}`]"
                        required
                        v-on="on"
                    ></v-text-field>
                </template>

                <v-time-picker
                    v-if="mondayStart"
                    :header-color="themeOption.timePickerHeaderColor"
                    v-model="dealership.monday_start"
                    format="24hr"
                    full-width
                    @click:minute="$refs.mondayStart.save(dealership.monday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>
        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="mondayEnd"
                v-model="mondayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.monday_end"
                lazy
                transition="scale-transition"
                offset-y
                full-width
                max-width="290px"
                min-width="290px"
            >
                <template v-slot:activator="{ on }">
                    <v-text-field
                        :color="themeOption.inputColor"
                        v-model="dealership.monday_end"
                        :label="`${trans.monday} ${trans.end}`"
                        prepend-icon="access_time"
                        readonly
                        :rules="[v => !!v || `${trans.selectATime}`]"
                        required
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    :header-color="themeOption.timePickerHeaderColor"
                    v-if="mondayEnd"
                    format="24hr"
                    v-model="dealership.monday_end"
                    full-width
                    @click:minute="$refs.mondayEnd.save(dealership.monday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import dealership from "../store/modules/dealership";

    export default {
        data() {
            return {
                mondayStart: {
                    hours: '00',
                    minutes: '00'
                },
                mondayEnd: {
                    hours: 0,
                    minutes: 0
                },
                tuesdayStart: {
                    hours: 0,
                    minutes: 0
                },
                tuesdayEnd: {
                    hours: 0,
                    minutes: 0
                },
                wednesdayStart: {
                    hours: 0,
                    minutes: 0
                },
                wednesdayEnd: {
                    hours: 0,
                    minutes: 0
                },
                thursdayStart: {
                    hours: 0,
                    minutes: 0
                },
                thursdayEnd: {
                    hours: 0,
                    minutes: 0
                },
                fridayStart: {
                    hours: 0,
                    minutes: 0
                },
                fridayEnd: {
                    hours: 0,
                    minutes: 0
                },
                saturdayStart: {
                    hours: 0,
                    minutes: 0
                },
                saturdayEnd: {
                    hours: 0,
                    minutes: 0
                },
                sundayStart: {
                    hours: 0,
                    minutes: 0
                },
                sundayEnd: {
                    hours: 0,
                    minutes: 0
                },


                hours: [
                    '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', 
                    '12', '13', '14', '15', '16', '17', '18', '19', '20','21', '22', '23' 
                ],
                minutes: [
                    '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', 
                    '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', 
                    '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'
                ],
            }
        },

        props:{
            dealership: Object
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        }),

        watch: {
            dealership(){
                this.$emit('sendTimes', this.dealership)
            
                const mondayStart = this.dealership.monday_start.split(":")
                console.log(mondayStart);
                
                this.mondayStart = {
                        hours: mondayStart[0],
                        minutes: mondayStart[1]
                    }
                console.log(this.mondayStart);
                
            }
        },

        created() {
            // this.generateTimes();
        },

        methods: {
            // TODO need to make dynamic
            generateTimes() {
                const times = [
                    {
                        label: `${trans.monday} ${trans.start}`,
                        ref: 'mondayStart',
                        value: ''
                    },
                    {
                        label: `${trans.monday} ${trans.end}`,
                        ref: 'mondayEnd',
                        value: ''
                    },
                    {
                        label: `${trans.tuesday} ${trans.start}`,
                        ref: 'tuesdayStart',
                        value: ''
                    },
                    {
                        label: `${trans.tueday} ${trans.end}`,
                        ref: 'tuesdayEnd',
                        value: ''
                    },
                    {
                        label: `${trans.wednesday} ${trans.start}`,
                        ref: 'wednesdayStart',
                        value: ''
                    },
                    {
                        label: `${trans.wednesday} ${trans.end}`,
                        ref: 'wednesdayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: `${trans.thursday} ${trans.start}`,
                        ref: 'thursdayStart',
                        value: ''
                    },
                    {
                        label: `${trans.thursday} ${trans.end}`,
                        ref: 'thursdayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: `${trans.friday} ${trans.start}`,
                        ref: 'fridayStart',
                        value: ''
                    },
                    {
                        label: `${trans.friday} ${trans.end}`,
                        ref: 'fridayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: `${trans.saturday} ${trans.start}`,
                        ref: 'saturdayStart',
                        value: ''
                    },
                    {
                        label: `${trans.saturday} ${trans.end}`,
                        ref: 'saturdayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: `${trans.sunday} ${trans.start}`,
                        ref: 'sundayStart',
                        value: ''
                    },
                    {
                        label: `${trans.sunday} ${trans.end}`,
                        ref: 'sundayEnd',
                        value: ''
                    }
                ]

                this.times = [...times]
            },
        }
    }
</script>
