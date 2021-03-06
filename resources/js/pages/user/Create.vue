<template>
    <v-container pa-0>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <div class="r-tab-header">
                <div class="r-tab-title r-border-round" @click="toggleForm">
                    <div>
                        <v-icon
                            :color="themeOption.adminNavIconColor">person
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.createUser}` }}
                    </div>
                </div>

                <div class="r-tab-actions">
                    <div class="user-download">
                        <div>
                            <v-btn  flat
                                    @click="onDownloadUser()">
                                <v-icon left dark>cloud_download</v-icon>
                                {{ trans.downloadUserCSV }}
                            </v-btn>

                            <v-btn  flat
                                    @click="onUploadUsers()">
                                <v-icon left dark>cloud_upload</v-icon>
                                {{ trans.uploadUsers }}
                            </v-btn>
                        </div>

                        <v-btn outline round
                               @click="onGoBack()"
                               :color="themeOption.adminNavIconColor"
                               class="ma-0 ml-4">
                            <v-icon left dark>reply</v-icon>
                            {{ `${trans.back}` }}
                        </v-btn>
                    </div>
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
                                :rules="[v => !!v || `${trans.firstNameIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.firstName"
                                v-model="user.firstname"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :rules="[v => !!v || `${trans.surnameIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.surName"
                                v-model="user.surname"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :rules="[v => !!v || `${trans.emailIsRequired}`]"
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
                                :hint="`${trans.passwordMinimum8Character}`"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :append-icon="confirmPassword ? 'visibility' : 'visibility_off'"
                                :rules="[v => !!v || `${trans.confirmPasswordIsRequired}`, confirmRule]"
                                required
                                :color="themeOption.inputColor"
                                :label="`${trans.confirmPassword}`"
                                :type="confirmPassword ? `text` : `password`"
                                @click:append="confirmPassword = !confirmPassword"
                                v-model="user.password_confirmation"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2 v-if="authUser.level !== 'dealership'">
                            <v-select
                                :items="levels"
                                :rules="[v => !!v || `${trans.selectALevel}`]"
                                :color="themeOption.inputColor"
                                :label="trans.level"
                                v-model="user.level"
                                @change="onFetchData"
                                box solo flat
                            >
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2
                                v-if="user.level ==='dealership' ||
                                user.level === 'sales_executive' ||
                                user.level === 'call_handler' ||
                                user.level === 'receptionist'">
                            <v-select
                                :items="dealerships"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || `${trans.dealershipIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="trans.dealership"
                                v-model="user.dealershipId"
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
                                :rules="[ v => !!v || `${trans.groupIsRequired}`]"
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
                                      :rules="[v => !!v || `${trans.regionIsRequired}`]"
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

                        <v-flex xs12 sm3 pa-2 v-if="duplicateEmailError">
                            <span class="error--text">{{trans.emailDuplicate}}</span>
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
    import fn from '@/utils/function'

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
                showForm: false,
                duplicateEmailError: false
            }
        },


        props: {
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
                    v => !!v || `${this.trans.passwordIsRequired}`,
                    v => v && v.length >= 8 || `${this.trans.passwordMinimum8Character}`
                ]
            },

            confirmRule() {
                return () => (this.user.password === this.user.password_confirmation) || `${this.trans.passwordNotMatch}`
            }
        }),

        watch: {
            updateComponent() {
                this.initialize()
            }
        },

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

                    case 'call_handler':
                    case 'receptionist':
                        this.$store.dispatch('fetchDealershipsForDropdown')

                }
            },

            getRegion() {
                if (this.user.country_id && this.user.brand_id) {
                    this.$store.dispatch('fetchRegionsByBrandIdAndCountryId', {
                        brandId: this.user.brand_id,
                        countryId: this.user.country_id
                    })
                }

                if (
                    this.user.level === 'dealership' ||
                    this.user.level === 'sales_executive'
                ) {
                    this.$store.dispatch('fetchRegionsByCountryId', {
                        countryId: this.user.country_id
                    })
                }

            },

            onCreateUser() {
                if (this.$refs.userForm.validate()) {

                    // Set form object for dealership
                    let userForm = new FormData()

                    if (this.subComponent) {
                        userForm.append('dealershipId', this.$route.params.dealershipId)
                        userForm.append('level', 'sales_executive')
                    }

                    _.forOwn(this.user, (value, key) => {
                        userForm.append(key, value)
                    })

                    // add user profile image
                    userForm.append('profile_image', this.profileImage)
                    const URL = `/api/users`
                    axios.post(URL, userForm).then((response) => {
                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: `${this.trans.user}  ${this.trans.successfullyCreated}`
                        })

                        this.showForm = false
                        this.$refs.userForm.reset()
                        this.$store.commit('setUpdateComponent')

                        setTimeout(() => {
                            this.$router.push({name: 'editUsers', params: {id: response.data.user.id}})
                        }, 1000)

                    }).catch(error => {
                        if(
                            error.response.data &&
                            error.response.data.error === "duplicateEntry"
                        ){
                            this.duplicateEmailError = true
                        }

                        // Set global error
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

            toggleForm() {
                this.showForm = !this.showForm


                if (this.showForm) {
                    this.$store.commit('setHeaderTitle', `${this.trans.createNewUser}`)
                    this.$store.commit('setNavTitle', `${this.trans.createNewUser}`)
                } else {
                    this.$store.commit('setHeaderTitle', `${this.trans.manageUsers}`)
                    this.$store.commit('setNavTitle', `${this.trans.manageUsers}`)
                }
            },

            onDownloadUser(){
                // get all users
                axios.get('/api/users').then((response) => {
                    fn.downloadCSV(response.data.users, 'users')
                }).catch((error) => {
                    this.$store.commit('initializeError', error)
                })
            },

            onUploadUsers(){
                this.$store.commit('setUploadUserDialog', true)
            },

            onGoBack(){
                this.$router.push({name: 'dashboard'})
            }
        }
    }
</script>
