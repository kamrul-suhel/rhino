<template>
    <v-flex xs12 sm6>
        <v-layout row wrap align-center class="pa-2">
            <v-flex xs12>
                <label>{{ field }}</label>
            </v-flex>

            <v-flex xs4>
                <v-select :items="hours"
                          @change="onChange()"
                          :color="themeOption.primaryColor"
                          v-model="hour"
                          :label="`${trans.Hours}`">
                </v-select>
            </v-flex>

            <v-flex xs4>
                <v-select :items="minutes"
                          @change="onChange()"
                          :color="themeOption.primaryColor"
                          v-model="minute"
                          :label="`${trans.minutes}`">
                </v-select>
            </v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex'
    import dealership from "../store/modules/dealership";

    export default {
        data() {
            return {
                hour: '00',
                minute: '00',

                hours: [
                    '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11',
                    '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23'
                ],
                minutes: [
                    '00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20',
                    '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41',
                    '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59'
                ],
            }
        },

        props: {
            dealership: Object,
            value: {
                type: String | null,
                required: true,
                default: '00:00:00'
            },

            name: {
                type: String,
                required: true
            },

            field: {
                type: String,
                required: true
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        }),

        watch: {},

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                // Split time into array
                if(this.value === null){
                    return
                }
                const time = this.value.split(":")


                if (time.length > 0) {
                    this.hour = time[0]
                    this.minute = time[1]
                }
            },

            onChange() {
                const value = `${this.hour}:${this.minute}:00`
                this.$emit('updateTime', {name: this.name, value: value})
            },
        }
    }
</script>
