<template>
    <div>
        <v-layout row wrap align-center justify-center class="personal-details" px-5>
            <v-flex class="xs12" align-center>
                <h4 class="display-1 mt-5 mx-2 text-xs-center">{{ trans.pleaseConfirmAmendYourContactDetails }}</h4>
                <h5 class="headline mt-2 mx-4 text-xs-center">{{ trans.areTheseDetailsStillCorrect }}</h5>
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
                                    <h6 class="body-1">{{ `${trans.email} ${trans.address}`}}</h6>
                                    <v-text-field :color="color"
                                        v-model="guest.email"
                                        outline
                                        :disabled="!isEditable"
                                    ></v-text-field>
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
                                    {{ `${trans.edit} ${trans.details}`}}
                                </v-btn>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>

            <v-flex xs12 my-5>
                <v-layout xs12 row justify-center>
                    <v-btn class="border-medium height-50 rounded-25 theme-color padding-x-85"
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
                event: 'getSelectedEvent'
            })
        }),

        methods:{
            onClickEdit(type){
                if(type === 'edit'){
                    // Edit detail
                    this.isEditable = true
                }

                if(type === 'save'){
                    // save guest date into database
                    let guestForm = new FormData()
                    guestForm.append('first_name', this.guest.first_name)
                    guestForm.append('surname', this.guest.surname)
                    guestForm.append('email', this.guest.email)
                    guestForm.append('mobile', this.guest.mobile)
                    guestForm.append('event_id', this.event.id)
                    guestForm.append('_method', 'PUT')

                    const URL = `/api/guests/${this.guest.id}`
                    axios.post(URL, guestForm).then((response) => {
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.guest.first_name}  ${this.trans.successfully_updated}`
                            })
                            this.isEditable = false
                        }
                    })

                }
            }
        }
    }
</script>
