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

                    <v-toolbar-title>{{ `${trans.upload} ${trans.guests}` }}</v-toolbar-title>

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
                        :items="guests"
                        select-all
                        item-key="first_name"
                        class="elevation-1"
                        v-if="guests.length > 0"
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
                                    :class="['column sortable', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
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

                                <td>{{ props.item.first_name }}</td>
                                <td>{{ props.item.surname }}</td>
                                <td>{{ props.item.email }}</td>
                                <td>{{ props.item.address_line_1 }}</td>
                                <td>{{ props.item.address_line_2 }}</td>
                                <td>{{ props.item.address_line_3 }}</td>
                                <td>{{ props.item.address_line_4 }}</td>
                                <td>{{ props.item.address_line_5 }}</td>
                                <td>{{ props.item.address_line_6 }}</td>
                                <td>{{ props.item.postcode }}</td>
                                <td>{{ props.item.landline }}</td>
                                <td>{{ props.item.mobile }}</td>
                            </tr>
                        </template>
                    </v-data-table>
                </v-card-text>

                <div style="flex: 1 1 auto;"></div>
            </v-card>
        </v-dialog>

        <v-btn :color="themeOption.buttonPrimaryColor"
               small
               @click="onAddGuests()"
        >{{ `${trans.upload} ${trans.guests}` }}
        </v-btn>
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
                guests: [],
                dialog: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
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

                const URL = `/api/guests/upload`

                axios.post(URL, guestForm).then((response) => {
                    if (response.data.success) {
                        this.guests = [...response.data.guests]
                    }
                })
            },

            toggleAll() {
                if (this.selected.length) this.selected = []
                else this.selected = this.guests.slice()
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
                        value: 'firstName'
                    },
                    {
                        text: `${trans.surName} `,
                        value: 'surName'
                    },
                    {
                        text: `${trans.email} `,
                        value: 'email'
                    },

                    {
                        text: `${trans.address_line} 1`,
                        value: 'add1'
                    },

                    {
                        text: `${trans.address_line} 2`,
                        value: 'add2'
                    },

                    {
                        text: `${trans.address_line} 3`,
                        value: 'add1'
                    },

                    {
                        text: `${trans.address_line} 4`,
                        value: 'add1'
                    },

                    {
                        text: `${trans.address_line} 5`,
                        value: 'add5'
                    },

                    {
                        text: `${trans.address_line} 6`,
                        value: 'add6'
                    },

                    {
                        text: `${trans.postcode}`,
                        value: 'postcode'
                    },

                    {
                        text: `${trans.landline}`,
                        value: 'landline'
                    },

                    {
                        text: `${trans.mobile}`,
                        value: 'mobile'
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
                let uploadGuestForm = new FormData()
                uploadGuestForm.append('eventId', this.$route.params.id)

                _.map(this.selected, (guest, key) => {
                    _.forOwn(guest, (value, field) => {
                        uploadGuestForm.append(`guests[${key}][${field}]`, value)
                    })
                    uploadGuestForm.append(`guests[${key}][status]`, 1) // Default status is active
                })

                // Save into database
                axios.post('/api/guests/upload/confirm', uploadGuestForm).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.guests}  ${this.trans.successfully_upload}`
                        })
                        this.$store.commit('setInitializeGuest')
                        this.dialog = false
                    }
                })
            }
        }
    }
</script>
