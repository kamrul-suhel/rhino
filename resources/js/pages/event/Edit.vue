<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span
                            :class="themeOption.textHeadingColor+'--text'">{{ `${trans.edit} ${trans.event}` }}</span>
                    </v-toolbar-title>

                    <v-divider
                        class="mx-2"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>

                    <language-picker :languageId="selectedEvent.language_id"></language-picker>
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
                                        v-model="selectedEvent.name"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 pa-2>
                                    <v-text-field
                                        :rules="nameRules"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.greeting} ${trans.text}`"
                                        v-model="selectedEvent.greeting"
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
                                        v-model="selectedEvent.dealership_id"
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
                                        :label="`${trans.type}`"
                                        v-model="selectedEvent.type_id"
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
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
                                                :rules="[v => !!v || `${trans.start} ${trans.date} ${trans.is_required}`]"
                                                required
                                                v-model="selectedEvent.start"
                                                :color="themeOption.inputColor"
                                                :label="`${trans.start} ${trans.date}`"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
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

                                <v-flex xs12 sm6 pa-2>
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
                                                :rules="[v => !!v || `${trans.end} ${trans.date} ${trans.is_required}`]"
                                                required
                                                v-model="selectedEvent.end"
                                                :color="themeOption.inputColor"
                                                :label="`${trans.end} ${trans.date}`"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
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

                                <v-flex xs12 pa-2>
                                    <v-textarea
                                        :color="themeOption.inputColor"
                                        :label="trans.notes"
                                        v-model="selectedEvent.notes"
                                        :hint="trans.notes"
                                    ></v-textarea>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-switch
                                        :label="trans.status"
                                        :color="themeOption.inputColor"
                                        v-model="selectedEvent.status">
                                    </v-switch>
                                </v-flex>
                            </v-layout>
                        </v-card-text>

                        <v-layout row wrap>
                            <v-flex xs12>
                                <Brand v-if="selectedEvent.id"
                                    :event-id="selectedEvent.id"></Brand>
                            </v-flex>
                        </v-layout>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>

                            <r-button :text="`${trans.back}`"
                                      identifier="'eventBack'"
                                      small
                                      :loadingBar="true"
                                      @click="onBackToEventList"
                                      :color="themeOption.buttonSecondaryColor"/>

                            <r-button :text="`${trans.update} ${trans.event}`"
                                      identifier="'eventEdit'"
                                      small
                                      :loadingBar="true"
                                      @click="onUpdateEvent"
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
    import LanguagePicker from "../../components/Language";
    import Brand from '../../components/Event/Brand'

    export default {
        components: {
            TimePicker,
            ImageUpload,
            LanguagePicker,
            Brand
        },

        data() {
            return {
                startEvent: false,
                endEvent: false,
                valid: true,
                event: {},
                times: {},
                active: null,
                model: null,

                nameRules: [
                    v => !!v || this.trans.name_is_required
                ]
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                types: 'getTypes',
                dealerships: 'getDealerships',
                selectedEvent: 'getSelectedEvent',
                selectedLanguage: 'getSubSelectedLanguage',
            })
        }),

        watch: {
            selectedLanguage(){
                this.$store.dispatch('fetchEvent', {
                    id: this.$route.params.id,
                    languageId: this.selectedLanguage.id,
                    edit: true
                })
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchEvent', {id: this.$route.params.id})
                this.$store.dispatch('fetchBrandForEvent', {id: this.$route.params.id})
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
                            eventForm.append(key, value)
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
                                message: `${this.selectedEvent.name}  ${this.trans.successfully_updated}`
                            })
                            this.$store.commit('setButtonLoading', false)
                            // this.$router.push({name: 'listEvents'})
                        }
                    })
                }else{
                    this.$store.commit('setButtonLoading', false)
                }
            },

            onBackToEventList(){
                // this.$router.push({name: 'listEvents'})
                this.$store.commit('setButtonLoading', false)
            }
        }
    }
</script>