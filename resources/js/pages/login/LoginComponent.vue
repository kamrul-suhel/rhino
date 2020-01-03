<template>
    <v-app
        id="inspire"
        class="guest-login"
        style="background-image:url('images/guest-login.png')"
    >
    <v-container fill-height
                 justify-center
                 align-content-center>
            <v-card width="450px">
                <v-card-text class="login-section">
                    <v-form method="post" v-model="valid" ref="guestLoginGorm">
                        <v-container grid-list-xs>
                            <v-layout row wrap id="login-section">

                                <v-flex xs12>
                                    <h2 class="login-title">{{ trans.welcome }}</h2>
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
                            </v-layout>

                            <v-layout row justify-center v-if="validation.error">
                                <v-flex>
                                    <div class="red--text text-xs-center">{{validation.message}}</div>
                                </v-flex>
                            </v-layout>

                            <v-layout row wrap fluid>
                                <v-flex xs12 v-if="errorLogin">
                                    <p class="mb-0 red--text">Access denied user email & password is not match.</p>
                                </v-flex>

                                <v-flex xs12>
                                    <input type="hidden" name="_token"/>
                                    <v-btn
                                        class="ma-0"
                                        raised
                                        dark
                                        :loading="loading"
                                        :disabled="loading"
                                        @click="onSubmit()">
                                        {{ trans.login }}
                                    </v-btn>
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
