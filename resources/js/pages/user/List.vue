<template>
    <div >

        <addUserForm></addUserForm>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="users"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.users} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.users} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalUsers"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.firstname }} {{ props.item.surname }}</td>
                        <td>{{ props.item.email }}</td>
                        <td class="text-xs-left" v-if="!subComponent">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                        <td class="text-xs-left" v-if="!subComponent">{{ props.item.level }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                v-if="!subComponent"
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
            </v-flex>
        </v-layout>

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
                        {{ trans.delete_confirmation }}
                    </v-flex>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions class="pa-3">
                    <v-spacer></v-spacer>
                    <v-btn
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="onDeleteConfirm"
                    >
                        {{ trans.delete }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import addUserForm from './Create'

    export default {
        components: {
            addUserForm
        },

        props:{
            subComponent:{
                type: Boolean,
                default: false
            },

            model:{
                type: String
            }
        },

        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                searchUsers: '',
                selectedUser:{}
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                users: 'getUsers',
                headers: 'getUserListHeader',
                totalUsers: 'getTotalUsers',
                loading: 'getUserLoading',
                rowsPerPage: 'getUserListRowsPerPage',
                update: 'getInitialize'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            searchUsers() {
                this.initialize()
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.manage} ${this.trans.users}`)
            this.$store.commit('setNavTitle', `${this.trans.users}`)
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchUsers
                }


                // Check component load as a sub component
                if(this.subComponent){
                    switch(this.model){
                        case 'dealership':
                            const pagination = {
                                ...paginateOption,
                                dealershipId: this.$route.params.dealershipId,
                                eventId: this.$route.params.eventId,
                                subComponent: this.subComponent,
                                model: this.model
                            }
                            this.$store.dispatch('fetchUsersForEvent', pagination)
                            break;
                    }
                }else{
                    this.$store.dispatch('fetchUsers', paginateOption)
                }
            },

            onEditUser(user){

            },

            onDeleteUser(user){
                if(this.subComponent){
                    const eventId = this.$route.params.eventId
                    switch(this.model){
                        case 'dealership':
                            const URL = `/api/events/${eventId}/users/${user.id}`
                            axios.delete(URL).then((response)=>{
                                this.$store.commit('setSnackbarMessage', {
                                    openMessage: true,
                                    timeOut: this.themeOption.snackBarTimeout,
                                    message: `${this.trans.user}  ${this.trans.successfully_remove} ${this.trans.from} ${this.trans.event}`
                                })

                                if(response.data.success){
                                    this.$store.commit('removeUserFromUserList', user)
                                }
                            })
                    }
                }else{
                    this.selectedUser = {...user}
                    this.deleteDialog = true
                }
            },

            onDeleteConfirm(){
                if(this.subComponent){
                    const eventId = this.$route.params.eventId
                    switch(this.model){
                        case 'dealership':
                            const URL = `/api/events/${eventId}/users/${user.id}`
                            axios.delete(URL).then((response)=>{
                                if(response.data.success){
                                    this.$store.commit('setSnackbarMessage', {
                                        openMessage: true,
                                        timeOut: this.themeOption.snackBarTimeout,
                                        message: `${this.selectedUser.firstname}  ${this.trans.successfully_remove} ${this.trans.from} ${this.trans.event}`
                                    })
                                    this.$store.commit('setInitialize')
                                }
                            })
                    }
                }else{
                    // Delete user
                    const URL = `/api/users/${this.selectedUser.id}`
                    axios.delete(URL).then((response)=>{
                        this.deleteDialog = false
                        this.initialize()

                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.selectedUser.firstname}  ${this.trans.successfully_deleted}`
                        })
                    })
                }
            }
        }
    }
</script>
