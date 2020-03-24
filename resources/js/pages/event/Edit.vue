<template>
    <v-container pa-0>
        <v-layout row wrap>
            <v-flex xs12 sm9
                    v-if="authUser.level === 'admin'">
                <v-btn outline round
                       @click="onViewCalender()"
                       :color="themeOption.adminNavIconColor"
                       class="ma-0 my-2">
                    <v-icon left dark>calendar_today</v-icon>
                    {{ `${trans.calendar}`}}
                </v-btn>

                <v-btn outline round
                       @click="onManageStaff()"
                       :color="themeOption.adminNavIconColor"
                       class="ma-0">
                    <v-icon left dark>people_alt</v-icon>
                    {{ `${trans.manageStaffVehicles}`}}
                </v-btn>
            </v-flex>

            <v-spacer></v-spacer>

            <v-flex xs12 sm3>
                <language-picker
                    :solo="false"
                    :flat="false"
                    :chip="false"
                    :languageId="selectedEvent.language_id">
                </language-picker>
            </v-flex>
        </v-layout>

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
                                :label="`${trans.nameOfEvent}`"
                                v-model="selectedEvent.name"
                                solo box flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 pa-2>
                            <v-select
                                :items="dealerships"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || `${trans.dealershipIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.dealership"
                                v-model="selectedEvent.dealership_id"
                                solo box flat
                            >
                            </v-select>
                        </v-flex>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs12 sm4 pa-2>
                            <v-menu
                                ref="startEvent"
                                v-model="startEvent"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                :return-value.sync="selectedEvent.start"
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
                                        v-model="selectedEvent.start"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.startDate}`"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                        solo box flat
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    :color="themeOption.inputColor"
                                    v-model="selectedEvent.start" no-title scrollable>
                                    <v-spacer></v-spacer>

                                    <v-btn flat :color="themeOption.buttonSecondaryColor"
                                            @click="startEvent = false">{{ trans.cancel }}
                                    </v-btn>

                                    <v-btn flat :color="themeOption.buttonPrimaryColor"
                                            @click="$refs.startEvent.save(selectedEvent.start)">{{ trans.ok }}
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
                                :return-value.sync="selectedEvent.end"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.endDateIsRequired}`]"
                                        required
                                        v-model="selectedEvent.end"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.endDate}`"
                                        prepend-icon="event"
                                        readonly
                                        v-on="on"
                                        solo box flat
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    :color="themeOption.inputColor"
                                    v-model="selectedEvent.end" no-title scrollable>
                                    <v-spacer></v-spacer>

                                    <v-btn flat :color="themeOption.buttonSecondaryColor"
                                            @click="endEvent = false">{{ trans.cancel }}
                                    </v-btn>

                                    <v-btn flat :color="themeOption.buttonPrimaryColor"
                                            @click="$refs.endEvent.save(selectedEvent.end)">{{ trans.ok }}
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
                                v-model="selectedEvent.appointment_duration"
                                solo box flat>
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm4 pa-2>
                            <v-select
                                :items="types"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || `${trans.typeIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="`${trans.type}`"
                                v-model="selectedEvent.type_id"
                                solo box flat
                            >
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm8 pa-2>
                            <p>{{ trans.greeting }}</p>
                            <v-radio-group
                                v-model="selectedEvent.greeting"
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
                        <v-flex xs12 sm8 pa-2>
                            <v-textarea
                                :color="themeOption.inputColor"
                                :label="trans.notes"
                                v-model="selectedEvent.notes"
                                :hint="trans.notes"
                                solo flat box
                            ></v-textarea>
                        </v-flex>
                    </v-layout>
                </v-card-text>

                <v-layout row wrap v-if="!subComponent">
                    <v-flex xs12>
                        <v-card flat>
                            <v-card-text>
                                <v-tabs
                                    dark
                                    :slider-color="themeOption.tabSliderColor"
                                >
                                    <v-tab
                                        key="eventImage"
                                        ripple
                                    >
                                        {{ `${trans.eventBanner}`}}

                                    </v-tab>

                                    <v-tab
                                        key="eventGuest"
                                        ripple
                                    >
                                        {{ `${trans.guests}` }}
                                    </v-tab>

                                    <v-tab
                                        key="eventBrand"
                                        ripple
                                    >
                                        {{ `${trans.brands}` }}
                                    </v-tab>

                                    <v-tabs-items touchless>

                                        <v-tab-item
                                            key="eventImage"
                                        >
                                            <v-layout row wrap pt-3>
                                                <v-flex xs12 sm4>
                                                    <v-card class="pa-2 my-3">
                                                        <v-img
                                                            cover
                                                            :src="bannerImage|image(themeOption.brandDefaultImage)"
                                                            aspect-ratio="2.75"
                                                        ></v-img>
                                                    </v-card>

                                                    <ImageUpload :preview="false"
                                                                    model="event"
                                                    ></ImageUpload>
                                                </v-flex>

                                            </v-layout>
                                        </v-tab-item>

                                        <v-tab-item
                                            key="eventBrand"
                                        >
                                            <EventGuest></EventGuest>
                                        </v-tab-item>

                                        <v-tab-item
                                            key="eventGuest"
                                        >
                                            <Brand v-if="selectedEvent.id"
                                                    :eventId="selectedEvent.id"
                                            ></Brand>
                                        </v-tab-item>
                                    </v-tabs-items>
                                </v-tabs>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                </v-layout>

                <!-- Dealership Admin can see -->
                <v-layout row wrap v-if="subComponent && model==='dealership'">
                    <v-flex xs12>
                        <v-divider v-if="!subComponent"></v-divider>

                                <v-tabs
                                    dark
                                    :slider-color="themeOption.tabSliderColor"
                                >
                                    <v-tab
                                        key="saleExecutives"
                                        ripple
                                    >
                                        {{ trans.salesExecutive }}
                                    </v-tab>

                                    <v-tab
                                        key="vehicle"
                                        ripple
                                    >
                                        {{ trans.vehicles }}
                                    </v-tab>

                                    <v-tabs-items touchless>
                                        <v-tab-item
                                            key="saleExecutives"
                                        >
                                            <EventUsers></EventUsers>
                                        </v-tab-item>

                                        <v-tab-item
                                            key="vehicle"
                                        >
                                            <vehicle></vehicle>
                                        </v-tab-item>
                                    </v-tabs-items>
                                </v-tabs>
                    </v-flex>
                </v-layout>

                    <v-layout>
                        <v-flex class="pa-3 justify-center">
                            <r-button :text="`${trans.back}`"
                                      dark
                                      identifier="'eventBack'"
                                      small
                                      class="rounded-btn text-white"
                                      :loadingBar="true"
                                      @click="onBackToEventList"
                                      :color="themeOption.buttonSecondaryColor"/>

                            <r-button :text="`${trans.updateEvent}`"
                                      identifier="'eventEdit'"
                                      small
                                      class="rounded-btn text-white"
                                      :loadingBar="true"
                                      @click="onUpdateEvent"
                                      :color="themeOption.buttonDangerColor"/>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import TimePicker from "@/components/TimePicker"
    import ImageUpload from "@/components/ImageUpload"
    import LanguagePicker from "@/components/Language"
    import Brand from '@/components/Event/Brand'
    import Vehicle from '@/components/Event/EventVehicle'
    import EventUsers from '@/components/Event/EventUsers'
    import Appointment from "@/components/Appointment/Appointment"
    import EventGuest from "@/components/Event/EventGuest";

    export default {
        components: {
            TimePicker,
            ImageUpload,
            LanguagePicker,
            Brand,
            Vehicle,
            EventUsers,
            Appointment,
            EventGuest
        },

        data() {
            return {
                startEvent: false,
                endEvent: false,
                valid: true,
                event: {},
                times: {},
                active: null,
                appointmentDuration: [],
                breakTime: [],
                bannerImage: null
            }
        },

        props: {
            subComponent: {
                type: Boolean,
                default: false
            },

            model: {
                type: String,
                default: ''
            }
        },

        computed: ({
            ...mapGetters({
                authUser: 'getAuthUser',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                types: 'getTypes',
                dealerships: 'getDealerships',
                selectedEvent: 'getSelectedEvent',
                selectedLanguage: 'getSubSelectedLanguage',
                updateComponent: 'getUpdateComponent',
                uploadedEventImage: 'getUploadedImage',
                dealership: 'getSelectedDealership',
            })
        }),

        watch: {
            '$route.params.eventId': function (id) {
                this.renderEventData()
            },

            selectedLanguage() {
                let id = null
                if (this.subComponent) {
                    switch (this.model) {
                        case 'dealership':
                            id = this.$route.params.eventId
                            break

                        default:
                            id = this.$route.params.id
                    }
                }

                this.$store.dispatch('fetchEvent', {
                    id: id,
                    languageId: this.selectedLanguage.id,
                    edit: true
                })
            },

            updateComponent() {
                this.$router.push({
                    name: 'editDealershipsEvent',
                    params: {
                        dealershipId: this.dealership.id,
                        eventId: this.selectedEvent.id
                    }
                })
            },

            selectedEvent() {
                this.bannerImage = this.selectedEvent.banner_image
            },

            uploadedEventImage() {
                this.bannerImage = this.uploadedEventImage
            }
        },

        created() {
            this.initialize()
            this.setAppointmentDuration()

            this.$store.commit('setHeaderTitle', `${this.trans.editEvent}`)
            this.$store.commit('setNavTitle', `${this.trans.editEvent}`)

            // Load dealership & type when it is subcomponent
            if (this.subComponent) {
                this.renderEventData()
            }
        },

        methods: {
            initialize() {
                let id = null
                if (this.subComponent) {
                    switch (this.model) {
                        case 'dealership':
                            id = this.$route.params.eventId
                            break

                        default:
                            id = this.$route.params.id
                    }
                } else {
                    id = this.$route.params.id
                }
                this.$store.dispatch('fetchEvent', {id: id})
                this.$store.dispatch('fetchBrandForEvent', {id: id})
            },

            onUpdateEvent() {
                if (this.$refs.eventForm.validate()) {
                    let eventForm = new FormData()
                    eventForm.append('_method', 'put')

                    // Set form object for event
                    _.forOwn(this.selectedEvent, (value, key) => {
                        if (key === 'status') {
                            if (value) {
                                eventForm.append('status', 1)
                            } else {
                                eventForm.append('status', 0)
                            }
                        } else {
                            if (key === 'banner_image') {
                                eventForm.append('banner_image', this.bannerImage)
                            } else {
                                eventForm.append(key, value)
                            }
                        }
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key) => {
                        eventForm.append(key, value)
                    })

                    const URL = `/api/events/${this.selectedEvent.id}`
                    // send form data to save
                    axios.post(URL, eventForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.selectedEvent.name}  ${this.trans.successfullyUpdated}`
                            })
                            this.$store.commit('setButtonLoading', false)
                            // this.$router.push({name: 'listEvents'})
                        }
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
                    })
                } else {
                    this.$store.commit('setButtonLoading', false)
                }
            },

            onBackToEventList() {
                // If rhino admin then send back to edit event page
                if(this.$route.query.admin){
                    this.$router.push({
                        name: 'editEvents',
                        params:{
                            id: this.$route.params.eventId
                        }
                    })
                    this.$store.commit('setButtonLoading', false)
                    return
                }

                if (this.subComponent) {
                    switch (this.model) {
                        case 'dealership':
                            this.$router.push({
                                name: 'editDealerships',
                                params: {
                                    id: this.$route.params.dealershipId
                                }
                            })

                            this.$store.commit('setButtonLoading', false)
                            break
                    }
                } else {
                    this.$router.push({name: 'listEvents'})
                    this.$store.commit('setButtonLoading', false)
                }
            },

            setAppointmentDuration() {
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

                // set user break time
                this.breakTime = [
                    {
                        text: `30 ${this.trans.minutes}`,
                        value: 30
                    },
                    {
                        text: `60 ${this.trans.minutes}`,
                        value: 60
                    }
                ]
            },

            renderEventData() {
                this.$store.dispatch('fetchDealershipsForDropdown')
                this.$store.dispatch('fetchTypesForDropdown')
                this.$store.dispatch('fetchDealership', {id: this.$route.params.dealershipId})
                this.$store.dispatch('fetchAppointmentByEventId', {eventId: this.$route.params.eventId})
            },

            onViewCalender() {
                this.$router.push({
                        name: 'adminEventCalender',
                        params: {
                            eventId: this.selectedEvent.id,
                            dealershipId: this.selectedEvent.dealership_id
                        }
                    }
                )
            },

            onManageStaff() {
                // Check is same route
                if (this.$route.name === 'editDealershipsEvent') {
                    return
                }

                this.$router.push({
                    name: 'editDealershipsEvent',
                    params: {
                        dealershipId: this.selectedEvent.dealership_id,
                        eventId: this.selectedEvent.id
                    },
                    query: {
                        admin: true
                    }
                })
            }
        }
    }
</script>
