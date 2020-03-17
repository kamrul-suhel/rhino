<template>
    <v-container pa-0>
        <v-form
            row wrap
            ref="guestForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-card>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :color="themeOption.inputColor"
                                        :items="events"
                                        :rules="[v => !!v || `${trans.eventIsRequired}`]"
                                        item-value="id"
                                        item-text="event"
                                        :label="`${trans.event}`"
                                        v-model="guest.event_id"
                                        required
                                    ></v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.firstNameIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.firstName"
                                        v-model="guest.first_name"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.surnameIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.surname"
                                        v-model="guest.surname"
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.emailIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.email"
                                        v-model="guest.email"
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.addressIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="`${trans.addressLine} 1`"
                                        v-model="guest.address_line_1"
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.addressLine} 2`"
                                        v-model="guest.address_line_2"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.addressLine} 3`"
                                        v-model="guest.address_line_3"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.addressLine} 4`"
                                        v-model="guest.address_line_4"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.addressLine} 5`"
                                        v-model="guest.address_line_5"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :color="themeOption.inputColor"
                                        :label="`${trans.addressLine} 6`"
                                        v-model="guest.address_line_6"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.postcodeIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.postcode"
                                        v-model="guest.postcode"
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        type="number"
                                        :color="themeOption.inputColor"
                                        :label="trans.landline"
                                        v-model="guest.landline"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        type="number"
                                        :rules="[v => !!v || `${trans.mobileIsRequired}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.mobile"
                                        v-model="guest.mobile"
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :color="themeOption.inputColor"
                                        :items="methods"
                                        :rules="[v => !!v || `${trans.methodIsRequired}`]"
                                        item-text="text"
                                        item-value="value"
                                        :label="trans.method"
                                        v-model="guest.method">
                                    </v-select>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-divider class="mt-2 mb-2"></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                dark
                                :color="themeOption.buttonSecondaryColor"
                                small
                                class="rounded-btn"
                                @click="$router.push({name: 'listGuest'})"
                            >
                                {{ `${trans.back}`}}
                            </v-btn>

                            <v-btn
                                dark
                                :loading="loading"
                                :color="themeOption.buttonDangerColor"
                                small
                                class="rounded-btn"
                                @click="onUpdateGuest()"
                            >
                                {{ `${trans.updateGuest}` }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {
        data() {
            return {
                valid: true,
                loading: false,
                methods:[]
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                events: 'getEventsForDropDown',
                guest: 'getSelectedGuest'
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
                this.$store.dispatch('fetchGuest', {id: this.$route.params.id})
            },


            onUpdateGuest() {
                if (this.$refs.guestForm.validate()) {
                    this.loading = this.themeOption.buttonLoadingStyle
                    // Set form object for dealership
                    let guestForm = new FormData()
                    _.forOwn(this.guest, (value, key) => {
                        guestForm.append(key, value)
                    })

                    guestForm.append('_method', 'put')

                    const URL = `/api/guests/${this.guest.id}`
                    axios.post(URL, guestForm).then((response) => {
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.guest.first_name}  ${this.trans.successfullyUpdated}`
                            })
                        }
                        this.loading = false
                    }).catch(()=>{
                        this.loading = false
                    })
                }
            }
        }
    }
</script>
