<template>
    <v-layout>
        <v-container>
           

            <v-flex xs12 lg12>
                <addUser model="dealership" subComponent></addUser>
            </v-flex>
        </v-container>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AddUser from '../user/Create'

    export default {        

        components: {
            'addUser': AddUser
        },

        data(){
            return {
            
            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
            })
        }),

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchDealership', {id: this.$route.params.dealershipId});
            },
        }
    }
</script>
