<template>
    <div class="d-flex">
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            scrollable
        >
            <v-card tile>
                <v-toolbar card dark>
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>

                    <v-toolbar-title>{{ `${trans.upload} ${trans.users}` }}</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-toolbar-items>
                        <v-btn dark flat
                               v-if="selected.length > 0"
                               @click="onConfirmUpload()">
                            {{ trans.save }}
                        </v-btn>
                    </v-toolbar-items>

                    <v-menu bottom right offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn dark icon v-on="on">
                                <v-icon>more_vert</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-tile v-for="(item, i) in getNavItem()"
                                         :key="item.type"
                                         @click="onNavItemClick(item)">
                                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                </v-toolbar>

                <v-card-text>
                    <input
                        ref="guestCSV"
                        type="file"
                        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                        class="hidden-screen-only"
                        @change="onUploadCSV"
                    />
                    <v-btn :color="themeOption.buttonPrimaryColor"
                           dark
                           small
                           @click="onClickUploadCSV()">
                        {{ `${trans.upload} ${trans.csv}`}}
                    </v-btn>

                    <v-divider class="my-3"></v-divider>

                    <v-data-table
                        v-model="selected"
                        :headers="getHeader()"
                        hide-actions
                        :items="users"
                        select-all
                        item-key="first_name"
                        class="elevation-1"
                        v-if="users.length > 0"
                    >
                        <template v-slot:headers="props">
                            <tr>
                                <th>
                                    <v-checkbox
                                        :color="themeOption.inputColor"
                                        :input-value="props.all"
                                        :indeterminate="props.indeterminate"
                                        primary
                                        hide-details
                                        @click.stop="toggleAll"
                                    ></v-checkbox>
                                </th>
                                <th
                                    v-for="header in props.headers"
                                    :key="header.text"
                                    :class="['column sortable text-xs-left', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                    @click="changeSort(header.value)"
                                >
                                    <v-icon small>arrow_upward</v-icon>
                                    {{ header.text }}
                                </th>
                            </tr>
                        </template>

                        <template v-slot:items="props">
                            <tr :active="props.selected"
                                @click="props.selected = !props.selected">
                                <td>
                                    <v-checkbox
                                        :color="themeOption.inputColor"
                                        :input-value="props.selected"
                                        primary
                                        hide-details
                                    ></v-checkbox>
                                </td>

                                <td>{{ props.item.name }}</td>
                                <td>{{ props.item.surname }}</td>
                                <td>{{ props.item.email }}</td>
                                <td>{{ props.item.password }}</td>
                            </tr>
                        </template>
                    </v-data-table>

                    <v-card v-if="existingUsers.length > 0" class="mt-5">
                        <v-card-title>
                            <h2>Existing users</h2>
                        </v-card-title>

                        <v-card-text>
                            <v-list two-line>
                                <template v-for="(user, index) in existingUsers">
                                    <v-list-tile
                                        :key="user.name"
                                        avatar
                                        @click=""
                                    >

                                        <v-list-tile-content>
                                            <v-list-tile-title>{{ user.name }}</v-list-tile-title>
                                            <v-list-tile-sub-title>{{ user.email }}</v-list-tile-sub-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                </template>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-card-text>

                <div style="flex: 1 1 auto;"></div>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data() {
            return {
                pagination: {
                    sortBy: 'firstName'
                },

                selected: [],
                users: [],
                existingUsers: []
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            }),

            dialog:{
                get(){
                     return this.$store.getters.getUploadUserDialog
                },

                set(value){
                    this.$store.commit('setUploadUserDialog', value)
                }
            }
        }),

        methods: {
            onAddGuests() {
                this.dialog = true
            },

            onClickUploadCSV() {
                this.$refs.guestCSV.click()
            },

            onUploadCSV() {
                const csvFile = this.$refs.guestCSV.files[0]
                let guestForm = new FormData()
                guestForm.append('file', csvFile)
                guestForm.append('eventId', this.$route.params.id)

                const URL = `/api/users/upload`

                axios.post(URL, guestForm).then((response) => {
                    if (response.data.success) {
                        let users = [...response.data.users]
                        users = _.uniqBy(users, (user) => {
                            return user.email
                        })

                        this.users = [...users]
                    }
                })
            },

            toggleAll() {
                if (this.selected.length) this.selected = []
                else this.selected = this.users.slice()
            },

            getNavItem() {
                return [
                    {
                        title: this.trans.reset,
                        type: 'clear'
                    },

                    {
                        title: `${this.trans.upload} ${this.trans.csv}`,
                        type: 'upload'
                    }
                ]
            },

            onNavItemClick(nav) {

            },


            getHeader() {
                const trans = {...this.trans}

                return [
                    {
                        text: `${trans.firstName} `,
                        value: 'firstName',
                        align:'left'
                    },
                    {
                        text: `${trans.surName} `,
                        value: 'surName',
                        align:'left'
                    },
                    {
                        text: `${trans.email} `,
                        value: 'email',
                        align:'left'
                    },

                    {
                        text: `${trans.password}`,
                        value: 'password',
                        align:'left'
                    }
                ]
            },

            changeSort(column) {
                if (this.pagination.sortBy === column) {
                    this.pagination.descending = !this.pagination.descending
                } else {
                    this.pagination.sortBy = column
                    this.pagination.descending = false
                }
            },

            onConfirmUpload() {
                let uploadUserForm = new FormData()
                uploadUserForm.append('dealershipId', this.$route.params.id)

                _.map(this.selected, (user, key) => {
                    _.forOwn(user, (value, field) => {
                        uploadUserForm.append(`users[${key}][${field}]`, value)
                    })
                    uploadUserForm.append(`users[${key}][status]`, 1) // Default status is active
                    uploadUserForm.append(`users[${key}][level]`, 'sales_executive') // Default status is active
                })

                // Save into database
                axios.post('/api/users/upload/confirm', uploadUserForm).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.guests}  ${this.trans.successfully_upload}`
                        })
                        this.existingUsers = [...response.data.existingUsers]
                        this.$store.commit('setInitializeGuest')
                        console.log('existins: ', this.existingUsers)

                        // this.$store.commit('setUploadUserDialog', false)
                    }
                })
            }
        }
    }
</script>
