<template>
    <div>

        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">drive_eta
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.create} ${trans.new}  ${trans.group}` }}
                </div>
            </div>
            <div class="r-tab-content"  :class="[showForm ? 'open' : '']">
                <v-layout row wrap pt-3 pl-3>
                    <v-flex xs12>
                        <Language v-if="editGroup"
                            :languageId="selectedGroup.language_id">
                        </Language>
                    </v-flex>

                     <v-flex xs12 sm4 mr-3>
                        <v-text-field
                            :label="trans.name"
                            v-model="selectedGroup.name"
                            :color="themeOption.inputColor"
                            solo 
                            box
                            flat>
                        </v-text-field>
                    </v-flex>

                    <v-flex xs12 sm4>
                        <span>{{trans.logo}}</span>

                        <v-img
                            :src="groupImage"
                            width="200"
                        ></v-img>

                        <FileUpload :preview="false"
                                    :multiple="false"
                                    model="'groups'">
                        </FileUpload>
                    </v-flex>
                </v-layout>
                <v-layout row class="justify-center">
                    <v-flex xs12>
                        <v-btn
                            small
                            dark 
                            class="rounded-btn"
                            :color="themeOption.buttonDangerColor"
                            @click="onCreateGroup">
                            {{ `${trans.submit}` }}
                        </v-btn>
                    </v-flex>
                </v-layout>
            </div>
        </div>

        <v-layout row wrap>
            <v-flex xs12 pt-3>
                <v-data-table
                    :headers="headers"
                    :items="groups"
                    disable-initial-sort
                    :pagination.sync="pagination"
                    :no-results-text="`${trans.no} ${trans.group} ${trans.found}`"
                    :no-data-text="`${trans.no} ${trans.group} ${trans.found}`"
                    :rows-per-page-text="trans.rows_per_page"
                    :rows-per-page-items="rowsPerPage"
                    :total-items="totalGroup"
                    :loading="loading"
                    class="elevation-1 r-table"
                >
                    <template v-slot:items="props">
                        <td width="10%" class="text-xs-left"> 
                            <v-img
                                contain
                                :src="props.item.logo"
                                py-2>
                            </v-img> 
                        </td>
                        <td>{{ props.item.name }}</td>
                        <td class="text-xs-right">
                            <v-icon
                                small
                                dark
                                :color="themeOption.buttonSecondaryColor"
                                @click="onEditGroup(props.item)"
                            >
                                edit
                            </v-icon>

                            <v-icon
                                small
                                dark
                                :color="themeOption.buttonDangerColor"
                                @click="onDeleteGroup(props.item)"
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
                    <h3>{{ trans.delete }} {{ selectedGroup.name }}</h3>
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
                        @click="onCancelDeleteDialog()"
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
    import Language from "../../../components/Language";

    export default {
        components: {
            FileUpload,
            Language
        },

        data() {
            return {
                totalDesserts: 0,
                desserts: [],
                pagination: {},
                searchGroup: '',
                dialog: false,
                deleteDialog: false,
                editGroup: false,
                showForm: false,
                group: {
                    status: 1
                }
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
                groupImage: 'getUploadedImage',
                selectedLanguage: 'getSubSelectedLanguage'
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
            },

            // When language is change it will trigger
            selectedLanguage(value){
                this.$store.dispatch('fetchGroup', {
                    id: this.selectedGroup.id,
                    languageId : value.id,
                    edit: true
                })
            }
        },

        created() {
            this.$store.commit('setHeaderTitle', `${this.trans.manage} ${this.trans.groups}`)
            this.$store.commit('setNavTitle', `${this.trans.manage} ${this.trans.groups}`)
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
                if(group.logo){
                    this.$store.commit('setImage', group.logo)
                }
                // Check if group has logo, then set image
                this.$store.commit('setSelectedGroup', group)
                this.showForm = true
            },

            onDeleteGroup(Group) {
                this.$store.commit('setSelectedGroup', Group)
                this.deleteDialog = true
            },

            onCancelDeleteDialog(){
                this.deleteDialog = false
                this.onResetGroup()
            },

            confirmDeleteDealerships() {
                const selectedGroup = this.selectedGroup
                const URL = `/api/groups/${selectedGroup.id}`

                axios.delete(URL, {_method: 'delete'})
                    .then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${selectedGroup.name}  ${this.trans.successfully_deleted}`
                            })

                            this.initialize()
                            
                            this.onResetGroup()

                            this.deleteDialog = false
                        }
                    });
            },

            onCreateGroup() {
                let groupForm = new FormData()
                groupForm.append('name', this.selectedGroup.name)
                groupForm.append('logo', this.groupImage)

                // Set status value
                if(this.selectedGroup.status === true){
                    groupForm.append('status', 1)
                }else{
                    groupForm.append('status', 0)
                }

                let URL = `/api/groups`

                // Check if update or no
                if(this.editGroup){
                    URL += `/${this.selectedGroup.id}`
                    groupForm.append('_method', 'put')
                    groupForm.append('languageId', this.selectedGroup.language_id)
                }

                axios.post(URL, groupForm).then((response)=>{
                    this.initialize()

                    this.$store.commit('setSnackbarMessage', {
                        openMessage: true,
                        timeOut: this.themeOption.snackBarTimeout,
                        message: `${this.selectedGroup.name} ${this.editGroup ? this.trans.successfully_updated: this.trans.successfully_created}`
                    })

                    this.onResetGroup()
                })
            },

            onResetGroup() {
                this.editGroup = false
                this.$store.commit('setImage', '')
                this.$store.commit('setSelectedGroup', {})
            },

            onCancelGroup() {
                this.editGroup = false
                this.$store.commit('setSelectedGroup', {})
            },


            toggleForm() {
                this.showForm = !this.showForm

                if (this.showForm) {
                    this.$store.commit( 'setHeaderTitle', `${this.trans.create} ${this.trans.new} ${this.trans.group}` )
                    this.$store.commit( 'setNavTitle', `${this.trans.create} ${this.trans.new} ${this.trans.group}` )
                    this.onResetGroup()
                } else {
                    this.$store.commit( 'setHeaderTitle', `${this.trans.manage} ${this.trans.groups}` )
                    this.$store.commit( 'setNavTitle', `${this.trans.manage} ${this.trans.groups}` )
                }
            }
        }
    }
</script>
