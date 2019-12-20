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
                            v-for="user in users"
                            :key="user.id"
                            avatar
                            @click=""
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
                                           @click="onRemoveRelation(user.id)">
                                        <v-icon color="red lighten-1">remove_circle_outline</v-icon>
                                    </v-btn>

                                    <v-btn icon ripple
                                           v-else
                                           @click="onCreateRelation(user.id)">
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
                update: 'getInitialize'
            })
        }),

        watch: {
            update() {
                this.initialize()
            },

            selectedUsers() {
                this.initialize()
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchUsersByDealershipId', {dealershipId: this.$route.params.dealershipId})
            },

            checkUserExists(user) {
                const found = _.find(this.selectedUsers, (selectedUser) => {
                    return user.id === selectedUser.id
                })

                if (found) {
                    return true
                }
                return false
            },

            onCreateRelation(userId) {
                const URL = `/api/events/${this.$route.params.eventId}/users`

                let eventUserFrom = new FormData()
                eventUserFrom.append(`event_id`, this.$route.params.eventId)
                eventUserFrom.append('user_id', userId)
                axios.post(URL, eventUserFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.user}  ${this.trans.has_been_added.toLowerCase()} ${this.trans.to.toLowerCase()} ${this.trans.event}`
                        })
                        this.$store.commit('setInitialize')
                    }
                })
            },

            onRemoveRelation(userId) {
                const URL = `/api/events/${eventId}/users/${userId}`
                let brandEventFrom = new FormData()
                brandEventFrom.append(`event_id`, eventId)
                brandEventFrom.append(`_method`, 'DELETE')
                brandEventFrom.append('user_id', userId)
                axios.delete(URL, brandEventFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.user}  ${this.trans.successfully_remove} ${this.trans.from} ${this.trans.event}`
                        })
                        this.$store.commit('setInitializeBrands')
                    }
                })
            },

            onSelectUser(user) {
                this.$store.commit('setSelectedUser', user)
                this.$store.commit('setInitializeAppointment')
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
