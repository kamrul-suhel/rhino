<template>
    <div>
        <v-layout row wrap align-center justify-center class="personal-details px-md-5">
            <v-flex class="xs12" align-center>
                <h4 class="display-1 mt-5 mx-2 text-xs-center">
                    {{ trans.pleaseConfirmAmendYourContactDetails }}
                </h4>

                <h5 class="headline mt-2 mx-4 text-xs-center">
                    {{ trans.areTheseDetailsStillCorrect }}
                </h5>
            </v-flex>

            <v-flex row nowrap mt-5 justify-center class="details-container xs12 md8">
                <v-container mt-4 grid-list-xl>
                    <v-layout row wrap justify-center>
                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1">
                                        {{ trans.firstName}}
                                    </h6>

                                    <v-text-field :color="color"
                                        v-model="guest.first_name"
                                        outline
                                        :disabled="!isEditable"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1">{{ trans.surName }}</h6>
                                    <v-text-field :color="color"
                                        v-model="guest.surname"
                                        outline
                                        :disabled="!isEditable"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-end>
                                <v-flex md8 sm12>
                                    <h6 class="body-1">{{ trans.phoneNumber }}</h6>
                                    <v-text-field :color="color"
                                        v-model="guest.mobile"
                                        outline
                                        :disabled="!isEditable"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex my-2 xs12 sm6>
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1">{{ `${trans.emailAddress}`}}</h6>
                                    <v-text-field :color="color"
                                        v-model="guest.email"
                                        outline
                                        :disabled="!isEditable"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex md8 sm12 v-if="editGuest">
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1">{{ `${trans.mailingAddress}`}}</h6>
                                    <v-text-field :color="color"
                                                  v-model="guest.address_line_1"
                                                  outline
                                                  :disabled="!isEditable"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex md8 sm12 v-if="editGuest">
                            <v-layout row wrap justify-start>
                                <v-flex md8 sm12>
                                    <h6 class="body-1">{{ `${trans.postcode}`}}</h6>
                                    <v-text-field :color="color"
                                                  v-model="guest.postcode"
                                                  outline
                                                  :disabled="!isEditable"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex md8 sm12 v-if="editGuest">
                            <v-layout row wrap justify-center align-content-center>
                                <v-flex xs12>
                                    <h6 class="body-1">{{ `${trans.marketingPreferences}`}}</h6>
                                </v-flex>

                                <v-flex>
                                    <span>Mailing</span>
                                    <v-checkbox :color="color"
                                                :true-value="1"
                                                :false-value="0"
                                                v-model="guest.postal_contact">
                                    </v-checkbox>
                                </v-flex>

                                <v-flex>
                                    <span>Email</span>
                                    <v-checkbox :color="color"
                                                :true-value="1"
                                                :false-value="0"
                                                v-model="guest.email_contact">
                                    </v-checkbox>
                                </v-flex>

                                <v-flex>
                                    <span>SMS</span>
                                    <v-checkbox :color="color"
                                                :true-value="1"
                                                :false-value="0"
                                                v-model="guest.sms_contact">
                                    </v-checkbox>
                                </v-flex>

                                <v-flex>
                                    <span>Phone</span>
                                    <v-checkbox :color="color"
                                                :true-value="1"
                                                :false-value="0"
                                                v-model="guest.phone_contact">
                                    </v-checkbox>
                                </v-flex>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12 my-2>
                            <v-layout row justify-center>
                                <v-btn v-if="isEditable"
                                       class="height-40 rounded-20 blue-grey darken-4 mb-3"
                                       @click="onClickEdit('save')"
                                       style="color:white; padding-right:45px; padding-left:45px" depressed>{{ trans.save }}
                                </v-btn>

                                <v-btn v-else class="border-medium height-40 rounded-25 light-grey"
                                        @click="onClickEdit('edit')">
                                    {{ `${trans.editDetails}`}}
                                </v-btn>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>

            <v-flex xs12 my-5>
                <v-layout row justify-center>
                    <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85"
                           :color="color"
                           outline
                           @click="onContinue"
                           depressed>{{ trans.continue }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>
    </div>
</template>



<script>
    import {mapGetters} from 'vuex'

    export default {
        data(){
            return {
                isEditable: false
            }
        },

        created(){

        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                guest: 'getBookingGuest',
                color: 'getFrontendColor',
                event: 'getSelectedEvent',
                editGuest: 'getEditGuest'
            })
        }),

        watch:{
            editGuest(){
                if(this.editGuest){
                    this.isEditable = true
                }
            }
        },

        methods:{
            onClickEdit(type){
                if(type === 'edit'){
                    // Edit detail
                    this.isEditable = true
                }

                if(type === 'save'){
                    // save guest date into database
                    let guestForm = new FormData()
                    _.forOwn(this.guest, (value, key)=> {
                        guestForm.append(key, value)
                    })

                    guestForm.append('_method', 'PUT')

                    const URL = `/api/guests/${this.guest.id}`
                    axios.post(URL, guestForm).then((response) => {
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.trans.guestSuccessfullyUpdated}`
                            })
                            this.isEditable = false

                            // Check is edit guest enable then redirect to first page
                            if(this.editGuest){
                                this.$store.commit('setEditGuest', false)
                                this.$store.commit('setBookingStep', 0)
                            }
                        }
                    })
                }
            },

            onContinue(){
                this.$store.commit('setBookingStep', 4)

                this.moveTo()
            },

            moveTo () {
                let to = this.moveToDown
                    ? this.$refs.description.offsetTop - 60
                    : 0

                window.scroll({
                    top: to,
                    left: 0,
                    behavior: 'smooth'
                })

                this.moveToDown = !this.moveToDown
            }
        }
    }
</script>
