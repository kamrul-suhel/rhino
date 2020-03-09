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
                        :no-results-text="`${trans.no} ${trans.users} ${trans.found}`"
                        :no-data-text="`${trans.no} ${trans.users} ${trans.found}`"
                        :rows-per-page-text="trans.rows_per_page"
                        :rows-per-page-items="rowsPerPage"
                        :total-items="totalUsers"
                        :loading="loading"
                        class="elevation-1 r-table"
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
                </v-card-text>
            </v-card>
        </v-flex>
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
                selectedEvent: 'getSelectedEvent'
            })
        }),

        data() {
            return {
                pagination: {},
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

            onDeleteBrand(brandId) {
                const URL = `/api/events/${this.selectedEvent.id}/brands/${brandId}`
                let brandEventFrom = new FormData()
                brandEventFrom.append(`brand_id`, brandId)
                brandEventFrom.append(`_method`, 'DELETE')
                brandEventFrom.append('event_id', this.selectedEvent.id)
                axios.delete(URL, brandEventFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setInitializeBrands')
                    }
                })
            }
        }
    };
</script>
