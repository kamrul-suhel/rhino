<template>
    <v-container pa-0>
        <h2>Language switcher</h2>
        {{ selectedLanguage.name }}
        <v-divider></v-divider>

        <h2>{{ date }}</h2>
        <h2>{{ date2 }}</h2>
        <h2>{{ date3 }}</h2>
        <h2>{{ date4 }}</h2>
        <h2>{{ date5 }}</h2>
        <h2>{{ date6 }}</h2>
        <h2>{{ date7 }}</h2>
        <h2>{{ date8 }}</h2>
        <h2>{{ date9 }}</h2>
        <h2>{{ date10 }}</h2>
        <h2>{{ date11 }}</h2>
        <h2>{{ date12 }}</h2>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {

        components: {
        },

        data() {
            return {
                date:'',
                date2:'',
                date3:'',
                date4:'',
                date5:'',
                date6:'',
                date7:'',
                date8:'',
                date9:'',
                date10:'',
                date11:'',
                date12:'',
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                selectedLanguage: 'getSelectedLanguages'
            })
        }),

        watch: {
            selectedLanguage(){
                this.changeLanguage()
            }
        },

        created() {
        },

        methods: {
            changeLanguage(){
                let newMoment = new moment()
                newMoment.locale(this.selectedLanguage.code2)

                this.date = newMoment.format('LT');   // 18:15
                this.date2 = newMoment.format('LTS');  // 18:15:31
                this.date3 = newMoment.format('L');    // 12.12.2019
                this.date4 = newMoment.format('l');    // 12.12.2019
                this.date5 = newMoment.format('LL');   // 12 снежня 2019 г.
                this.date6 = newMoment.format('ll');   // 12 снеж 2019 г.
                this.date7 = newMoment.format('LLL');  // 12 снежня 2019 г., 18:15
                this.date8 = newMoment.format('lll');  // 12 снеж 2019 г., 18:15
                this.date9 = newMoment.format('LLLL'); // чацвер, 12 снежня 2019 г., 18:15
                this.date10 = newMoment.format('llll');
                this.date11 = newMoment.format('MMMM Do YYYY, h:mm:ss a');;
                this.date12 = newMoment.format('MMMM Do YYYY, h:mm:ss a');;
            }
        }

    }
</script>
