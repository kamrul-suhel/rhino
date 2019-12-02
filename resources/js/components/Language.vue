<template>
    <v-autocomplete
        :items="languages"
        item-text="name"
        item-value="id"
        :color="themeOption.inputColor"
        v-model="selectedLanguageId"
        return-object
        @change="onSubLanguageChange"
        :label="trans.select_a_language">
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

        watch:{
            languageId(value){
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

            initialize(){
                this.selectedLanguageId = this.languageId
            }
        }
    }
</script>
