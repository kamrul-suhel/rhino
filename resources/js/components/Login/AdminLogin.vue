<template>
    <v-app
        dark
        id="inspire"
    >
        <v-container fill-height
                     justify-center
                     align-content-center>
            <v-card raised width="450px">
                <v-card-text class="login-section pa-0">
                    <v-form method="post" v-model="valid" ref="login_form">
                        <v-container grid-list-lg>
                            <v-layout row wrap id="login-section">

                                <v-flex xs12>
                                    <h2 class="login-title text-xs-center">{{ trans.login }}</h2>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field
                                        color="dark"
                                        :label="trans.email"
                                        v-model="user.email"
                                        :rules="emailRules"
                                        required
                                        validate-on-blur
                                        :error="validation.error"
                                    >
                                    </v-text-field>
                                </v-flex>

                                <v-flex xs12>
                                    <v-text-field
                                        class="email"
                                        color="dark"
                                        :label="`${trans.enterYourPassword}`"
                                        v-model="user.password"
                                        :append-icon="showpassword ? 'visibility' : 'visibility_off'"
                                        @click:append="showpassword = !showpassword"
                                        :type="showpassword ? 'password' : 'text'"
                                        :rules="passwordRules"
                                        @keyup.enter="onSubmit()"
                                        :error="validation.error"
                                        required
                                    ></v-text-field>
                                </v-flex>

                            </v-layout>

                            <v-layout row justify-center v-if="validation.error">
                                <v-flex>
                                    <div class="red--text text-xs-center">{{validation.message}}</div>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap fluid class="text-xs-center">

                                <v-flex xs12 v-if="errorLogin">
                                    <p class="mb-0 red--text">Access denied user email & password is not match.</p>
                                </v-flex>

                                <v-flex xs12>
                                    <input type="hidden" name="_token"/>
                                    <v-btn
                                        raised
                                        dark
                                        :loading="loading"
                                        :disabled="loading"
                                        @click="onSubmit()">
                                        LOGIN
                                    </v-btn>
                                </v-flex>

                                <v-flex xs12>
                                    <a @click.stop="onForgotPassword()"
                                       class="forgot-password">
                                        {{ trans.forgot }} {{ trans.password}}
                                    </a>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-container>
    </v-app>
</template>
<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                open_login_dialog: false,

                errorLogin: false,

                showpassword: true,
                valid: false,
                loginProgress: false,
                user: {
                    email: '',
                    password: ''
                },
                emailRules: [
                    v => !!v || 'Email is required',
                    v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Email must be valid'
                ],
                passwordRules: [
                    v => !!v || 'Password is required'
                ],

                validation: {
                    error: false,
                    message: ''
                },

                //Loading button
                loading: false,
                loader: null,
            }
        },

        computed: {
            ...mapGetters({
                isLogin: 'getIsLogin',
                isLoading: 'getIsLoading',
                themeOption: 'getThemeOption',
                isAdmin: 'getIsAdmin',
                trans: 'getFields'
            })
        },

        watch: {},

        created() {
            this.$store.commit('setIsLogin', false)
            this.$store.commit('setUserRole', false)
        },

        methods: {

            onSubmit() {
                if (this.$refs.login_form.validate()) {

                    // make spinner visible
                    this.loginProgress = true;
                    this.loading = true;

                    // prepare submitting data
                    let loginForm = new FormData()
                    loginForm.append('email', this.user.email)
                    loginForm.append('password', this.user.password)

                    // submit data with ajax request
                    axios.post('/login', loginForm)
                        .then(response => {
                            if(response.success){
                                this.$store.commit('admin')
                                this.$router.push({name: 'dashboard'})
                            }
                            this.loginProgress = true
                            this.loading = true
                        })
                        .catch(error => {
                            this.loading = false
                            this.errorLogin = true
                            this.loginProgress = false
                        });
                }
            },

            onForgotPassword() {
                this.open_login_dialog = false
            },
        }
    }
</script>
