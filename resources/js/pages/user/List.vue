<template>
    <div >
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.users }}</span>
            </v-toolbar-title>
            <v-divider
                class="mx-2"
                inset
                vertical
            ></v-divider>

            <v-spacer></v-spacer>

            <v-text-field
                :color="themeOption.inputColor"
                :label="trans.search_by_name"
                v-model="searchUsers">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="users"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_brand_found"
                    :no-data-text="trans.no_brand_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalUsers"
                    :loading="loading"
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.firstname }}</td>
                        <td>{{ props.item.email }}</td>
                        <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
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
    import {Chrome} from 'vue-color'
    import FileUpload from '../../components/ImageUpload'

    export default {
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
                rowsPerPage: 'getUserListRowsPerPage'
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

                this.$store.dispatch('fetchUsers', paginateOption)
            },

            onEditUser(user){

            },

            onDeleteUser(user){
                this.selectedUser = {...user}
                this.deleteDialog = true
            },

            onDeleteConfirm(){
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
</script>
