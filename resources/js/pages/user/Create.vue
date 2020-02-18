<template>
    <v-container pa-0>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">person
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.create} ${trans.user}` }}
                </div>
            </div>
            <div class="r-tab-content" :class="[showForm ? 'open' : '']">

            <v-form
                row wrap
                ref="userForm"
                v-model="valid"
                lazy-validation>
                <v-layout row wrap>
                    <v-flex xs12 sm3 pa-2>
                        <v-text-field
                            :rules="[v => !!v || `${trans.firstName} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.firstName"
                            v-model="user.name"
                            box solo flat
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2>
                        <v-text-field
                            :rules="[v => !!v || `${trans.surName} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.surName"
                            v-model="user.surname"
                            box solo flat
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2>
                        <v-text-field
                            :rules="[v => !!v || `${trans.email} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.email"
                            v-model="user.email"
                            box solo flat
                            required
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2>
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
                            box solo flat
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2>
                        <v-text-field
                            :append-icon="confirmPassword ? 'visibility' : 'visibility_off'"
                            :rules="[v => !!v || `${trans.confirm} ${trans.is_required}`, confirmRule]"
                            required
                            :color="themeOption.inputColor"
                            :label="`${trans.confirm} ${trans.password}`"
                            :type="confirmPassword ? `text` : `password`"
                            @click:append="confirmPassword = !confirmPassword"
                            v-model="user.password_confirmation"
                            box solo flat
                        ></v-text-field>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2 v-if="authUser.level !== 'dealership'">
                        <v-select
                            :items="levels"
                            :rules="[v => !!v || `${trans.select_a} ${trans.rule}`]"
                            :color="themeOption.inputColor"
                            :label="trans.rule"
                            v-model="user.level"
                            @change="onFetchData"
                            box solo flat
                        >
                        </v-select>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2
                            v-if="user.level==='dealership'">
                        <v-select
                            :items="dealerships"
                            item-text="name"
                            item-value="id"
                            :rules="[v => !!v || `${trans.dealership} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.dealership"
                            v-model="user.dealershipId"
                            box solo flat
                        >
                        </v-select>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2
                            v-if="user.level === 'group'">
                        <v-select
                            :items="groups"
                            item-text="name"
                            item-value="id"
                            :rules="[ v => !!v || `${trans.group} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.group"
                            v-model="user.group_id"
                            box solo flat
                        ></v-select>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2
                            v-if="user.level ==='country' || user.level === 'region'"
                    >
                        <v-autocomplete
                            :items="countries"
                            item-text="name"
                            item-value="id"
                            :rules="[ v => !!v || `${trans.country} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.country"
                            v-model="user.country_id"
                            @change="getRegion"
                            box solo flat
                        ></v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2
                            v-if="user.level === 'brand' || user.level === 'region'">
                        <v-autocomplete
                            :items="brands"
                            item-text="name"
                            item-value="id"
                            :rules="[ v => !!v || `${trans.brand} ${trans.is_required}`]"
                            :color="themeOption.inputColor"
                            :label="trans.brand"
                            v-model="user.brand_id"
                            @change="getRegion"
                            box solo flat
                        ></v-autocomplete>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2
                            v-if="user.level === 'region'">
                        <v-select :items="regions"
                                item-text="name"
                                item-value="id"
                                :color="themeOption.inputColor"
                                :rules="[v => !!v || `${trans.region} ${trans.is_required}`]"
                                :label="trans.region"
                                v-model="user.region_id"
                                box solo flat
                        ></v-select>
                    </v-flex>

                    <v-flex xs12 sm3 pa-2
                            v-if="user.level === 'company'">
                        <v-select
                            :items="companies"
                            item-text="name"
                            item-value="id"
                            :color="themeOption.inputColor"
                            :rules="[ v => !!v || `${trans.company} ${trans.is_required}`]"
                            :label="trans.company"
                            v-model="user.company_id"
                            box solo flat
                        ></v-select>
                    </v-flex>
                </v-layout>

                <v-layout class="justify-center">
                    <v-btn
                        dark
                        class="rounded-btn"
                        :color="themeOption.buttonDangerColor"
                        small
                        @click="onCreateUser()"
                    >
                        {{ `${trans.submit}` }}
                    </v-btn>
                </v-layout>
            </v-form>
            </div>
        </div>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
import { log } from 'util'

    export default {
        data() {
            return {
                valid: true,
                user: {
                    status: 1
                },
                password: false,
                confirmPassword: false,
                accessLevels: [],
                profileImage: '',
                showForm: false
            }
        },


        props:{
          subComponent: {
              type: Boolean,
              default: false
          },

          model: {
              type: String
          }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                authUser: 'getAuthUser',
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
                    v => v && v.length >= 8 || `${this.trans.password} ${this.trans.minimum8Character}`
                ]
            },

            confirmRule() {
                return () => (this.user.password === this.user.password_confirmation) || `${this.trans.password} ${this.trans.notMatch}`
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

            onFetchData() {
                const level = this.user.level
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
            },

            onCreateUser() {
                if (this.$refs.userForm.validate()) {

                    // Set form object for dealership
                    let userForm = new FormData()

                    if(this.subComponent){
                        userForm.append('dealershipId', this.$route.params.dealershipId)
                        userForm.append('level', 'sales_executive')
                    }

                    _.forOwn(this.user, (value, key) => {

                        if (key === 'status') {
                            if (value === 'true') {
                                userForm.append('status', 1)
                            } else {
                                userForm.append('status', 0)
                            }
                        } else {
                            userForm.append(key, value)
                        }
                    })

                    // add user profile image
                    userForm.append('profile_image', this.profileImage)
                    const URL = `/api/users`
                    axios.post(URL, userForm).then((response) => {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.user}  ${this.trans.successfully_created}`
                        })


                        this.showForm = false
                        this.$refs.form.reset()

                    })
                }
            },

            onProfileImageUpload() {
                const image = this.$refs.profileImage.files[0]

                let formData = new FormData()
                formData.append('file', image)
                formData.append('model', 'users')

                axios.post('/api/uploadfiles', formData).then((response) => {
                    this.profileImage = response.data
                })
            },

            toggleForm() {
                this.showForm = !this.showForm


                if (this.showForm) {
                    this.$store.commit( 'setHeaderTitle', `${this.trans.create} ${this.trans.new} ${this.trans.user}` )
                    this.$store.commit( 'setNavTitle', `${this.trans.create} ${this.trans.new} ${this.trans.user}` )
                } else {
                    this.$store.commit( 'setHeaderTitle', `${this.trans.manage} ${this.trans.users}` )
                    this.$store.commit( 'setNavTitle', `${this.trans.manage} ${this.trans.users}` )
                }
            }
        }
    }
</script>
