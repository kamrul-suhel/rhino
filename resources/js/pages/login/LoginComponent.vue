<template>
    <v-app
        id="inspire"
        class="guest-login"
        style="background-image:url('images/guest-login.png')"
    >
    <v-container>
        <v-layout fill-height
                  justify-center
                  align-center column nowrap>
            <v-flex>
                <v-card width="600" class="login-section">
                    <v-form method="post" v-model="valid" ref="guestLoginGorm">
                        <v-layout column nowrap>
                            <v-flex mt-4 align-self-end xs6 class="language-select stroke-dropdown">
                                <language-picker
                                    :languageId="40"
                                    isFrontend
                                ></language-picker>
                            </v-flex>

                            <v-flex xs12>
                                <h2 class="login-title">{{ trans.welcome + ' ' + trans.back }}!</h2>
                                <h3>{{ trans.EnterYourUniqueCode }}</h3>
                            </v-flex>

                            <v-flex xs12>
                                <v-text-field
                                    color="dark"
                                    :hint="trans.egnchfge23sxs"
                                    v-model="user.unique"
                                    :rules="[v => !!v || `${trans.uniqueId} ${trans.is_required}`]"
                                    required
                                    validate-on-blur
                                    :error="validation.error"
                                >
                                </v-text-field>
                            </v-flex>

                            <v-flex v-if="validation.error">
                                <div class="red--text text-xs-center">{{validation.message}}</div>
                            </v-flex>

                            <v-flex xs12 v-if="errorLogin">
                                <p class="mb-0 red--text">Access denied user email & password is not match.</p>
                            </v-flex>

                            <v-flex xs12>
                                <input type="hidden" name="_token"/>
                                <v-btn
                                    class="ma-0 login-button"
                                    raised
                                    dark
                                    :loading="loading"
                                    :disabled="loading"
                                    @click="onSubmit()">
                                    <v-icon>account_circle</v-icon>
                                    {{ trans.signin }}
                                </v-btn>
                            </v-flex>

                            <v-flex xs12 mb-4 class="multi-container">
                                <input type="hidden" name="_token"/>
                                <v-btn
                                    class="ma-0 multi-button"
                                    raised
                                    dark
                                    :loading="loading"
                                    :disabled="loading"
                                    @click="onSubmit()">
                                    {{ trans.multi }} {{ trans.brand }}
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
    </v-app>
</template>
<script>
    import {mapGetters} from 'vuex'
    import LanguagePicker from '@/components/Language'

    export default {
        components: {
            LanguagePicker
        },

        data() {
            return {
                errorLogin: false,
                valid: false,
                login_progress: false,
                user: {
                    email: '',
                    password: ''
                },

                validation: {
                    error: false,
                    message: ''
                },

                //Loading button
                loading: false,
                loader: null,
            }
        },

        computed:{
          ...mapGetters({
              languages: 'getLanguages',
              trans: 'getFields',
              companies: 'getCompanies',
              themeOption: 'getThemeOption'
          })
        },

        watch: {
        },

        created() {

        },

        methods: {
            async onSubmit() {
                if (this.$refs.guestLoginGorm.validate()) {
                    // make spinner visible
                    this.login_progress = true
                    this.loading = true

                    // prepare submitting data
                    let guestLogin = new FormData()
                    const token = document.head.querySelector('meta[name="csrf-token"]');

                    guestLogin.append('uniqueId', this.user.unique)

                    // submit data with ajax request
                    await axios.post('/guests/login', guestLogin)
                        .then(response => {
                            if(response.data.success){
                                this.$router.push({name: 'booking'});
                            }else{
                                this.errorLogin = true
                                this.login_progress = true
                                this.loading = false
                            }
                        })
                        .catch(error => {
                            this.loading = false
                            this.errorLogin = true
                        });
                }
            }
        }
    }
</script>
