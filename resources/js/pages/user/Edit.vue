<template>
    <v-container pa-0>
        <v-form
            row wrap
            ref="userForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-layout row wrap>
                        <v-flex xs12 sm4 pa-2>
                            <v-text-field
                                :rules="[v => !!v || `${trans.firstNameIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.firstName"
                                v-model="user.firstname"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 pa-2>
                            <v-text-field
                                :rules="[v => !!v || `${trans.surnameIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.surName"
                                v-model="user.surname"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 pa-2>
                            <v-text-field
                                :rules="[v => !!v || `${trans.emailIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.email"
                                v-model="user.email"
                                box solo flat
                                required
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm4 pa-2 v-if="authUser.level === 'admin'">
                            <v-select
                                :items="levels"
                                :rules="[v => !!v || `${trans.selectARole}`]"
                                :color="themeOption.inputColor"
                                :label="trans.accessLevel"
                                item-text="text"
                                item-value="value"
                                v-model="user.level"
                                @change="onFetchData"
                                box solo flat
                            >
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2
                                v-if="user.level ==='dealership' || user.level === 'sales_executive'">
                            <v-select
                                :items="dealerships"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || `${trans.dealershipIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.dealership"
                                v-model="user.dealership_id"
                                box solo flat
                            >
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2
                                v-if="user.level === 'group' || user.level ==='dealership'|| user.level === 'sales_executive'">
                            <v-select
                                :items="groups"
                                item-text="name"
                                item-value="id"                                
                                :color="themeOption.inputColor"
                                :label="trans.group"
                                v-model="user.group_id"
                                box solo flat
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2
                                v-if="user.level ==='country' ||
                                user.level === 'region' ||
                                user.level ==='dealership' || user.level === 'sales_executive'"
                        >
                            <v-autocomplete
                                :items="countries"
                                item-text="name"
                                item-value="id"
                                :rules="[ v => !!v || `${trans.countryIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.country"
                                v-model="user.country_id"
                                @change="getRegion"
                                box solo flat
                            ></v-autocomplete>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2
                                v-if="user.level === 'brand' || user.level === 'region' || user.level === 'country'">
                            <v-autocomplete
                                :items="brands"
                                item-text="name"
                                item-value="id"
                                :rules="[ v => !!v || `${trans.brandIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.brand"
                                v-model="user.brand_id"
                                @change="getRegion"
                                box solo flat
                            ></v-autocomplete>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2
                                v-if="user.level === 'region' || user.level ==='dealership' || user.level === 'sales_executive'">
                            <v-select :items="regions"
                                      item-text="name"
                                      item-value="id"
                                      :color="themeOption.inputColor"
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
                                :rules="[ v => !!v || `${trans.companyIsRequired}`]"
                                :label="trans.company"
                                v-model="user.company_id"
                                box solo flat
                            ></v-select>
                        </v-flex>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs12 sm8 pa-2>
                            <v-textarea
                                :label="`${trans.notes}`"
                                :color="themeOption.inputColor"
                                v-model="user.notes"
                                box solo flat
                            ></v-textarea>
                        </v-flex>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex xs12 sm3 pa-2>
                            <v-btn
                                color="primary"
                                dark
                                small
                                @click.stop="dialog = true"
                            >
                                Change Password
                            </v-btn>
                        </v-flex>
                    </v-layout>
                    <v-layout row wrap>
                        <v-flex xs12 pa-2>
                            <v-tabs
                                v-model="active"
                                :color="themeOption.tabColor"
                                :slider-color="themeOption.tabSliderColor"
                            >
                                <v-tab
                                    key="specialized"
                                    ripple
                                >
                                    {{ trans.specialized }}
                                </v-tab>

                                <v-tab
                                    key="profileImage"
                                    ripple
                                >
                                    {{ `${trans.profileImage}`}}
                                </v-tab>

                                <v-tab-item
                                    key="specialized"
                                >
                                    <SpecializeBrand></SpecializeBrand>
                                </v-tab-item>

                                <v-tab-item
                                    key="profileImage">
                                    <v-layout row wrap mt-3>
                                        <v-card class="pa-3">
                                            <input type="file"
                                                   class="mb-3"
                                                   accept="image/*"
                                                   ref="profileImage"
                                                   @change="onProfileImageUpload"/>

                                            <v-img
                                                :src="profileImage"
                                                aspect-ratio="2"
                                            ></v-img>
                                        </v-card>
                                    </v-layout>
                                </v-tab-item>
                            </v-tabs>

                        </v-flex>
                    </v-layout>

                    <v-layout row wrap>
                        <v-flex class="justify-center pa-3">
                            <v-btn
                                dark
                                :color="themeOption.buttonSecondaryColor"
                                class="rounded-btn"
                                small
                                @click="onGoBack()"
                            >
                                {{ `${trans.back}`}}
                            </v-btn>

                            <v-btn
                                dark
                                :loading="processing"
                                :disabled="buttonDisabled"
                                :color="themeOption.buttonDangerColor"
                                class="rounded-btn"
                                small
                                @click="onCreateUser()"
                            >
                                {{ `${trans.updateUser}` }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-form>

        <v-dialog
            v-model="dialog"
            width="500"
        >
            <v-card p2>
                <v-card-title class="headline">{{ trans.changeYouPassword }}</v-card-title>
                <v-spacer></v-spacer>
                <v-card-text>
                    <v-text-field
                        :append-icon="password ? 'visibility' : 'visibility_off'"
                        :rules="passwordRule"
                        required
                        :color="themeOption.inputColor"
                        :label="trans.password"
                        :type="password ? `text` : `password`"
                        @click:append="password = !password"
                        :hint="`${trans.passwordMinimum8Character}`"
                        v-model="newPassword"
                        counter
                    ></v-text-field>

                    <v-text-field
                        :append-icon="confirmPassword ? 'visibility' : 'visibility_off'"
                        :rules="[v => !!v || `${trans.confirmPasswordIsRequired}`, confirmRule]"
                        required
                        :color="themeOption.inputColor"
                        :label="`${trans.confirmPassword}`"
                        :type="confirmPassword ? `text` : `password`"
                        @click:append="confirmPassword = !confirmPassword"
                        v-model="password_confirmation"
                        counter
                    ></v-text-field>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        :class="themeOption.buttonSuccess"
                        small
                        @click="dialog = false; updatePassword()"
                    >
                        Update
                    </v-btn>

                    <v-btn
                        :color="themeOption.buttonSecondaryColor"
                        small
                        @click="dialog = false"
                    >
                        Cancel
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'

    import SpecializeBrand from '@/components/User/Specialize'

    export default {

        components: {
            SpecializeBrand
        },

        data() {
            return {
                valid: true,
                password: false,
                confirmPassword: false,
                accessLevels: [],
                profileImage: '',
                processing: false,
                buttonDisabled: false,
                dialog: false,
                newPassword: '',
                password_confirmation: '',
                active: ''
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
                companies: 'getCompanies',
                user: 'getSelectedUser',
                authUser: 'getAuthUser'
            }),

            passwordRule() {
                return [
                    v => !!v || `${this.trans.passwordIsRequired}`,
                    v => v && v.length >= 8 || `${this.trans.passwordMinimum8Character}`
                ]
            },

            confirmRule() {
                return () => (this.user.password === this.user.password_confirmation) || `${this.trans.passwordNotMatch}`
            }
        }),

        watch: {
            user() {
                if (this.user.profile_image && this.user.profile_image.length > 0) {
                    this.profileImage = this.user.profile_image
                }
                this.onFetchData()
            }
        },

        created() {
            this.initialize()
            this.$store.commit('setHeaderTitle', `${this.trans.editUser}`)
            this.$store.commit('setNavTitle', `${this.trans.editUser}`)
        },

        methods: {
            initialize() {
                this.$store.commit('setLevel', this.trans)
                // Fetch user info
                this.$store.dispatch('fetchUser', {id: this.$route.params.id})
            },

            onFetchData() {
                const level = this.user.level
                switch (level) {
                    case 'dealership':
                    case 'sales_executive':
                        this.$store.dispatch('fetchCountriesForDropdown')
                        this.$store.dispatch('fetchGroupsForDropdown')
                        this.$store.dispatch('fetchDealershipsForDropdown')
                        break

                    case 'group':
                        this.$store.dispatch('fetchGroupsForDropdown')
                        break

                    case 'region':
                        this.$store.dispatch('fetchBrandForDropDown')
                        this.$store.dispatch('fetchCountriesForDropdown')
                        break

                    case 'country':
                        this.$store.dispatch('fetchBrandForDropDown')
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
                    this.buttonDisabled = true
                    this.processing = this.themeOption.buttonLoadingStyle

                    // Set form object for dealership
                    let userForm = new FormData()
                    userForm.append('_method', 'put')
                    _.forOwn(this.user, (value, key) => {

                        if (key === 'dealership_id') {
                            userForm.append('dealershipId', value)
                            return
                        }
                        userForm.append(key, value)
                    })

                    // add user profile image
                    userForm.append('profile_image', this.profileImage)
                    const URL = `/api/users/${this.user.id}`
                    axios.post(URL, userForm).then((response) => {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.user.firstname}  ${this.trans.successfullyUpdated}`
                        })

                        this.processing = false
                        this.buttonDisabled = false
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
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
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            updatePassword() {
                let data = new FormData()
                data.append('password', this.newPassword)
                data.append('confirm_password', this.newPassword)
                data.append('email', this.user.email)

                axios.post(`/api/users/${this.user.id}/updatepassword`, data).then((response) => {
                    this.$store.commit('setSnackbarMessage', {
                        openMessage: true,
                        timeOut: this.themeOption.snackBarTimeout,
                        message: `${this.trans.passwordSuccessfullyUpdated}`
                    })
                }).catch(error => {
                    this.$store.dispatch('initializeError', error)
                })
            },

            onGoBack() {
                if (this.authUser.level === 'dealership') {
                    this.$router.push({name: 'editDealerships', params: {id: this.authUser.dealership_id}})
                    return
                }

                console.log('back history!');
                
                window.history.back();
                
            }
        }
    }
</script>
