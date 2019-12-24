<template>
    <div >
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.guests }}</span>
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
                v-model="searchGuests">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="guests"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.brand} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.brand} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalGuests"
                    :loading="loading"
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <td>{{ `${props.item.first_name} ${props.item.surname}` }}</td>
                        <td>{{ props.item.email }}</td>
                        <td class="text-xs-left">{{ `${props.item.mobile}` }}</td>
                        <td class="text-xs-left">{{ `${props.item.address_line_1} ${props.item.address_line_2}` }}</td>
                        <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                class="mr-2"
                                @click="$router.push({name: 'editGuest', params:{id: props.item.id}})"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                :color="themeOption.buttonDangerColor"
                                small
                                @click="onDeleteGuest(props.item)"
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
                    <h3>{{ trans.delete }} {{selectedGuest.firstname }}</h3>
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

    export default {
        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                searchGuests: '',
                selectedGuest:{}
            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                guests: 'getGuests',
                headers: 'getGuestListHeader',
                totalGuests: 'getTotalGuests',
                loading: 'getGuestLoading',
                rowsPerPage: 'getGuestListRowsPerPage'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            searchGuests() {
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
                    search: this.searchGuests
                }

                this.$store.dispatch('fetchGuests', paginateOption)
            },

            onEditGuest(guest){

            },

            onDeleteGuest(guest){
                this.selectedGuest = {...guest}
                this.deleteDialog = true
            },

            onDeleteConfirm(){
                // Delete guest
                const URL = `/api/guests/${this.selectedGuest.id}`
                axios.delete(URL).then((response)=>{
                    this.deleteDialog = false
                    this.initialize()

                    this.$store.commit('setSnackbarMessage', {
                        openMessage: true,
                        timeOut: this.themeOption.snackBarTimeout,
                        message: `${this.selectedGuest.first_name}  ${this.trans.successfully_deleted}`
                    })
                })
            }
        }
    }
</script>
