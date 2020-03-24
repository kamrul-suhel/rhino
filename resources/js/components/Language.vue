<template>
    <v-autocomplete
        :items="languages"
        item-text="language_code"
        item-value="id"
        :color="themeOption.inputColor"
        v-model="selectedLanguageId"
        return-object
        :class="[isFrontend ? 'frontend-language' : '', model]"
        :append-icon="isFrontend ? 'expand_more' : 'arrow_drop_down'"
        :prepend-icon="`flag-icon-${selectedLanguage.language_code}`"
        @change="onSubLanguageChange"
        :label="trans.language"
        :solo="solo"
        :flat="flat">
        <template v-slot:selection="data">
            <v-chip
                :selected="data.selected"
                close
                v-if="chip"
            >
                <v-avatar>
                    <flag :iso="data.item.country_code"></flag>
                </v-avatar>
                {{ data.item.country_code }}
            </v-chip>
            <span v-else>{{ `${data.item.name} (${data.item.country_code})` }}</span>
        </template>

        <template v-slot:item="data">

            <v-list-tile-avatar>
                <flag :iso="data.item.country_code"></flag>
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
                required: false,
                type: Number,
                default: 1
            },
            isFrontend: {
                required: false,
                type: Boolean,
                default: false
            },

            model: {
                type: String,
                required: false
            },

            solo: {
                type: Boolean,
                required: false,
                default: true
            },

            flat: {
                type: Boolean,
                required: false,
                default: true
            },
            chip: {
                type: Boolean,
                required: false,
                default: true
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

                if(this.languageId){
                    const subSelectedLanguage = _.filter(this.languages, (language) => {
                        return language.id === this.languageId
                    })
                    this.$store.commit('setSubSelectedLanguage', subSelectedLanguage[0])
                }
            }
        }
    }
</script>
