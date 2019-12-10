<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span
                            :class="themeOption.textHeadingColor+'--text'">{{ `${trans.create} ${trans.user}` }}</span>
                    </v-toolbar-title>

                    <v-divider
                        class="mx-2"
                        inset
                        vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                </v-toolbar>
            </v-flex>
        </v-layout>

        <v-form
            row wrap
            ref="dealershipForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-card>
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.firstName} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.firstName"
                                        v-model="user.firstname"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.surName} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.surName"
                                        v-model="user.surname"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 pa-2>
                                    <v-text-field
                                        :rules="[v => !!v || `${trans.email} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.email"
                                        v-model="user.email"
                                        required
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :append-icon="password ? 'visibility' : 'visibility_off'"
                                        :rules="passwordRule"
                                        required
                                        :color="themeOption.inputColor"
                                        :label="trans.password"
                                        :type="password ? `text` : `password`"
                                        v-model="user.password"
                                        @click:append="password = !password"
                                        :hint="`${trans.password} ${trans.minimum8Character}`"
                                    ></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        :append-icon="confirmPassword ? 'visibility' : 'visibility_off'"
                                        :rules="[v => !!v || `${trans.confirm} ${trans.is_required}`, confirmRule]"
                                        required
                                        :color="themeOption.inputColor"
                                        :label="`${trans.confirm} ${trans.password}`"
                                        :type="confirmPassword ? `text` : `password`"
                                        @click:append="confirmPassword = !confirmPassword"
                                        v-model="user.confirmPassword"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="levels"
                                        :rules="[v => !!v || trans.select_a_country]"
                                        :color="themeOption.inputColor"
                                        :label="trans.rule"
                                        v-model="user.level"
                                        @change="fetchData"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="dealerships"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[v => !!v || `${trans.dealership} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.dealership"
                                        v-model="user.dealership_id"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="groups"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[ v => !!v || `${trans.group} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.group"
                                        v-model="user.group_id"
                                    ></v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-autocomplete
                                        :items="countries"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[ v => !!v || `${trans.country} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.country"
                                        v-model="user.country_id"
                                        @change="getRegion"
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-autocomplete
                                        :items="brands"
                                        item-text="name"
                                        item-value="id"
                                        :rules="[ v => !!v || `${trans.brand} ${trans.is_required}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.brand"
                                        v-model="user.brand_id"
                                        @change="getRegion"
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select :items="regions"
                                              item-text="name"
                                              item-value="id"
                                              :color="themeOption.inputColor"
                                              :rules="[v => !!v || `${trans.region} ${trans.is_required}`]"
                                              :label="trans.region"
                                              v-model="user.region_id"
                                    ></v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-select :items="companies"
                                              item-text="name"
                                              item-value="id"
                                              :color="themeOption.inputColor"
                                              :rules="[ v => !!v || `${trans.company} ${trans.is_required}`]"
                                              :label="trans.company"
                                              v-model="user.company_id"
                                    ></v-select>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-switch
                                        :label="trans.status"
                                        :color="themeOption.inputColor"
                                        v-model="user.status">
                                    </v-switch>
                                </v-flex>
                            </v-layout>

                            <v-divider class="mt-2 mb-2"></v-divider>
                        </v-card-text>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                :class="themeOption.buttonSuccess"
                                small
                                @click="onCreateDealership()"
                            >
                                {{ `${trans.create} ${trans.user}` }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-form>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                valid: true,
                user: {},
                password: false,
                confirmPassword: false,
                accessLevels: []
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                levels: 'getUserLevels',
                dealerships: 'getDealerships',
                groups: 'getGroups',
                brands: 'getBrandsForDropDown',
                countries: 'getCountries',
                regions: 'getRegions',
                companies: 'getCompanies'
            }),

            passwordRule() {
                return [
                    v => !!v || `${this.trans.password} ${this.trans.is_required}`,
                    v => v && v.length <= 8 || `${this.trans.password} ${this.trans.minimum8Character}`
                ]
            },

            confirmRule() {
                return () => (this.user.password === this.user.confirmPassword) || `${this.trans.password} ${this.trans.notMatch}`
            }
        }),

        watch: {},

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.commit('setLevel', this.trans)
            },

            fetchData() {
                const level = this.user.level
                console.log(level)

                switch (level) {
                    case 'dealership':
                        this.$store.dispatch('fetchDealershipsForDropdown')
                        break

                    case 'group':
                        this.$store.dispatch('fetchGroupsForDropdown')
                        break

                    case 'region':
                        this.$store.dispatch('fetchBrandForDropDown')
                        this.$store.dispatch('fetchCountriesForDropdown')
                        break

                    case 'countries':
                        this.$store.dispatch('fetchCountriesForDropdown')
                        break

                    case 'brand':
                        this.$store.dispatch('fetchBrandForDropDown')
                        break

                    case 'company':
                        this.$store.dispatch('fetchCompanyForDropdown')

                }
            },

            getRegion() {
                if (this.user.country_id && this.user.brand_id) {
                    this.$store.dispatch('fetchRegionsByBrandIdAndCountryId', {
                        brandId: this.user.brand_id,
                        countryId: this.user.country_id
                    })
                }
            }
        }
    }
</script>
