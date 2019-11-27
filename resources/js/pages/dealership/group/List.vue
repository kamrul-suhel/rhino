<template>
    <div>
        <v-toolbar flat>
            <v-toolbar-title>
                <span :class="themeOption.textHeadingColor+'--text'">{{ trans.groups }}</span>
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
                v-model="searchGroup">
            </v-text-field>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex xs12 sm8 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="groups"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="trans.no_group_found"
                    :no-data-text="trans.no_group_found"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalGroup"
                    :loading="loading"
                    class="elevation-1"
                >
                    <template v-slot:items="props">
                        <td>{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.group }}</td>
                        <td class="text-xs-left">{{ props.item.status === 1 ? trans.active: trans.inactive }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                class="mr-2"
                                @click="onEditGroup(props.item)"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                small
                                @click="onDeleteGroup(props.item)"
                            >
                                delete
                            </v-icon>
                        </td>
                    </template>
                </v-data-table>
            </v-flex>

            <v-flex xs12 sm4 pt-3 pl-3>
                <v-card>
                    <v-card-title>
                        <h3>{{ editGroup ? trans.edit_group : trans.create_groups}}</h3>
                    </v-card-title>
                    <v-divider></v-divider>

                    <v-card-text>
                        <v-text-field
                            :label="trans.name"
                            v-model="selectedGroup.name"
                            :color="themeOption.inputColor"
                        ></v-text-field>

                        <v-flex xs12>
                            <span>{{trans.logo}}</span>

                            <v-img
                                :src="groupImage"
                                aspect-ratio="2.75"
                            ></v-img>

                            <FileUpload :preview="false"
                                        :multiple="false"
                                        model="'groups'">
                            </FileUpload>
                        </v-flex>
                    </v-card-text>

                    <v-card-actions class="pa-2">
                        <v-spacer></v-spacer>
                        <v-btn
                            small
                            :color="themeOption.buttonPrimaryColor"
                            @click="onResetGroup">
                            {{trans.cancel}}
                        </v-btn>

                        <v-btn
                            small
                            :color="themeOption.buttonSecondaryColor"
                            @click="onCreateGroup">
                            {{ editGroup ? trans.update_group : trans.add_group}}
                        </v-btn>
                    </v-card-actions>
                </v-card>
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
                    <h3>{{ trans.delete }} selectedGroup.name }}</h3>
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
                        color="info"
                        small
                        @click="deleteDialog = false"
                    >
                        {{ trans.cancel }}
                    </v-btn>

                    <v-btn
                        color="red"
                        small
                        @click="confirmDeleteDealerships()"
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
    import FileUpload from '../../../components/ImageUpload'

    export default {
        components: {
            FileUpload
        },

        data() {
            return {
                totalDesserts: 0,
                desserts: [],
                pagination: {},
                searchGroup: '',
                dialog: false,
                deleteDialog: false,
                editGroup: false
            }
        },

        computed: ({
            ...mapGetters({
                groups: 'getGroups',
                trans: 'getFields',
                headers: 'getGroupListHeader',
                totalGroup: 'getTotalGroup',
                loading: 'getGroupLoading',
                rowsPerPage: 'getGroupListRowsPerPage',
                selectedGroup: 'getSelectedGroup',
                themeOption: 'getThemeOption',
                groupImage: 'getUploadedImage'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    const paginateOption = {
                        ...this.pagination,
                        trans: this.trans,
                        paginate: true
                    }
                    this.initialize()
                }
            },

            searchGroup(value) {
                this.initialize()
            },

            headers(value) {
                console.log('header is; ', value)
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
                    search: this.searchGroup
                }

                this.$store.dispatch('fetchGroups', paginateOption)
            },

            onEditGroup(group) {
                this.editGroup = true
                // Check if group has logo, then set image
                if(group.logo){
                    console.log(group.logo)
                    this.$store.commit('setImage', group.logo)
                }
                this.$store.commit('setSelectedGroup', group)
            },

            onDeleteGroup(Dealerships) {
                this.$store.commit('setSelectedDealership', Dealerships)
                this.deleteDialog = true
            },

            confirmDeleteDealerships() {
                const selectedDealership = this.selectedDealership
                const URL = `/api/dealerships/${selectedDealership.id}/delete`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedDealership.name}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            // reset selectedDealerships in store
                            this.$store.commit('setSelectedDealership', {})

                            this.deleteDialog = false
                        }
                    });
            },

            onCreateGroup() {

            },

            onResetGroup() {
                this.editGroup = false
                this.$store.commit('setSelectedGroup', {})
            },

            onCancelGroup() {

            }
        }
    }
</script>
