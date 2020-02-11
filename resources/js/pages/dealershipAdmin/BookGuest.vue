<template>
    <v-container fluid px-5>
        <v-layout row wrap px-4>
            <v-flex xs6>
                <h2>{{ `${trans.book} ${trans.a} ${trans.guest}`}}</h2>
            </v-flex>

            <v-flex xs 6align-self-end>
                <v-layout row wrap justify-end>
                    <v-btn outline round
                           @click="onGoBack()"
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        <v-icon left dark>reply</v-icon>
                        {{ `${trans.back}` }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout mt-4 v-if="!withUnique">
            <v-flex xs12 sm4>
                <v-card class="r-border-round">
                    <v-list>
                        <v-list-tile
                            avatar
                            @click="onUniqueCode()"
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                    :color="themeOption.adminNavIconColor">more_horiz
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.with} ${trans.a} ${trans.uniqueCode}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile
                            avatar
                            @click=""
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                    :color="themeOption.adminNavIconColor">close
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.without} ${trans.a} ${trans.uniqueCode}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap mt-5 v-if="withUnique">
            <div class="r-tab open">
                <div class="r-tab-title">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">more_horiz
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.with} ${trans.a} ${trans.uniqueCode}` }}
                    </div>
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">close
                        </v-icon>
                    </div>
                </div>

                <div class="r-tab-content open">
                    <v-container fluid pa-0 grid-list-xl>
                        <v-layout row wrap>
                            <v-flex xs12 sm8>
                                <v-layout row wrap>
                                    <v-flex xs12 sm6>
                                        <v-select
                                            v-model="selectedSource"
                                            :color="themeOption.inputColor"
                                            :items="sources"
                                            item-text="text"
                                            item-value="value"
                                            flat
                                            box
                                            :label="`${trans.select} ${trans.source}`"
                                        ></v-select>
                                    </v-flex>

                                    <v-flex xs12 sm6>
                                        <v-autocomplete
                                            :items="guests"
                                            class="eventDropdown"
                                            :color="themeOption.inputColor"
                                            append-icon="keyboard_arrow_down"
                                            item-text="unique"
                                            v-model="selectedGuest"
                                            flat
                                            box
                                            return-object
                                        ></v-autocomplete>
                                    </v-flex>

                                </v-layout>
                            </v-flex>

                            <v-flex xs12 class="text-xs-center">
                                <v-btn round
                                       @click="onGuestBookingSubmit()"
                                       :color="themeOption.adminNavIconColor"
                                       class="ma-0">
                                    <span style="color:#fff;">{{ `${trans.submit}` }}</span>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </div>
            </div>
        </v-layout>

        <v-dialog
            v-model="dialog"
            hide-overlay
            persistent
            width="300"
        >
            <v-card
                :color="themeOption.dialogBoxColor"
                dark
            >
                <v-card-text>
                    Please stand by
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {

        components: {},

        data() {
            return {
                dialog: false,
                loading: false,
                selectedGuest: null,
                guests: [],
                selectedSource: null,
                sources: [],
                select: null,
                withUnique:false
            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        watch: {
            selectedEvent() {
                this.generateSource()
            }
        },

        created() {
            this.generateSource()
            this.$store.commit('setHeaderTitle', `${this.trans.book} ${this.trans.a} ${this.trans.guest}`)
        },

        methods: {
            async generateSource() {
                let sources = [
                    {
                        'text': this.trans.email,
                        'value': 'email'
                    },

                    {
                        'text': this.trans.phone,
                        'value': 'phone'
                    },

                    {
                        'text': this.trans.walkIn,
                        'value': 'walkIn'
                    }
                ]

                this.sources = [...sources]

                if (this.selectedEvent.id) {
                    // Load all guest by event id
                    let URL = `/api/guests/?search=true&uniqueId=true&eventId=${this.selectedEvent.id}`
                    await axios.get(URL).then((response) => {
                        this.guests = response.data.guests
                    })
                }
            },

            onGoBack(){
              this.withUnique = false
            },

            onUniqueCode(){
              this.withUnique = true
            },

            onGuestBookingSubmit() {
                // validate form
                if(this.selectedSource === '' || this.selectedSource === null){
                    return
                }
                if(!this.selectedGuest.id){
                    return
                }

                this.dialog = true

                let guestFormData = new FormData()
                guestFormData.append('event_id', this.selectedEvent.id)
                _.forOwn(this.selectedGuest, (value, key) => {
                    guestFormData.append(key, value)
                })

                guestFormData.append('method', this.selectedSource)
                guestFormData.append('_method', 'PUT')


                // submit for appointment
                axios.post(`/api/guests/${this.selectedGuest.id}`, guestFormData).then((response) => {
                    if(response.data.success){
                        axios.get('/refresh_csrf_token').then((csrfResponse) => {
                            let csrfToken = csrfResponse.data.csrfToken

                            let guestLogin = new FormData()
                            guestLogin.append('uniqueId', this.selectedGuest.unique)
                            // login guest into frontend
                            axios.post('/guests/login', guestLogin, {
                                'X-CSRF-TOKEN': csrfToken
                            }).then((loginResponse) => {
                                if(loginResponse.data.success){
                                    this.dialog = false
                                    this.$router.push({name: 'booking'})
                                }
                            })
                        })
                    }
                })

            }
        }
    }
</script>
