<template>
    <v-container pa-0>
        <v-layout row warp pb-4>
            <v-flex xs12>
                <v-toolbar flat>
                    <v-toolbar-title>
                        <span :class="themeOption.textHeadingColor+'--text'">{{ `${trans.create} ${trans.user}` }}</span>
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
                                        v-model="user.group_id"
                                    >
                                    </v-select>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap>
                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        type="number"
                                        :color="themeOption.inputColor"
                                        :label="trans.latitude"
                                        v-model="user.latitude">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-text-field
                                        type="number"
                                        :color="themeOption.inputColor"
                                        v-model="user.longitude"
                                        :label="trans.longitude">
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12 sm6 pa-2>
                                    <v-switch
                                        :label="trans.status"
                                        :color="themeOption.inputColor"
                                        v-model="user.status">
                                    </v-switch>
                                </v-flex>
                            </v-layout>

                            <v-divider class="mt-2 mb-2"></v-divider>

                            <v-layout column wrap>
<!--                                <v-tabs-->
<!--                                    v-model="active"-->
<!--                                    :color="themeOption.tabColor"-->
<!--                                    :slider-color="themeOption.tabSliderColor"-->
<!--                                >-->
<!--                                    <v-tab-->
<!--                                        key="address"-->
<!--                                        ripple-->
<!--                                    >-->
<!--                                        {{ trans.address}}-->

<!--                                    </v-tab>-->

<!--                                    <v-tab-->
<!--                                        key="dealershipImage"-->
<!--                                        ripple-->
<!--                                    >-->
<!--                                        {{ trans.dealership_banner}}-->

<!--                                    </v-tab>-->

<!--                                    <v-tab-->
<!--                                        key="times"-->
<!--                                        ripple-->
<!--                                    >-->
<!--                                        {{ trans.opening_times}}-->

<!--                                    </v-tab>-->

<!--                                    <v-tab-item-->
<!--                                        key="address"-->
<!--                                    >-->
<!--                                        <v-layout row wrap pt-3>-->
<!--                                            <v-flex xs12 sm6 pa-2>-->
<!--                                                <v-text-field-->
<!--                                                    :color="themeOption.inputColor"-->
<!--                                                    :rules="[v => !!v || trans.address_is_required]"-->
<!--                                                    :label="trans.address_line_1"-->
<!--                                                    v-model="dealership.address_line_1">-->
<!--                                                </v-text-field>-->
<!--                                            </v-flex>-->

<!--                                            <v-flex xs12 sm6 pa-2>-->
<!--                                                <v-text-field-->
<!--                                                    :color="themeOption.inputColor"-->
<!--                                                    :label="trans.address_line_2"-->
<!--                                                    v-model="dealership.address_line_2"-->
<!--                                                >-->
<!--                                                </v-text-field>-->
<!--                                            </v-flex>-->
<!--                                        </v-layout>-->

<!--                                        <v-layout row wrap pt-3>-->
<!--                                            <v-flex xs12 sm6 pa-2>-->
<!--                                                <v-text-field-->
<!--                                                    :color="themeOption.inputColor"-->
<!--                                                    :label="trans.address_line_3"-->
<!--                                                    v-model="dealership.address_line_3"-->
<!--                                                >-->
<!--                                                </v-text-field>-->
<!--                                            </v-flex>-->

<!--                                            <v-flex xs12 sm6 pa-2>-->
<!--                                                <v-text-field-->
<!--                                                    :color="themeOption.inputColor"-->
<!--                                                    :label="trans.address_line_4"-->
<!--                                                    v-model="dealership.address_line_4"-->
<!--                                                >-->
<!--                                                </v-text-field>-->
<!--                                            </v-flex>-->
<!--                                        </v-layout>-->

<!--                                        <v-layout row wrap>-->
<!--                                            <v-flex xs12 sm6 pa-2>-->
<!--                                                <v-text-field-->
<!--                                                    :color="themeOption.inputColor"-->
<!--                                                    :label="trans.address_line_5"-->
<!--                                                    v-model="dealership.address_line_5"-->
<!--                                                >-->
<!--                                                </v-text-field>-->
<!--                                            </v-flex>-->

<!--                                            <v-flex xs12 sm6 pa-2>-->
<!--                                                <v-text-field-->
<!--                                                    :color="themeOption.inputColor"-->
<!--                                                    :label="trans.address_line_6"-->
<!--                                                    v-model="dealership.address_line_6"-->
<!--                                                >-->
<!--                                                </v-text-field>-->
<!--                                            </v-flex>-->
<!--                                        </v-layout>-->
<!--                                    </v-tab-item>-->

<!--                                    <v-tab-item-->
<!--                                        key="dealershipImage"-->
<!--                                    >-->
<!--                                        <v-layout row wrap pt-3>-->
<!--                                            <ImageUpload :preview="true"-->
<!--                                                         model="dealership"-->
<!--                                            ></ImageUpload>-->
<!--                                        </v-layout>-->
<!--                                    </v-tab-item>-->

<!--                                    <v-tab-item-->
<!--                                        key="times">-->
<!--                                        <TimePicker :dealership="times"-->
<!--                                                    v-on:sendTimes="updateTimes">-->
<!--                                        </TimePicker>-->
<!--                                    </v-tab-item>-->
<!--                                </v-tabs>-->
                            </v-layout>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-3">
                            <v-spacer></v-spacer>
                            <v-btn
                                :class="themeOption.buttonSuccess"
                                small
                                @click="onCreateDealership()"
                            >
                                {{ trans.create_dealerships }}
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
    export default{
        data(){
            return{
                valid: true,
                user:{},
                password: false,
                confirmPassword: false,
                accessLevels:[]
            }
        },

        computed:({
           ...mapGetters({
               trans: 'getFields',
               themeOption: 'getThemeOption',
               levels: 'getUserLevels',
               dealerships: 'getDealerships'
           }),

            passwordRule(){
                return [
                    v => !!v || `${this.trans.password} ${this.trans.is_required}`,
                    v => v && v.length <= 8 || `${this.trans.password} ${this.trans.minimum8Character}`
                ]
            },

            confirmRule(){
                return () => (this.user.password === this.user.confirmPassword) || `${this.trans.password} ${this.trans.notMatch}`
            }
        }),

        watch: {
        },

        created() {
            this.initialize()
        },

        methods:{
            initialize(){
                this.$store.commit('setLevel', this.trans)
            },

            fetchData(){
                const level = this.user.level

                switch(level){
                    case 'dealership':
                        this.$store.dispatch('fetchDealershipsForDropdown')
                        break;
                }
            }
        }
    }
</script>
