<template>
    <v-flex xs12 class="text-xs-center my-5">
        <p>{{ trans.updateSuppressionList }}</p>

        <v-btn :disabled="downloading"
               :loading="loading"
               @click="onDownloadSuppressionList()"
               :color="themeOption.primaryColor">
            <span :style="{color:themeOption.primaryTextColor}">
                {{ trans.download }}
            </span>
        </v-btn>

        <input
            ref="guestSuppressionCSV"
            type="file"
            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            class="hidden-screen-only"
            @change="onUploadCSV"
        />

        <v-btn
            :loading="uploadLoading"
            :disabled="uploading"
            :color="themeOption.primaryColor"
            class="white--text"
            @click="onClickUploadCSV()"
        >
            <span :style="{color:themeOption.primaryTextColor}">
                {{ trans.upload }}
            </span>
            <v-icon right dark :color="themeOption.primaryTextColor">cloud_upload</v-icon>
        </v-btn>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex'
    import fn from '@/utils/function'

    export default {
        components: {},

        data() {
            return {
                downloading: false,
                loading: null,
                uploading: false,
                uploadLoading: null
            }
        },

        props: {},

        computed: ({
            ...mapGetters({
                authUser: 'getAuthUser',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedEvent: 'getSelectedEvent',
            })
        }),

        watch: {},

        created() {

        },

        methods: {
            onDownloadSuppressionList() {
                this.downloading = true
                this.loading = 'loading'

                const eventId = this.selectedEvent.id
                const URL = `/api/guests?eventId=${eventId}`
                axios.get(URL).then((response) => {
                    if(
                        response.data.guests &&
                        response.data.guests.length > 0
                    ){
                        const guests = [...response.data.guests]

                        const modifyGuest = _.map(guests, (guest) => {
                            return {
                                id: guest.id,
                                email: guest.email,
                                first_name: guest.first_name,
                                surname: guest.surname,
                                postal_contact: guest.postal_contact,
                                email_contact: guest.email_contact,
                                sms_contact: guest.sms_contact,
                                phone_contact: guest.phone_contact
                            }
                        })

                        fn.downloadCSV(modifyGuest, 'guest-suppression-list')

                        this.downloading = false
                        this.loading = null
                    }
                }, error => {
                    this.downloading = false
                    this.loading = null
                })
            },

            onClickUploadCSV() {
                this.$refs.guestSuppressionCSV.click()
            },

            onUploadCSV() {
                const csvFile = this.$refs.guestSuppressionCSV.files[0]
                let guestSuppressionForm = new FormData()
                guestSuppressionForm.append('file', csvFile)
                guestSuppressionForm.append('eventId', this.$route.params.id)

                const URL = `/api/guests/suppression_upload`

                this.loader = 'loading'
                this.loading = true

                axios.post(URL, guestSuppressionForm).then((response) => {
                    if (response.data.success == false) {
                        // Guest ID not found
                        this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.trans.guestDoesntExist}`
                            })
                    }

                    if (response.data.success) {

                        this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.trans.guestSuccessfullyUpdated}`
                            })
                    }

                    this.loader = null
                    this.loading = false
                },error => {
                    this.loader = null
                    this.loading = false
                })
            },
        }
    }
</script>
