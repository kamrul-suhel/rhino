<template>
    <v-layout row wrap>
        <v-flex xs12 md8 pt-3>
            <UserList subComponent
                      model="dealership"
            ></UserList>
        </v-flex>

        <v-flex xs12 md4 pl-2>
            <AddUser></AddUser>
        </v-flex>
    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import UserList from '@/pages/user/List'
    import AddUser from '@/components/Dealership/AddUser'

    export default {
        components:{
            UserList,
            AddUser
        },

        data() {
            return {
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        }),

        watch: {
        },

        created() {
        },

        methods: {
            // Initialize data when first render
            initialize() {

            }
        }
    }
</script>
