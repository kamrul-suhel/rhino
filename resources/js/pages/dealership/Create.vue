<template>
    <v-container pa-0>
        <div class="r-tab" :class="[showForm ? 'open' : '']">
            <v-btn outline round
                    @click="onGoBack()"
                    :color="themeOption.adminNavIconColor"
                    class="ma-0 ml-4 btn-absolute"  style="position: absolute; right: 0;" >
                <v-icon left dark>reply</v-icon>
                {{ `${trans.back}` }}
            </v-btn>
            <div class="r-tab-title r-border-round" @click="toggleForm">
                <div>
                    <v-icon
                        :color="themeOption.adminNavIconColor">tag_faces
                    </v-icon>
                </div>

                <div>
                    {{ `${trans.createDealership}` }}
                </div>
            </div>
            <div class="r-tab-content" :class="[showForm ? 'open' : '']">
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
                                            :rules="[v => !!v || `${trans.nameIsRequired}`]"
                                            required
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
                                </v-layout>

                                <v-layout row wrap>
                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.addressLine} 2`"
                                            v-model="dealership.address_line_2"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.addressLine} 3`"
                                            v-model="dealership.address_line_3"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.addressLine} 4`"
                                            v-model="dealership.address_line_4"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.addressLine} 5`"
                                            v-model="dealership.address_line_5"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>
                                </v-layout>


                                <v-layout row wrap>
                                    <v-flex xs12 sm3 pa-2>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            :label="`${trans.addressLine} 6`"
                                            v-model="dealership.address_line_6"
                                            box solo flat
                                        >
                                        </v-text-field>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-select
                                            :items="countries"
                                            item-text="name"
                                            item-value="id"
                                            :rules="[v => !!v || `${trans.selectACountry}`]"
                                            required
                                            :color="themeOption.inputColor"
                                            :label="trans.selectCountry"
                                            v-model="dealership.country_id"
                                            box solo flat
                                        >
                                        </v-select>
                                    </v-flex>

                                    <v-flex xs12 sm3 pa-2>
                                        <v-select
                                            :items="groups"
                                            item-text="name"
                                            item-value="id"
                                            :color="themeOption.inputColor"
                                            :label="`${trans.selectAGroup}`"
                                            v-model="dealership.group_id"
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
                                    <v-flex xs12 sm6 pa-2>
                                        <v-switch
                                            :label="trans.status"
                                            :color="themeOption.switchOnColor"
                                            v-model="dealership.status"
                                            :true-value="1"
                                            :false-value="0"
                                            >
                                        </v-switch>
                                    </v-flex>
                                </v-layout>

                                <v-divider class="mt-2 mb-2"></v-divider>

                                <v-layout column wrap>
                                    <v-tabs
                                        v-model="active"
                                        dark
                                        :slider-color="themeOption.tabSliderColor"
                                    >
                                        <v-tab
                                            key="times"
                                            ripple
                                        >
                                            {{ trans.openingTimes}}

                                        </v-tab>

                                        <v-tab
                                            key="dealershipImage"
                                            ripple
                                        >
                                            {{ `${trans.dealershipBanner}`}}

                                        </v-tab>

                                        <v-tab-item
                                            key="times">
                                            <v-container grid-list-lg>
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
                                            key="dealershipImage"
                                        >
                                            <v-layout row wrap pt-3>
                                                <ImageUpload :preview="true"
                                                            model="dealership"
                                                ></ImageUpload>
                                            </v-layout>
                                        </v-tab-item>
                                    </v-tabs>
                                </v-layout>
                                <v-layout class="pa-3">
                                    <v-btn
                                        :color="themeOption.buttonDangerColor"
                                        class="rounded-btn"
                                        dark
                                        small
                                        @click="onCreateDealership()"
                                        :disabled="submitDisabled"
                                    >
                                        {{ `${trans.submit}` }}
                                    </v-btn>
                                        <v-progress-circular
                                            v-if="submitDisabled"
                                            indeterminate
                                            color="red"
                                            ></v-progress-circular>
                                </v-layout>
                        </v-flex>
                    </v-layout>
                </v-form>
            </div>
        </div>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    import TimePicker from "@/components/TimePicker";
    import ImageUpload from "@/components/ImageUpload";

    export default {
        components: {
            TimePicker,
            ImageUpload
        },

        data() {
            return {
                valid: true,
                dealership: {
                    status: 1
                },
                times: {},
                active: null,
                model: null,
                showForm: false,
                submitDisabled: false
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                countries: 'getCountries',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption',
                regions: 'getRegions',
                groups: 'getGroups'
            })
        }),

        watch: {
        },

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchCountriesForDropdown')
                this.$store.dispatch('fetchGroups', {dropDown: true})
            },

            updateTimes(times) {
            },

            onCreateDealership(){
                if(this.$refs.dealershipForm.validate()){
                    let dealershipForm = new FormData()

                    // Set form object for dealership
                    _.forOwn(this.dealership, (value, key)=>{
                        dealershipForm.append(key, value)
                    })

                    // Set form object for times
                    _.forOwn(this.times, (value, key)=>{
                        dealershipForm.append(key, value)
                    })

                    // send form data to save
                    axios.post('/api/dealerships', dealershipForm).then((response)=>{
                        if(response.data.success){
                            this.$store.commit('setSnackbarMessage', {
                                openMessage: true,
                                timeOut: this.themeOption.snackBarTimeout,
                                message: `${this.dealership.name}  ${this.trans.successfullyCreated}`
                            })
                        }


                        this.dealership = {}
                        this.times = {}
                        this.showForm = false

                        this.$store.commit('setUpdateComponent')
                    }).catch(error => {
                        this.$store.dispatch('initializeError', error)
                    })
                }
            },

            toggleForm() {
                this.showForm = !this.showForm
            },

            onGoBack(){
                this.$router.push({name: 'dashboard'})
            },

            onUpdateTime(item) {
                this.dealership = {
                    ...this.dealership,
                    [item.name]: item.value
                }
            }
        }
    }
</script>
