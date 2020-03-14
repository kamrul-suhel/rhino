<template>
    <v-layout row wrap mt-3>
        <v-flex xs12 sm8>
            <v-card flat>
                <v-card-text class="pa-0">
                    <v-data-table
                        :headers="headers"
                        :items="specializeBrands"
                        disable-initial-sort
                        :pagination.sync="pagination"
                        :no-results-text="`${trans.noBrandsFound}`"
                        :no-data-text="`${trans.noBrandsFound}`"
                        :rows-per-page-text="trans.rows_per_page"
                        :rows-per-page-items="rowsPerPage"
                        :total-items="totalSpecializeBrands"
                        :loading="loading"
                        class="elevation-1 r-table"
                    >
                        <template v-slot:items="props">
                            <td>{{ props.item.brand_name }}</td>
                            <td class="text-xs-center">
                                <v-checkbox
                                    class="eventVehicleSwitch"
                                    :color="themeOption.inputColor"
                                    :false-value="0"
                                    :true-value="1"
                                    v-model="props.item.new"
                                    @change="onBrandUserChange(props.item)"
                                ></v-checkbox>
                            </td>

                            <td class="text-xs-center">
                                <v-checkbox
                                    class="eventVehicleSwitch mx-auto"
                                    :false-value="0"
                                    :true-value="1"
                                    :color="themeOption.inputColor"
                                    v-model="props.item.used"
                                    return-object
                                    @change="onBrandUserChange(props.item)"
                                ></v-checkbox>
                            </td>

                            <td class="text-xs-right">
                                <v-icon
                                    :color="themeOption.buttonDangerColor"
                                    small
                                    @click="onDeleteUserBrand(props.item)"
                                >
                                    delete
                                </v-icon>
                            </td>
                        </template>
                    </v-data-table>
                </v-card-text>
            </v-card>
        </v-flex>

        <v-flex xs12 sm4>
            <v-form ref="brandUserForm"
                    v-model="valid"
                    lazy-validation
                    class="pl-2"
            >
                <v-card>
                    <v-card-title>
                        <h3>{{ `${trans.addBrand}` }}</h3>
                    </v-card-title>

                    <v-divider></v-divider>

                    <v-card-text>
                        <v-layout row wrap>
                            <v-flex xs12>
                                <v-select :label="`${trans.selectABrand}`"
                                          :color="themeOption.inputColor"
                                          :items="availableBrands"
                                          item-text="brand"
                                          :rules="[v => !!v || `${trans.selectABrand}`]"
                                          required
                                          v-model="selectedBrand"
                                          return-object
                                >
                                </v-select>
                            </v-flex>
                        </v-layout>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn small
                                dark
                               @click="onCreateRelation"
                               :color="themeOption.buttonSuccess"
                               class="rounded-btn"
                        >
                            {{ `${trans.addBrand}` }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                valid: true,
                dialog: false,
                pagination: {},
                selectedBrand: null,
                availableBrands: []
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                specializeBrands: 'getSpecializeBrands',
                headers: 'getSpecializeBrandListHeader',
                totalSpecializeBrands: 'getTotalSpecializeBrand',
                loading: 'getSpecializeBrandLoading',
                rowsPerPage: 'getSpecializeBrandListRowsPerPage',
                brands: 'getBrandsByDealership',
                user: 'getSelectedUser'
            })
        }),

        watch: {
            pagination: {
                handler() {
                    this.initialize()
                }
            },

            specializeBrands() {
                this.updateBrandDropdown()
            },

            user(){
                this.initialize()
                this.fetchBrandByDealership()
            },

            brands(){
                this.updateBrandDropdown()
            }
        },

        created() {
            this.fetchBrandByDealership()
        },

        methods: {
            // Initialize data when first render
            initialize() {
                if(this.user){
                    const paginateOption = {
                    ...this.pagination,
                    trans: this.trans,
                    themeOption: this.themeOption,
                    paginate: true,
                    search: this.searchBrands,
                    userId: this.user.id
                }

                this.$store.dispatch('fetchSpecializeBrandByDealershipId', paginateOption)
                }

            },

            fetchBrandByDealership() {
                if(this.user){
                    const dealershipId = this.user.dealership_id

                this.$store.dispatch('fetchBrandsByDealershipId', {
                    dealershipId: dealershipId,
                    trans: this.trans,
                    themeOption: this.themeOption
                })
                }

            },

            updateBrandDropdown() {
                let newAvailableBrands = []
                _.map(this.brands, (brand) => {
                    const index = _.findIndex(this.specializeBrands, (specializeBrand) => {
                        return brand.brand_id === parseInt(specializeBrand.brand_id)
                    })

                    if (index === -1) {
                        newAvailableBrands.push(brand)
                    }
                })
                this.availableBrands = [...newAvailableBrands]
            },

            /**
             * Updating bran user info
             * @param brandUser
             */
            onBrandUserChange(brandUser) {
                let brandUserForm = new FormData()
                _.forOwn(brandUser, (value, key) => {
                    brandUserForm.append(key, value)
                })

                const URL = `/api/users/${this.user.id}/brand/${brandUser.id}`

                axios.post(URL, brandUser).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.brandSuccessfullyUpdated}`
                        })
                    }
                })
            },

            onDeleteUserBrand(userBrand) {
                const URL = `/api/users/${userBrand.user_id}/brand/${userBrand.id}`

                axios.delete(URL).then((response) => {
                    if (response.data.success) {
                        this.updateRecord(userBrand, false)
                    }
                })
            },

            onCreateRelation() {
                if (this.$refs.brandUserForm.validate()) {
                    let brandUser = new FormData()
                    brandUser.append('brand_id', this.selectedBrand.brand_id)
                    brandUser.append('user_id', this.user.id)

                    const URL = `/api/users/${this.user.id}/brand`
                    axios.post(URL, brandUser).then((response) => {
                        if (response.data.success) {
                            const brand = {
                                ...response.data.brand,
                                brand_name: this.selectedBrand.brand,
                                user_name: null,
                                new: 1,
                                used: 1
                            }

                            this.updateRecord(brand, true)
                        }
                    })
                }
            },

            updateRecord(userBrand, add) {
                // Update add brand reset
                this.$refs.brandUserForm.reset()

                const message = `${add ? this.trans.brandSuccessfullyAdded : this.trans.brandSuccessfullyRemoved}`
                this.$store.commit('setSnackbarMessage', {
                    openMessage: true,
                    timeOut: this.themeOption.snackBarTimeout,
                    message: message
                })

                add ? this.$store.commit('addSpecializeBrand', userBrand) : this.$store.commit('removeSpecializeBrand', userBrand)
            }
        }
    }
</script>
