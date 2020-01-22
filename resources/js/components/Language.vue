<template>
    <v-autocomplete
        :items="languages"
        item-text="code2"
        item-value="id"
        :color="themeOption.inputColor"
        v-model="selectedLanguageId"
        return-object
        :class="isFrontend ? 'frontend-language' : ''"
        :append-icon="isFrontend ? 'expand_more' : 'arrow_drop_down'"
        :prepend-icon="`flag-icon-${selectedLanguage.code2}`"
        @change="onSubLanguageChange"
        :label="trans.language">
        <template v-slot:selection="data">
            <v-chip
                :selected="data.selected"
                close
            >
                <v-avatar>
                    <flag :iso="data.item.code2"></flag>
                </v-avatar>
                {{ data.item.code2 }}
            </v-chip>
        </template>

        <template v-slot:item="data">

            <v-list-tile-avatar>
                <flag :iso="data.item.code2"></flag>
            </v-list-tile-avatar>
            <v-list-tile-content>
                <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
            </v-list-tile-content>
        </template>
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
