<template>
    <v-layout row wrap>
        <v-flex xs12 sm8 pr-4>
            <Users></Users>
        </v-flex>

        <v-flex xs12 sm4>
            <AddUser></AddUser>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AddUser from './AddUser'
    import Users from './Users'

    export default {
        components: {
            AddUser,
            Users
        },

        data() {
            return {
                valid: true,
                brandIds: []
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        },

        watch: {},

        created() {
            this.initialize()
        },

        methods: {
            initialize(){
                this.$store.dispatch('fetchUserForDropDown', {})
            },

            checkBrandExists(Brand){
                const found = _.find(this.selectedBrands, (brand)=>{
                    return brand.id === Brand.id
                })

                if(found){
                    return true
                }
                return false
            }
        }
    }
</script>
