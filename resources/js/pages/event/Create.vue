<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span
                            :class="themeOption.textHeadingColor+'--text'">{{ `${trans.create} ${trans.event}` }}</span>
                    </v-toolbar-title>

                    <v-divider
                        class="mx-2"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                </v-toolbar>
            </v-flex>
        </v-layout>

        <v-form
            row wrap
            ref="eventForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-card>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.event} ${trans.name} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.name} ${trans.of} ${trans.event}`"
                                        v-model="event.name"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.name} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.greeting} ${trans.text}`"
                                        v-model="event.greeting"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="dealerships"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || `${trans.dealership} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.dealership"
                                        v-model="event.dealership_id"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="types"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || `${trans.type} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.select} ${trans.event} ${trans.type}`"
                                        v-model="event.type_id"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="appointmentDuration"
                                        item-value="value"
                                        item-text="text"
                                        :label="trans.appointment_duration"
                                        :color="themeOption.inputColor"
                                        v-model="event.appointment_duration">
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-switch
                                        :label="trans.status"
                                        :color="themeOption.inputColor"
                                        v-model="event.status"
                                        :true-value="1"
                                        :false-value="0">
                                    </v-switch>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-menu
                                        ref="startEvent"
                                        v-model="startEvent"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        :return-value.sync="event.start"
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :rules="[v => !!v || `${trans.start} ${trans.date} ${trans.is_required}`]"
                                                required
                                                v-model="event.start"
                                                :color="themeOption.inputColor"
                                                :label="`${trans.start} ${trans.date}`"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            :color="themeOption.inputColor"
                                            v-model="event.start" no-title scrollable>
                                            <v-spacer></v-spacer>

                                            <v-btn flat :color="themeOption.buttonSecondaryColor"
                                                   @click="startEvent = false">{{ trans.cancel }}
                                            </v-btn>

                                            <v-btn flat :color="themeOption.buttonPrimaryColor"
                                                   @click="$refs.startEvent.save(event.start)">{{ trans.ok }}
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-menu
                                        ref="endEvent"
                                        v-model="endEvent"
                                        :close-on-content-click="false"
                                        :nudge-right="40"
                                        :return-value.sync="event.end"
                                        lazy
                                        transition="scale-transition"
                                        offset-y
                                        full-width
                                        min-width="290px"
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :rules="[v => !!v || `${trans.end} ${trans.date} ${trans.is_required}`]"
                                                required
                                                v-model="event.end"
                                                :color="themeOption.inputColor"
                                                :label="`${trans.end} ${trans.date}`"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            :color="themeOption.inputColor"
                                            v-model="event.end" no-title scrollable>
                                            <v-spacer></v-spacer>

                                            <v-btn flat :color="themeOption.buttonSecondaryColor"
                                                   @click="endEvent = false">{{ trans.cancel }}
                                            </v-btn>

                                            <v-btn flat :color="themeOption.buttonPrimaryColor"
                                                   @click="$refs.endEvent.save(event.end)">{{ trans.ok }}
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>

                                <v-flex xs12 pa-2>
                                    <v-textarea
                                        :color="themeOption.inputColor"
                                        :label="trans.notes"
                                        v-model="event.notes"
                                        :hint="trans.notes"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>

                            <r-button :text="`${trans.back}`"
                                      identifier="'eventList'"
                                      small
                                      :loadingBar="false"
                                      @click="onBackToEventList"
                                      :color="themeOption.buttonSecondaryColor"/>

                            <r-button :text="`${trans.create} ${trans.event}`"
                                      small
                                      identifier="'eventCreate'"
                                      :loadingBar="true"
                                      @click="onCreateEvent"
                                      :color="themeOption.buttonPrimaryColor"/>

                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import TimePicker from "../../components/TimePicker";
    import ImageUpload from "../../components/ImageUpload";

    export default {
        components: {
            TimePicker,
            ImageUpload
        },

        data() {
            return {
                startEvent: false,
                endEvent: false,
                valid: true,
                event: {
                    status: 1
                },
                times: {},
                active: null,
                appointmentDuration:[]
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                types: 'getTypes',
                dealerships: 'getDealerships'
            })
        }),

        watch: {
        },

        created() {
            this.setAppointmentDuration()
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchTypes', {dropDown: true})
            },

            onCreateEvent() {
                if (this.$refs.eventForm.validate()) {
                    let eventForm = new FormData()

                    // Set form object for event
                    _.forOwn(this.event, (value, key) => {

                        eventForm.append(key, value)
                        
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key) => {
                        eventForm.append(key, value)
                    })

                    // send form data to save
                    axios.post('/api/events', eventForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.event.name}  ${this.trans.successfully_created}`
                            })
                            this.$store.commit('setButtonLoading', false)
                            this.$router.push({name: 'listEvents'})
                        }
                    })
                }else{
                    this.$store.commit('setButtonLoading', false)
                }
            },

            onBackToEventList(){
                this.$router.push({name: 'listEvents'})
            },

            setAppointmentDuration(){
                this.appointmentDuration = [
                    {
                        text: `60 ${this.trans.minutes}`,
                        value: 60
                    },

                    {
                        text: `90 ${this.trans.minutes}`,
                        value: 90
                    },

                    {
                        text: `120 ${this.trans.minutes}`,
                        value: 120
                    }
                ]
            }
        }
    }
</script>
