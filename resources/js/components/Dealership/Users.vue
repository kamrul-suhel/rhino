<template>
    <v-layout row wrap>
        <v-flex xs12>
            <v-card flat>
                <v-card-text>
                    <v-data-table
                        :headers="headers"
                        :items="users"
                        disable-initial-sort
                        :pagination.sync="pagination"
                        :no-results-text="`${trans.noUsersFound}`"
                        :no-data-text="`${trans.noUsersFound}`"
                        :rows-per-page-text="trans.rowsPerPage"
                        :rows-per-page-items="rowsPerPage"
                        :total-items="totalUsers"
                        :loading="loading"
                        class="elevation-1 r-table"
                    >
                        <template v-slot:items="props">
                            <td>{{ props.item.firstname }}</td>
                            <td>{{ props.item.surname }}</td>
                            <td>{{ props.item.email }}</td>
                            <td class="text-xs-left">{{ props.item.level }}</td>
                            <td class="text-xs-right">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="$router.push({name: 'editUsers', params:{id: props.item.id}})"
                                >
                                    edit
                                </v-icon>

                                <v-icon
                                    :color="themeOption.buttonDangerColor"
                                    small
                                    @click="onDeleteUser(props.item)"
                                >
                                    delete
                                </v-icon>
                            </td>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-dialog
            v-model="deleteDialog"
            persistent
            max-width="290"
        >
            <v-card>
                <v-card-title
                    primary-title
                    class="pa-2 pl-3"
                >
                    <h3>{{ trans.delete }} {{selectedUser.firstname }}</h3>
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text>
                    <v-flex xs12>
                        {{ trans.deleteConfirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        dark
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        dark
                        :color="themeOption.buttonDangerColor"
                        small
                        @click="onDeleteConfirm"
                    >
                        {{ trans.delete }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-layout>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        components: {},

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                users: 'getUsers',
                headers: 'getUserListHeader',
                totalUsers: 'getTotalUsers',
                loading: 'getUserLoading',
                rowsPerPage: 'getUserListRowsPerPage',
                initializeBrands: 'getInitializeBrands',
                selectedEvent: 'getSelectedEvent',
                initializeUser: 'getInitializeUser'
            })
        }),

        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                selectedUser: {}
            }
        },

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            initializeBrands() {
                this.initialize()
            },

            initializeUser(){
                this.initialize()
            }
        },

        created() {

        },

        methods: {
            // Initialize data when first render
            initialize() {
                // this.$refs.createBrand.resetValidation()
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    filterBy: 'dealership',
                    dealershipId: this.$route.params.id
                }

                this.$store.dispatch('fetchUsers', paginateOption)
            },

            onDeleteUser(user) {
                this.selectedUser = {...user}
                this.deleteDialog = true
            },

            onDeleteConfirm() {    
                // Delete user
                const URL = `/api/users/${this.selectedUser.id}`
                axios.delete(URL).then((response) => {
                    this.deleteDialog = false
                    this.initialize()

                    if ( response.data.success == true){
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.selectedUser.firstname} ${this.selectedUser.surname} ${this.trans.successfullyDeleted}`
                        })
                    }

                    if ( response.data.success == false){
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.userHasBookings}`
                        })
                    }

                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
                
            },
        }
    };
</script>
