<template>
    <div >
        <v-toolbar flat
            :color="subComponent ? themeOption.toolbarColor : 'adminHeader'">
            <v-text-field xs12 sm4
                :color="themeOption.inputColor"
                :label="`${trans.searchBy} ${trans.name}`"
                v-model="searchGuests">
            </v-text-field>

            <v-btn
                dark
                :color="themeOption.buttonSuccess"
                v-if="!subComponent"
                small
                @click="$router.push({name: 'createGuest'})"
            >
                {{ `${trans.add} ${trans.guest}` }}
            </v-btn>

            <UploadGuestCSVComponent v-if="subComponent"></UploadGuestCSVComponent>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="guests"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.brand} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.guest} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page === null ? 'Row per page' : trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalGuests"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td>{{ `${props.item.first_name} ${props.item.surname}` }}</td>
                        <td>{{ props.item.email }}</td>
                        <td class="text-xs-left">{{ `${props.item.mobile}` }}</td>
                        <td class="text-xs-left">{{ `${props.item.address_line_1} ${props.item.address_line_2}` }}</td>
                        <td class="text-xs-left">{{ `${props.item.unique}` }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                class="mr-2"
                                @click="$router.push({name: 'editGuest', params:{id: props.item.id}})"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                v-if="!subComponent"
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

    import UploadGuestCSVComponent from "@/components/Guest/UploadGuestCSVComponent";

    export default {
        components: {
            UploadGuestCSVComponent
        },

        data() {
            return {
                pagination: {},
                dialog: false,
                deleteDialog: false,
                searchGuests: '',
                selectedGuest:{}
            }
        },

        props:{
          subComponent:{
              type: Boolean,
              default: false
          },

          model: {
              type: String
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
                rowsPerPage: 'getGuestListRowsPerPage',
                updateGuest: 'getInitializeGuest'
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
            },

            updateGuest(){
                this.initialize()
            }
        },

        created() {
            if(!this.subComponent){
                this.$store.commit('setHeaderTitle', `${this.trans.manage} ${this.trans.guests}` )
                this.$store.commit('setNavTitle', `${this.trans.guests}`)
            }
        },

        mounted() {
        },
        methods: {
            // Initialize data when first render
            initialize() {
                let additionalOptions = {}
                // specific event then add id
                if(this.subComponent){
                    switch(this.model){
                        case 'event': // load event specific guest
                            additionalOptions = {
                                eventId : this.$route.params.id
                            }
                            break
                    }
                }
                const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchGuests,
                    ...additionalOptions
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
