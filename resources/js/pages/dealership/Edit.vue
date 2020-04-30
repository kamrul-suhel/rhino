<template>
    <v-container pa-0>
        <v-layout row wrap justify-end>
            <v-flex xs12 sm3>
                <language-picker
                    :languageId="dealership.language_id"
                    :solo="false"
                    :chip="false"
                    :flat="false"
                >
                </language-picker>
            </v-flex>
        </v-layout>
        <v-form
            row wrap
            ref="dealershipForm"
            v-model="valid"
            lazy-validation>
            <v-layout>
                <v-flex xs12>
                    <v-layout row wrap>
                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :rules=" [v => !!v || `${trans.nameIsRequired}`]"
                                :color="themeOption.inputColor"
                                :label="`${trans.name}`"
                                v-model="dealership.name"
                                box solo flat
                            ></v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                type="number"
                                :color="themeOption.inputColor"
                                :label="trans.latitude"
                                v-model="dealership.latitude"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                type="number"
                                :color="themeOption.inputColor"
                                v-model="dealership.longitude"
                                :label="trans.longitude"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :rules="[v => !!v || `${trans.addressIsRequired}`]"
                                :label="`${trans.addressLine} 1`"
                                v-model="dealership.address_line_1"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.addressLine} 2`"
                                v-model="dealership.address_line_2"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.addressLine} 3`"
                                v-model="dealership.address_line_3"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.addressLine} 4`"
                                v-model="dealership.address_line_4"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.addressLine} 5`"
                                v-model="dealership.address_line_5"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.addressLine} 6`"
                                v-model="dealership.address_line_6"
                                box solo flat>
                            </v-text-field>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-select
                                :items="countries"
                                item-text="name"
                                item-value="id"
                                :rules="[v => !!v || `${trans.selectACountry}`]"
                                :color="themeOption.inputColor"
                                :label="trans.selectCountry"
                                v-model="dealership.country_id"
                                box solo flat>
                            </v-select>
                        </v-flex>

                        <v-flex xs12 sm3 pa-2>
                            <v-text-field
                                :color="themeOption.inputColor"
                                :label="`${trans.dealershipCode}`"
                                v-model="dealership.suffix"
                                box solo flat>
                            </v-text-field>
                        </v-flex>
                    </v-layout>


                    <v-layout row wrap>
                        <v-flex xs12>
                            <v-tabs
                                v-model="active"
                                dark
                                :slider-color="themeOption.tabSliderColor">

                                <v-tab
                                    key="staff"
                                    ripple
                                >
                                    {{ trans.staff }}
                                </v-tab>

                                <v-tab
                                    key="brands"
                                    v-if="authUser.level === 'admin'"
                                    ripple
                                >
                                    {{ trans.brands }}
                                </v-tab>

                                <v-tab
                                    key="times"
                                    ripple
                                >
                                    {{ trans.openingTimes}}
                                </v-tab>

                                <v-tab
                                    key="settings"
                                    ripple
                                >
                                    {{ trans.settings}}
                                </v-tab>

                                <v-tabs-items touchless>
                                    <v-tab-item
                                        key="staff">

                                        <v-layout row wrap pt-3>
                                            <dealership-users></dealership-users>

                                            <v-flex xs12 sm6 pa-2>
                                                <v-btn
                                                    :color="themeOption.buttonSuccess"
                                                    small
                                                    @click="$router.push({name: 'createDealershipUser', params: {dealershipId: dealership.id}})"
                                                >

                                                    {{ trans.addUser }}
                                                </v-btn>

                                                <v-btn
                                                    :color="themeOption.buttonSuccess"
                                                    small
                                                    @click="onUploadUsers()"
                                                >

                                                    {{ trans.uploadUsers }}
                                                </v-btn>
                                            </v-flex>
                                        </v-layout>
                                    </v-tab-item>

                                    <v-tab-item
                                        key="brands"
                                        v-if="authUser.level === 'admin'"
                                    >
                                        <Brands v-if="dealership.id"
                                                :dealershipId="dealership.id">
                                        </Brands>
                                    </v-tab-item>


                                    <v-tab-item
                                        key="times">
                                        <v-container grid-list-lg v-if="dealership.id">
                                            <v-layout row wrap>
                                                <TimePicker :value="dealership.monday_start"
                                                            name="monday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.monday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.monday_end"
                                                            name="monday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.monday} ${trans.end}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.tuesday_start"
                                                            name="tuesday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.tuesday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.tuesday_end"
                                                            name="tuesday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.tuesday} ${trans.end}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.wednesday_start"
                                                            name="wednesday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.wednesday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.wednesday_end"
                                                            name="wednesday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.wednesday} ${trans.end}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.thursday_start"
                                                            name="thursday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.thursday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.thursday_end"
                                                            name="thursday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.thursday} ${trans.end}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.friday_start"
                                                            name="friday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.friday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.friday_end"
                                                            name="friday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.friday} ${trans.end}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.saturday_start"
                                                            name="saturday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.saturday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.saturday_end"
                                                            name="saturday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.saturday} ${trans.end}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.sunday_start"
                                                            name="sunday_start"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.sunday} ${trans.start}`">
                                                </TimePicker>

                                                <TimePicker :value="dealership.sunday_end"
                                                            name="sunday_end"
                                                            @updateTime="onUpdateTime"
                                                            :field="`${trans.sunday} ${trans.end}`">
                                                </TimePicker>
                                            </v-layout>
                                        </v-container>
                                    </v-tab-item>

                                    <v-tab-item
                                        key="settings">

                                        <v-checkbox :color="themeOption.primaryColor"
                                                    v-model="dealership.calendar_access"
                                                    :label="`Allow Calendar Access`"
                                        >
                                        </v-checkbox>

                                        <v-checkbox :color="themeOption.primaryColor"
                                                    v-model="dealership.enable_emails"
                                                    :label="`Send System Emails`"
                                        >
                                        </v-checkbox>
                                    </v-tab-item>
                                </v-tabs-items>
                            </v-tabs>
                        </v-flex>
                    </v-layout>
                    <v-divider class="py-3"></v-divider>
                    <v-layout>
                        <v-flex>
                            <v-btn
                                dark
                                :loading="themeOption.buttonLoading"
                                :disabled="themeOption.buttonLoading"
                                :color="themeOption.buttonDangerColor"
                                class="rounded-btn"
                                small
                                @click="onUpdateDealership()"
                            >
                                {{ `${trans.updateDealership}` }}
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-flex>
            </v-layout>
        </v-form>

        <UploadUsers></UploadUsers>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import TimePicker from "@/components/TimePicker"
    import ImageUpload from "@/components/ImageUpload"
    import Brands from '@/components/Dealership/Brands'
    import LanguagePicker from '@/components/Language'
    import DealershipUsers from '@/components/Dealership/Users'
    import EventList from '../event/List'
    import UploadUsers from "@/components/User/UploadUsers"

    export default {
        components: {
            TimePicker,
            ImageUpload,
            Brands,
            LanguagePicker,
            DealershipUsers,
            EventList,
            UploadUsers,
        },

        data() {
            return {
                valid: true,
                active: null,
                model: null,
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                countries: 'getCountries',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                regions: 'getRegions',
                dealership: 'getSelectedDealership',
                selectedLanguage: 'getSubSelectedLanguage',
                authUser: 'getAuthUser',
            })
        }),

        watch: {
            dealership(value) {
                this.$refs.dealershipForm.resetValidation();
            },

            selectedLanguage() {
                this.$store.dispatch('fetchDealership', {
                    id: this.$route.params.id,
                    edit: true,
                    languageId: this.selectedLanguage.id
                })
            }
        },

        created() {
            this.initialize()
            this.$store.commit('setHeaderTitle', `${this.trans.editDealership}`)
            this.$store.commit('setNavTitle', `${this.trans.editDealership}`)
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchBrandForDropDown')
                this.$store.dispatch('fetchDealership', {id: this.$route.params.id})
            },

            updateTimes(times) {
            },

            onUpdateDealership() {
                if (this.$refs.dealershipForm.validate()) {
                    let dealershipForm = new FormData()

                    // Set form object for dealership
                    _.forOwn(this.dealership, (value, key) => {
                        if (key === 'group_id') {
                            if (value == 'null') {

                            } else {
                                dealershipForm.append(key, value)
                            }
                        } else {
                            dealershipForm.append(key, value)
                        }
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key) => {
                        dealershipForm.append(key, value)
                    })

                    // Set language id
                    dealershipForm.append('languageId', this.selectedLanguage.id)

                    dealershipForm.append('_method', 'put')

                    // send form data to save
                    const URL = `/api/dealerships/${this.dealership.id}/update`
                    axios.post(URL, dealershipForm).then((response) => {
                        if (response.data.success) {
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.dealership.name}  ${this.trans.successfullyUpdated}`
                            })
                        }
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
                    })
                }
            },

            onUploadUsers() {
                this.$store.commit('setUploadUserDialog', true)
            },

            onUpdateTime(item) {
                const newDealership = {
                    ...this.dealership,
                    [item.name]: item.value
                }

                this.$store.commit('setSelectedDealership', newDealership)
            }
        }
    }
</script>
