<template>
    <v-card min-height="400"
            max-height="600">
        <v-card-title>
            <h3>{{ `${trans.dealership} ${trans.users}`}}</h3>
        </v-card-title>

        <v-divider></v-divider>

        <v-card-text class="pa-0">
            <v-layout row wrap>
                <v-flex xs12>
                    <v-list two-line subheader>
                        <v-list-tile
                            v-for="user in (subComponent ? selectedUsers : users)"
                            :key="user.id"
                            avatar
                        >
                            <v-list-tile-avatar>
                                <v-avatar
                                    :tile="false"
                                    :size="36"
                                    color="grey lighten-4"
                                >
                                    <img :src="user.profile_image | image(themeOption.brandDefaultImage)">
                                </v-avatar>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    <v-badge :color="user.level === 'dealership' ? 'primary' : 'green' ">
                                        <template v-slot:badge>
                                            <span>{{user.level === 'dealership' ?  'M' : 'S'}}</span>
                                        </template>
                                        <span>{{ user.firstname }}</span>
                                    </v-badge>
                                </v-list-tile-title>
                                <v-list-tile-sub-title>{{ user.surname }}</v-list-tile-sub-title>
                            </v-list-tile-content>

                            <v-list-tile-action>
                                <template v-if="!subComponent">
                                    <v-btn icon ripple
                                           v-if="checkUserExists(user)"
                                           @click="onRemoveRelation(user)">
                                        <v-icon color="red lighten-1">remove_circle_outline</v-icon>
                                    </v-btn>

                                    <v-btn icon ripple
                                           v-else
                                           @click="onCreateRelation(user)">
                                        <v-icon color="lighten-1">add_circle_outline</v-icon>
                                    </v-btn>
                                </template>
                                <template v-else>
                                    <v-btn icon ripple
                                           @click="onSelectUser(user)">
                                        <v-icon color="lighten-1">perm_contact_calendar</v-icon>
                                    </v-btn>
                                </template>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </v-flex>
            </v-layout>
        </v-card-text>
    </v-card>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data() {
            return {}
        },

        props: {
            subComponent: {
                type: Boolean,
                default: false
            },

            model: {
                type: String,
                default: null
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                users: 'getUsersByDealership',
                selectedUsers: 'getUsers',
            })
        }),

        watch: {

        },

        created() {
        },

        methods: {
            checkUserExists(user) {
                const found = _.find(this.selectedUsers, (selectedUser) => {
                    return user.id === selectedUser.id
                })

                if (found) {
                    return true
                }
                return false
            },

            onCreateRelation(user) {
                const URL = `/api/events/${this.$route.params.eventId}/users`

                let eventUserFrom = new FormData()
                eventUserFrom.append(`event_id`, this.$route.params.eventId)
                eventUserFrom.append('user_id', user.id)

                axios.post(URL, eventUserFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.user}  ${this.trans.hasBeenAdded.toLowerCase()} ${this.trans.to.toLowerCase()} ${this.trans.event}`
                        })

                        this.$store.commit('addUserToUserList', user)
                    }
                })
            },

            onRemoveRelation(user) {

                const eventId = this.$route.params.eventId
                const URL = `/api/events/${eventId}/users/${user.id}`
                let brandEventFrom = new FormData()
                brandEventFrom.append(`event_id`, eventId)
                brandEventFrom.append(`_method`, 'DELETE')
                brandEventFrom.append('user_id', user.id)
                axios.delete(URL, brandEventFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.userSuccessFullyRemoveFromEvent}`
                        })

                        this.$store.commit('removeUserFromUserList', user)
                    }
                })
            },

            onSelectUser(user) {
                const selectedUser = [{...user}]
                this.$store.commit('setAppointmentUsers', selectedUser)
            },

            reset() {
                this.$refs.brandEventForm.reset()
            },

            resetValidation() {
                this.$refs.brandEventForm.resetValidation()
            },

            onFetchBrands() {
                this.reset()
                this.resetValidation()
                this.$store.commit('setInitializeBrands')
            }
        }
    }
</script>
