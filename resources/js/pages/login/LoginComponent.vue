<template>
    <v-app
        id="inspire"
        class="guest-login"
        style="background-image:url('images/guest-login.png')"
    >
        <v-layout row justify-center align-center>
            <v-card width="600" class="login-section px-4">
                <v-form method="post" v-model="valid" ref="guestLoginGorm">
                    <v-layout row wrap pa-4>
                        <v-flex>
                            <v-layout row justify-end mt-4 class="language-select stroke-dropdown">
                                <language-picker
                                    :languageId="1"
                                    isFrontend
                                ></language-picker>
                            </v-layout>
                        </v-flex>

                        <v-flex xs12>
                            <h2 class="login-title">{{ trans.welcomeBack }}!</h2>
                            <h3>{{ trans.EnterYourUniqueCode }}</h3>
                        </v-flex>

                        <v-flex xs12>
                            <v-text-field
                                color="dark"
                                :hint="trans.egnchfge23sxs"
                                v-model="user.unique"
                                :rules="[v => !!v || `${trans.uniqueIdIsRequired}`]"
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
                            <p class="mb-0 red--text">{{ trans.uniqueCodeNotFound }}</p>
                        </v-flex>

                        <v-flex xs12 mt-2>
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
                    </v-layout>
                </v-form>
            </v-card>
        </v-layout>
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
              themeOption: 'getThemeOption',
              selectedLanguage: 'getSubSelectedLanguage'
          })
        },

        watch: {
            selectedLanguage(){
                this.$store.dispatch('fetchSettingFields', {languageId: this.selectedLanguage.id});
            }
        },

        created() {
            this.$store.commit('setUserRole', false)
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
                    guestLogin.append('method', 'online')
                    guestLogin.append('languageId', this.selectedLanguage.id)

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
