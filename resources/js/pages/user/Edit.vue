<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span
                            :class="themeOption.textHeadingColor+'--text'">{{ `${trans.edit} ${trans.user}` }}</span>
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
            ref="userForm"
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
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-select
                                        :items="levels"
                                        :rules="[v => !!v || `${trans.select_a} ${trans.role}`]"
                                        :color="themeOption.inputColor"
                                        :label="trans.access_level"
                                        item-text="text"
                                        item-value="value"
                                        v-model="user.level"
                                        @change="onFetchData"
                                    >
                                    </v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2
                                        v-if="user.level==='dealership' || user.level === 'sales_executive'">
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

                                <v-flex xs12 sm6 pa-2
                                        v-if="user.level === 'group'">
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

                                <v-flex xs12 sm6 pa-2
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
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2
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
                                    ></v-autocomplete>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-btn
                                        color="primary"
                                        dark
                                        small
                                        @click.stop="dialog = true"
                                    >
                                        Change Password
                                    </v-btn>
                                </v-flex>


                                <v-flex xs12 sm6 pa-2
                                        v-if="user.level === 'region'">
                                    <v-select :items="regions"
                                              item-text="name"
                                              item-value="id"
                                              :color="themeOption.inputColor"
                                              :rules="[v => !!v || `${trans.region} ${trans.is_required}`]"
                                              :label="trans.region"
                                              v-model="user.region_id"
                                    ></v-select>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2
                                        v-if="user.level === 'company'">
                                    <v-select
                                        :items="companies"
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
                                <v-flex xs12>
                                    <v-textarea
                                        :label="`${trans.notes}`"
                                        :color="themeOption.inputColor"
                                        v-model="user.notes"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-switch
                                        :false-value="0"
                                        :true-value="1"
                                        :label="trans.status"
                                        :color="themeOption.inputColor"
                                        v-model="user.status">
                                    </v-switch>
                                </v-flex>
                            </v-layout>

                            <v-divider class="my-3"></v-divider>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>



                                    <v-tabs
                                        v-model="active"
                                        :color="themeOption.tabColor"
                                        :slider-color="themeOption.tabSliderColor"
                                    >
                                        <v-tab
                                            key="profileImage"
                                            ripple
                                        >
                                            {{ `${trans.profile} ${trans.image}`}}
                                        </v-tab>

                                        <v-tab
                                            key="specialized"
                                            ripple
                                        >
                                            {{ trans.specialized }}
                                        </v-tab>

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

                                        <v-tab-item
                                            key="specialized"
                                        >
                                            <v-layout row wrap>
                                                Specialize section
                                            </v-layout>
                                        </v-tab-item>
                                    </v-tabs>

                                </v-flex>
                            </v-layout>
                            <v-divider class="mt-2 mb-2"></v-divider>
                        </v-card-text>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                :color="themeOption.buttonSecondaryColor"
                                small
                                @click="$router.push({name: 'listUsers'})"
                            >
                                {{ `${trans.back}`}}
                            </v-btn>

                            <v-btn
                                :loading="processing"
                                :disabled="buttonDisabled"
                                :color="themeOption.buttonSuccess"
                                small
                                @click="onCreateUser()"
                            >
                                {{ `${trans.update} ${trans.user}` }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-form>

        <v-dialog
            v-model="dialog"
            width="500"
        >
            <v-card p2>
                <v-card-title class="headline">Change your password</v-card-title>
                <v-spacer></v-spacer>
                <v-card-text>
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
                        counter
                    ></v-text-field>

                    <v-text-field
                        :append-icon="confirmPassword ? 'visibility' : 'visibility_off'"
                        :rules="[v => !!v || `${trans.confirm} ${trans.is_required}`, confirmRule]"
                        required
                        :color="themeOption.inputColor"
                        :label="`${trans.confirm} ${trans.password}`"
                        :type="confirmPassword ? `text` : `password`"
                        @click:append="confirmPassword = !confirmPassword"
                        v-model="user.password_confirmation"
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

    export default {
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
                active: null
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
                user: 'getSelectedUser'
            }),

            passwordRule() {
                return [
                    v => !!v || `${this.trans.password} ${this.trans.is_required}`,
                    v => v && v.length >= 8 || `${this.trans.password} ${this.trans.minimum8Character}`
                ]
            },

            confirmRule() {
                return () => (this.user.password === this.user.password_confirmation) || `${this.trans.password} ${this.trans.notMatching}`
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
        },

        methods: {
            initialize() {
                this.$store.commit('setLevel', this.trans)
                // Fetch user info
                this.$store.dispatch('fetchUser', {id: this.$route.params.id})
            },

            onFetchData() {
                console.log(this.user.level)
                const level = this.user.level
                switch (level) {
                    case 'dealership':
                    case 'sales_executive':
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
                    this.buttonDisabled = true
                    this.processing = this.themeOption.buttonLoadingStyle

                    // Set form object for dealership
                    let userForm = new FormData()
                    userForm.append('_method', 'put')
                    _.forOwn(this.user, (value, key) => {
                        if (key === 'firstname') {
                            userForm.append('name', this.user.firstname)
                            return
                        }
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
                            message: `${this.user.firstname}  ${this.trans.successfully_updated}`
                        })

                        this.processing = false
                        this.buttonDisabled = false
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

            updatePassword() {
                if (passwordRule) {
                    console.log('update password');
                }
            }
        }
    }
</script>
