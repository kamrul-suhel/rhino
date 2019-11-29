<template>
    <v-layout>
        <v-snackbar
            v-model="show"
            :color="bgColor"
            :timeout="themeOption.snackBarTimeout"
            top
            right
        >
            {{ message }}
            <v-btn
                dark
                flat
                @click="closeSnackBarMessage()"
            >
                Close
            </v-btn>
        </v-snackbar>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                isSet: false
            }
        },

        computed: ({
            ...mapGetters({
                themeOption: 'getThemeOption',
                trans: 'getFields',
                message: 'getSnackBarMessage',
                timeOut: 'getSnackBarTimeOut',
                positionX: 'getPositionX',
                positionY: 'getPositionY',
                bgColor: 'getSnackBarBgColor'
            }),

            show: {
                get: function () {
                    return this.$store.getters.getOpenMessage
                },
                set: function (value) {
                    this.$store.commit('setSnackbarMessage', {
                        openMessage: value
                    })
                }
            }
        }),

        watch: {},

        methods: {
            closeSnackBarMessage() {
                this.$store.commit('setSnackbarMessage', {
                    openMessage: false
                })
            }
        }
    }

</script>
