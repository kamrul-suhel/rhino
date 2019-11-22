<template>
    <v-layout row wrap pt-3>
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
                        :label="trans.monday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>

                <v-time-picker
                    v-if="mondayStart"
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
                        :label="trans.monday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="mondayEnd"
                    format="24hr"
                    v-model="dealership.monday_end"
                    full-width
                    @click:minute="$refs.mondayEnd.save(dealership.monday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="tuesdayStart"
                v-model="tuesdayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.tuesday_start"
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
                        v-model="dealership.tuesday_start"
                        :label="trans.tuesday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="tuesdayStart"
                    format="24hr"
                    v-model="dealership.tuesday_start"
                    full-width
                    @click:minute="$refs.tuesdayStart.save(dealership.tuesday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="tuesdayEnd"
                v-model="tuesdayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.tuesday_end"
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
                        v-model="dealership.tuesday_end"
                        :label="trans.tuesday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="tuesdayEnd"
                    format="24hr"
                    v-model="dealership.tuesday_end"
                    full-width
                    @click:minute="$refs.tuesdayEnd.save(dealership.tuesday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="wednesdayStart"
                v-model="wednesdayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.wednesday_start"
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
                        v-model="dealership.wednesday_start"
                        :label="trans.wednesday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="wednesdayStart"
                    format="24hr"
                    v-model="dealership.wednesday_start"
                    full-width
                    @click:minute="$refs.wednesdayStart.save(dealership.wednesday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="wednesdayEnd"
                v-model="wednesdayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.wednesday_end"
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
                        v-model="dealership.wednesday_end"
                        :label="trans.wednesday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="wednesdayEnd"
                    format="24hr"
                    v-model="dealership.wednesday_end"
                    full-width
                    @click:minute="$refs.wednesdayEnd.save(dealership.wednesday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="thursdayStart"
                v-model="thursdayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.thursday_start"
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
                        v-model="dealership.thursday_start"
                        :label="trans.thursday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="thursdayStart"
                    format="24hr"
                    v-model="dealership.thursday_start"
                    full-width
                    @click:minute="$refs.thursdayStart.save(dealership.thursday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="thursdayEnd"
                v-model="thursdayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.thursday_end"
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
                        v-model="dealership.thursday_end"
                        :label="trans.thursday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="thursdayEnd"
                    format="24hr"
                    v-model="dealership.thursday_end"
                    full-width
                    @click:minute="$refs.thursdayEnd.save(dealership.thursday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="fridayStart"
                v-model="fridayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.friday_start"
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
                        v-model="dealership.friday_start"
                        :label="trans.friday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="fridayStart"
                    format="24hr"
                    v-model="dealership.friday_start"
                    full-width
                    @click:minute="$refs.fridayStart.save(dealership.friday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="fridayEnd"
                v-model="fridayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.friday_end"
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
                        v-model="dealership.friday_end"
                        :label="trans.friday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="fridayEnd"
                    format="24hr"
                    v-model="dealership.friday_end"
                    full-width
                    @click:minute="$refs.fridayEnd.save(dealership.friday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="saturdayStart"
                v-model="saturdayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.saturday_start"
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
                        v-model="dealership.saturday_start"
                        :label="trans.saturday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="saturdayStart"
                    format="24hr"
                    v-model="dealership.saturday_start"
                    full-width
                    @click:minute="$refs.saturdayStart.save(dealership.saturday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="saturdayEnd"
                v-model="saturdayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.saturday_end"
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
                        v-model="dealership.saturday_end"
                        :label="trans.saturday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="saturdayEnd"
                    format="24hr"
                    v-model="dealership.saturday_end"
                    full-width
                    @click:minute="$refs.saturdayEnd.save(dealership.saturday_end)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-flex xs11 sm5>
            <v-menu
                ref="sundayStart"
                v-model="sundayStart"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.sunday_start"
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
                        v-model="dealership.sunday_start"
                        :label="trans.sunday_start"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="sundayStart"
                    format="24hr"
                    v-model="dealership.sunday_start"
                    full-width
                    @click:minute="$refs.sundayStart.save(dealership.sunday_start)"
                ></v-time-picker>
            </v-menu>
        </v-flex>

        <v-spacer></v-spacer>

        <v-flex xs11 sm5>
            <v-menu
                ref="sundayEnd"
                v-model="sundayEnd"
                :close-on-content-click="false"
                :nudge-right="40"
                :return-value.sync="dealership.sunday_end"
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
                        v-model="dealership.sunday_end"
                        :label="trans.sunday_end"
                        prepend-icon="access_time"
                        readonly
                        v-on="on"
                    ></v-text-field>
                </template>
                <v-time-picker
                    v-if="sundayEnd"
                    format="24hr"
                    v-model="dealership.sunday_end"
                    full-width
                    @click:minute="$refs.sundayEnd.save(dealership.sunday_end)"
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
                tuesdayStart: false,
                tuesdayEnd: false,
                wednesdayStart: false,
                wednesdayEnd: false,
                thursdayStart: false,
                thursdayEnd: false,
                fridayStart: false,
                fridayEnd: false,
                saturdayStart: false,
                saturdayEnd: false,
                sundayStart: false,
                sundayEnd: false,
                mondayStart: false,
                mondayEnd: false,

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
                        label: this.trans.monday_start,
                        ref: 'mondayStart',
                        value: ''
                    },
                    {
                        label: this.trans.monday_end,
                        ref: 'mondayEnd',
                        value: ''
                    },
                    {
                        label: this.trans.tuesday_start,
                        ref: 'tuesdayStart',
                        value: ''
                    },
                    {
                        label: this.trans.tuesday_end,
                        ref: 'tuesdayEnd',
                        value: ''
                    },
                    ,
                    {
                        label: this.trans.wednesday_start,
                        ref: 'wednesdayStart',
                        value: ''
                    },
                    {
                        label: this.trans.wednesday_end,
                        ref: 'wednesdayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: this.trans.thursday_start,
                        ref: 'thursdayStart',
                        value: ''
                    },
                    {
                        label: this.trans.thursday_end,
                        ref: 'thursdayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: this.trans.friday_start,
                        ref: 'fridayStart',
                        value: ''
                    },
                    {
                        label: this.trans.friday_end,
                        ref: 'fridayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: this.trans.saturday_start,
                        ref: 'saturdayStart',
                        value: ''
                    },
                    {
                        label: this.trans.saturday_end,
                        ref: 'saturdayEnd',
                        value: ''
                    }
                    ,
                    {
                        label: this.trans.sunday_start,
                        ref: 'sundayStart',
                        value: ''
                    },
                    {
                        label: this.trans.sunday_end,
                        ref: 'sundayEnd',
                        value: ''
                    }
                ]

                this.times = [...times]
                console.log('time is : ', this.times);
            },
        }
    }
</script>
