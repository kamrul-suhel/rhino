<template>
    <v-autocomplete
        :items="languages"
        item-text="name"
        item-value="id"
        :color="themeOption.inputColor"
        v-model="selectedLanguageId"
        return-object
        :class="isFrontend ? 'frontend-language' : ''"
        :append-icon="isFrontend ? 'expand_more' : 'arrow_drop_down'"
        :prepend-icon="`flag-icon-${selectedLanguage.code2}`"
        @change="onSubLanguageChange"
        :label="trans.language">
    </v-autocomplete>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                selectedLanguageId: null
            }
        },

        props: {
            languageId: {
                required: true
            },
            isFrontend: {
                required: false,
                type: Boolean,
                default: false
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                languages: 'getLanguages',
                selectedLanguage: 'getSubSelectedLanguage'
            }),
        },

        watch: {
            languageId(value) {
                this.selectedLanguageId = value
            }
        },

        created() {
            this.initialize()
        },

        methods: {
            onSubLanguageChange(selectedLanguage) {
                this.$store.commit('setSubSelectedLanguage', selectedLanguage)
            },

            initialize() {
                this.selectedLanguageId = this.languageId
            }
        }
    }
</script>
