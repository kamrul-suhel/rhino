<template>
    <v-container pa-0>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <v-btn outline round
                    @click="onGoBack()"
                    :color="themeOption.adminNavIconColor"
                    class="ma-0 ml-4 btn-absolute"  style="position: absolute; right: 0;" >
                <v-icon left dark>reply</v-icon>
                {{ `${trans.back}` }}
            </v-btn>
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">event
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.createEvent}` }}
                </div>
            </div>
            <div class="r-tab-content" :class="[showForm ? 'open' : '']">
                <v-form
                    row wrap
                    ref="eventForm"
                    v-model="valid"
                    lazy-validation>
                    <v-layout>
                        <v-flex xs12>

                            <v-layout row wrap>
                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.eventNameIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.eventName}`"
                                        v-model="event.name"
                                        box
                                        solo
                                        flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm-4 pa-2>
                                    <v-autocomplete
                                        :items="dealerships"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || `${trans.dealershipIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.dealership"
                                        v-model="event.dealership_id"
                                        box
                                        solo
                                        flat
                                    >
                                    </v-autocomplete>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm4 pa-2>
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
                                                :rules="[v => !!v || `${trans.startDateIsRequired}`]"
                                                required
                                                v-model="event.start"
                                                :color="themeOption.inputColor"
                                                :label="`${trans.startDate}`"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
                                                box
                                                solo
                                                flat
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            :color="themeOption.buttonDangerColor"
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

                                <v-flex xs12 sm4 pa-2>
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
                                        box
                                        solo
                                        flat
                                    >
                                        <template v-slot:activator="{ on }">
                                            <v-text-field
                                                :rules="[v => !!v || `${trans.endDateIsRequired}`]"
                                                required
                                                v-model="event.end"
                                                :color="themeOption.inputColor"
                                                :label="`${trans.endDate}`"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
                                                box
                                                solo
                                                flat
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            :color="themeOption.buttonDangerColor"
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
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm4 pa-2>
                                    <v-select
                                        :items="appointmentDuration"
                                        item-value="value"
                                        item-text="text"
                                        :label="trans.appointmentDuration"
                                        :color="themeOption.inputColor"
                                        v-model="event.appointment_duration"
                                        box
                                        solo
                                        flat
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-select
                                        :items="types"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || `${trans.typeIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.selectEventType}`"
                                        v-model="event.type_id"
                                        box
                                        solo
                                        flat
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap>
                                <v-flex xs12 sm8 pa-2>
                                    <p>{{ trans.greeting }}</p>
                                    <v-radio-group
                                        v-model="event.greeting"
                                        :mandatory="false">
                                        <v-radio :color="themeOption.inputColor"
                                                 :label="trans.hello"
                                                 :value="0">
                                        </v-radio>

                                        <v-radio :color="themeOption.inputColor"
                                                 :label="trans.hi"
                                                 :value="1">
                                        </v-radio>
                                    </v-radio-group>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap>
                                <v-flex xs12 sm4 pa-2>
                                    <v-switch
                                        :label="trans.status"
                                        :color="themeOption.switchOnColor"
                                        v-model="event.status"
                                        :true-value="1"
                                        :false-value="0">
                                    </v-switch>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap class="justify-center">
                                <v-flex xs12 pa-2>
                                    <r-button
                                        :text="`${trans.submit}`"
                                        class="rounded-btn text-white"
                                        dark
                                        small
                                        identifier="'eventCreate'"
                                        :loadingBar="true"
                                        @click="onCreateEvent"
                                        :color="themeOption.buttonDangerColor" />
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-form>
            </div>
        </div>
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
                appointmentDuration:[],
                showForm: false
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
                                message: `${this.event.name}  ${this.trans.successfullyCreated}`
                            })
                            this.$store.commit('setButtonLoading', false)
                            setTimeout(() => {
                                this.$router.push({name: 'editEvents', params: {id: response.data.event.id}})
                            }, 1000)
                        }

                        this.showForm = false
                        this.$store.commit('setUpdateComponent')
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
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
            },

            toggleForm() {
                this.showForm = !this.showForm

                if (this.showForm) {
                    this.$store.commit( 'setHeaderTitle', `${this.trans.createNewEvent}` )
                    this.$store.commit( 'setNavTitle', `${this.trans.createNewEvent}` )
                } else {
                    this.$store.commit( 'setHeaderTitle', `${this.trans.manageEvents}` )
                    this.$store.commit( 'setNavTitle', `${this.trans.manageEvents}` )
                }
            },
            
            onGoBack(){
                this.$router.push({name: 'dashboard'})
            }
        },
        
    }
</script>
