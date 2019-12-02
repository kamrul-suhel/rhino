<template>
    <div>
        <v-toolbar
            fixed
            clipped-left
            app
            color="dark"
        >
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-icon class="mx-3">fab fa-youtube</v-icon>
            <v-toolbar-title class="mr-5 align-center">
                <span class="title">Rhino</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-layout row align-center style="max-width: 350px">
                <v-autocomplete
                    color="white"
                    :placeholder="trans.select_a_language"
                    prepend-icon="search"
                    :items="languages"
                    item-text="name"
                    @change="selectedLanguage"
                    item-value="id"
                    return-object
                ></v-autocomplete>
            </v-layout>
        </v-toolbar>


        <v-snackbar
            v-model="snackbar"
            right
            :timeout="timeout"
            top
            color="green"
        >
            {{ text }}
            <v-btn
                color="white"
                flat
                @click="snackbar = false"
            >
                Close
            </v-btn>
        </v-snackbar>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        data() {
            return {
                snackbar: false,
                text: '',
                timeout: 2000,
            }
        },

        watch: {},

        computed: {
            ...mapGetters({
                trans: 'getFields',
                languages: 'getLanguages',
                isLogin: 'getIsLogin'
            })
        },

        created() {
        },

        methods: {
            /**
             * Language change render all translation
             * @param value
             */
            selectedLanguage(value) {
                this.$store.commit('setSelectedLanguage', value)
            }
        }
    }
</script>
