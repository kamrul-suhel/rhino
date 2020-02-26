<template>
    <v-container pa-0>
        <v-layout row warp pb-4 v-if="authUser.level === 'admin'">
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span
                            :class="themeOption.textHeadingColor+'--text'">{{ `${trans.create} ${trans.guest}` }}</span>
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
            ref="guestForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-card>
                        <v-card-text>
                            <v-layout row wrap v-if="authUser.level === 'admin'">
                                <v-flex xs12 sm3 pa-2>
                                    <v-select
                                        :color="themeOption.inputColor"
                                        :items="events"
                                        :rules="[v => !!v || `${trans.event} ${trans.is_required}`]"
                                        item-value="id"
                                        item-text="event"
                                        :label="`${trans.event}`"
                                        v-model="guest.event_id"
                                        required
                                        box solo flat
                                    ></v-select>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap py-4>
                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.firstName} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.firstName"
                                        v-model="guest.first_name"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.surName} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.surName"
                                        v-model="guest.surname"
                                        box solo flat
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.email} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.email"
                                        v-model="guest.email"
                                        box solo flat
                                        required
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap py-4>
                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.address} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.address_line} 1`"
                                        v-model="guest.address_line_1"
                                        box solo flat
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.address_line} 2`"
                                        v-model="guest.address_line_2"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.address_line} 3`"
                                        v-model="guest.address_line_3"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.address_line} 4`"
                                        v-model="guest.address_line_4"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.address_line} 5`"
                                        v-model="guest.address_line_5"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.address_line} 6`"
                                        v-model="guest.address_line_6"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.postcode} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.postcode"
                                        v-model="guest.postcode"
                                        box solo flat
                                        required
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                            <v-layout row wrap>
                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="trans.landline"
                                        v-model="guest.landline"
                                        box solo flat
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.mobile} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.mobile"
                                        v-model="guest.mobile"
                                        box solo flat
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm4 pa-2>
                                    <v-select
                                        :color="themeOption.inputColor"
                                        :items="methods"
                                        :rules="[v => !!v || `${trans.method} ${trans.is_required}`]"
                                        item-text="text"
                                        item-value="value"
                                        :label="trans.method"
                                        v-model="guest.method"
                                        box solo flat>
                                    </v-select>
                                </v-flex>
                            </v-layout>
                        </v-card-text>

                        <v-layout class="pa-3 text-xs-left">
                            <v-flex>
                                <v-spacer></v-spacer>
                                <v-btn
                                    class="rounded-btn"
                                    dark
                                    :color="themeOption.buttonSecondaryColor"
                                    small
                                    @click="$router.push({name: 'listGuest'})"
                                >
                                    {{ `${trans.back}`}}
                                </v-btn>

                                <v-btn
                                    class="rounded-btn"
                                    dark
                                    :color="themeOption.buttonDangerColor"
                                    small
                                    @click="onCreateGuest()"
                                >
                                    {{ `${trans.create} ${trans.guest}` }}
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import authUser from "../../store/modules/authUser"
    import fn from '@/utils/function'

    export default {
        data() {
            return {
                valid: true,
                guest: {
                    status: 0
                },
                methods:[]
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                events: 'getEventsForDropDown',
                authUser: 'getAuthUser',
                selectedEvent: 'getSelectedEvent'
            })
        }),

        watch: {},

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.methods = [...fn.getBookGuestOptions(this.trans)]
                this.$store.dispatch('fetchEventForDropDown')
            },


            onCreateGuest() {
                if (this.$refs.guestForm.validate()) {
                    if(this.$route.name === 'dealershipAdminBookAGuest'){
                        this.$emit('dialogStatus', true)
                    }
                    // Set form object for dealership
                    let guestForm = new FormData()
                    _.forOwn(this.guest, (value, key) => {
                        guestForm.append(key, value)
                    })

                    // Check if auth user is dealership then get eventId from selected event
                    if(this.$route.name === 'dealershipAdminBookAGuest'){
                        guestForm.append('event_id', this.selectedEvent.id)
                    }

                    const URL = `/api/guests`
                    axios.post(URL, guestForm).then((response) => {
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.guest.first_name}  ${this.trans.successfully_created}`
                            })

                            // If request coming from book guest page then return to book guest journey
                            if(this.$route.name === 'dealershipAdminBookAGuest'){
                               this.$emit('guest', response.data.guest)
                                return
                            }

                            this.$router.push({name: 'listGuest'})
                        }
                    })
                }
            }
        }
    }
</script>
