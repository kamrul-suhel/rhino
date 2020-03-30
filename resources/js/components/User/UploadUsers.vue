<template>
    <div class="d-flex">
        <v-dialog
            v-model="dialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            scrollable
        >
            <v-card tile>
                <v-toolbar card dark>
                    <v-btn icon dark @click="dialog = false">
                        <v-icon>close</v-icon>
                    </v-btn>

                    <v-toolbar-title>{{ `${trans.uploadUsers}` }}</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-toolbar-items>
                        <v-btn dark flat
                               v-if="selected.length > 0"
                               @click="onConfirmUpload()">
                            {{ trans.save }}
                        </v-btn>
                    </v-toolbar-items>

                    <v-menu bottom right offset-y>
                        <template v-slot:activator="{ on }">
                            <v-btn dark icon v-on="on">
                                <v-icon>more_vert</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-tile v-for="(item, i) in getNavItem()"
                                         :key="item.type"
                                         @click="onNavItemClick(item)">
                                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                </v-toolbar>

                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12 v-if="type && type === 'admin'">
                            <v-form
                                row wrap
                                ref="userForm"
                                v-model="valid"
                                lazy-validation>
                                <v-layout row wrap>
                                    <v-flex xs12 sm3 pa-2>
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
                                            v-if="user.level ==='dealership' || user.level === 'sales_executive'">
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
                                </v-layout>
                            </v-form>
                        </v-flex>

                        <v-flex xs12>
                            <input
                                ref="salesExecutiveCSV"
                                type="file"
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                class="hidden-screen-only"
                                @change="onUploadCSV"
                            />
                            <v-btn :color="themeOption.buttonPrimaryColor"
                                   dark
                                   small
                                   @click="onClickUploadCSV()">
                                {{ `${trans.uploadCsv}`}}
                            </v-btn>

                            <v-divider class="my-3"></v-divider>

                            <v-data-table
                                v-model="selected"
                                :headers="getHeader()"
                                hide-actions
                                :items="users"
                                select-all
                                item-key="email"
                                class="elevation-1"
                                v-if="users.length > 0"
                            >
                                <template v-slot:headers="props">
                                    <tr>
                                        <th>
                                            <v-checkbox
                                                :color="themeOption.inputColor"
                                                :input-value="props.all"
                                                :indeterminate="props.indeterminate"
                                                primary
                                                hide-details
                                                @click.stop="toggleAll"
                                            ></v-checkbox>
                                        </th>
                                        <th
                                            v-for="header in props.headers"
                                            :key="header.text"
                                            :class="['column sortable text-xs-left', pagination.descending ? 'desc' : 'asc', header.value === pagination.sortBy ? 'active' : '']"
                                            @click="changeSort(header.value)"
                                        >
                                            <v-icon small>arrow_upward</v-icon>
                                            {{ header.text }}
                                        </th>
                                    </tr>
                                </template>

                                <template v-slot:items="props">
                                    <tr :active="props.selected"
                                        @click="props.selected = !props.selected">
                                        <td>
                                            <v-checkbox
                                                :color="themeOption.inputColor"
                                                :input-value="props.selected"
                                                primary
                                                hide-details
                                            ></v-checkbox>
                                        </td>

                                        <td>{{ props.item.firstname }}</td>
                                        <td>{{ props.item.surname }}</td>
                                        <td>{{ props.item.email }}</td>
                                        <td>{{ props.item.password }}</td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-flex>

                        <v-flex xs12>
                            <v-card v-if="existingUsers.length > 0" class="mt-5">
                                <v-card-title>
                                    <h2>Existing users</h2>
                                </v-card-title>

                                <v-card-text>
                                    <v-list two-line>
                                        <template v-for="(user, index) in existingUsers">
                                            <v-list-tile
                                                :key="user.name"
                                                avatar
                                                @click=""
                                            >

                                                <v-list-tile-content>
                                                    <v-list-tile-title>{{ user.name }}</v-list-tile-title>
                                                    <v-list-tile-sub-title>{{ user.email }}</v-list-tile-sub-title>
                                                </v-list-tile-content>
                                            </v-list-tile>
                                        </template>
                                    </v-list>
                                </v-card-text>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-card-text>

                <div style="flex: 1 1 auto;"></div>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import {mapGetters} from "vuex";

    export default {
        data() {
            return {
                valid: true,
                pagination: {
                    sortBy: 'firstName'
                },

                selected: [],
                user: {
                    status: 1
                },
                users: [],
                existingUsers: []
            }
        },

        props:{
          type:{
              type: String,
              required: false
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

            dialog:{
                get(){
                     return this.$store.getters.getUploadUserDialog
                },

                set(value){
                    this.$store.commit('setUploadUserDialog', value)
                }
            }
        }),

        created() {
        },

        methods: {
            onAddGuests() {
                this.dialog = true
            },

            onClickUploadCSV() {
                this.$refs.salesExecutiveCSV.click()
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
                        this.$store.dispatch('fetchCompanyForDropdown',{noCompany: true})

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

            onUploadCSV() {
                const csvFile = this.$refs.salesExecutiveCSV.files[0]
                let guestForm = new FormData()
                guestForm.append('file', csvFile)
                guestForm.append('eventId', this.$route.params.id)

                const URL = `/api/users/upload`

                axios.post(URL, guestForm).then((response) => {
                    if (response.data.success) {
                        let users = [...response.data.users]
                        users = _.uniqBy(users, (user) => {
                            return user.email
                        })

                        this.users = [...users]
                    }
                })
            },

            toggleAll() {
                if (this.selected.length) this.selected = []
                else this.selected = this.users.slice()
            },

            getNavItem() {
                return [
                    {
                        title: this.trans.reset,
                        type: 'clear'
                    },

                    {
                        title: `${this.trans.uploadCsv}`,
                        type: 'upload'
                    }
                ]
            },

            onNavItemClick(nav) {
                switch(nav.type){
                    case 'clear':
                        this.users = []
                        this.existingUsers = []
                        this.$refs.salesExecutiveCSV.value = null
                        return

                    case 'upload':
                        this.onClickUploadCSV()
                        return
                }
            },


            getHeader() {
                const trans = {...this.trans}

                return [
                    {
                        text: `${trans.firstName} `,
                        value: 'firstName',
                        align:'left'
                    },
                    {
                        text: `${trans.surName} `,
                        value: 'surName',
                        align:'left'
                    },
                    {
                        text: `${trans.email} `,
                        value: 'email',
                        align:'left'
                    },

                    {
                        text: `${trans.password}`,
                        value: 'password',
                        align:'left'
                    }
                ]
            },

            changeSort(column) {
                if (this.pagination.sortBy === column) {
                    this.pagination.descending = !this.pagination.descending
                } else {
                    this.pagination.sortBy = column
                    this.pagination.descending = false
                }
            },

            onConfirmUpload() {
                // Check user uploading admin level or dealership level
                if(this.type && this.type === 'admin'){
                    // Check from validation
                    if(!this.$refs.userForm.validate()){
                        return
                    }
                }

                let uploadUserForm = new FormData()
                _.map(this.selected, (user, key) => {
                    _.forOwn(user, (value, field) => {
                        uploadUserForm.append(`users[${key}][${field}]`, value)

                        if(this.type && this.type === 'admin'){
                            _.forOwn(this.user, (additionalValue, additionalKey) => {
                                uploadUserForm.append(`users[${key}][${additionalKey}]`, additionalValue)
                            })
                        }
                    })

                    // If Users uploading admin level, then append user additional info
                    if(this.type && this.type === 'admin'){
                    }else{
                        uploadUserForm.append(`users[${key}][level]`, 'sales_executive') // Default status is active
                    }

                    uploadUserForm.append(`users[${key}][status]`, 1) // Default status is active
                })

                if(this.type && this.type === 'admin'){
                    _.forOwn(this.user, (value, key) => {
                        uploadUserForm.append(key, value)
                        uploadUserForm.append('type', 'admin')
                    })
                }else{
                    uploadUserForm.append('dealershipId', this.$route.params.id)
                }

                // Save into database
                axios.post('/api/users/upload/confirm', uploadUserForm).then((response) => {
                    if (response.data.success) {
                        let message = ''
                        if(this.type && this.type === 'admin'){
                            message = this.trans.usersSuccessFullyUploaded
                        }else{
                            message = this.trans.salesExecutiveSuccessUploaded
                        }

                        this.$store.commit('setSnackbarMessage', {
                            openMessage: true,
                            timeOut: this.themeOption.snackBarTimeout,
                            message: message
                        })
                        this.existingUsers = [...response.data.existingUsers]
                        this.$store.commit('setInitializeUser')

                        // reset upload form
                        this.users = []
                        this.selected = []

                        if(this.type && this.type === 'admin'){
                            this.$refs.userForm.reset()
                        }

                        // this.$store.commit('setUploadUserDialog', false)
                    }
                })
            }
        }
    }
</script>
