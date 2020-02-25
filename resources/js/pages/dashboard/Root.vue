<template>
    <div>
        <AdminDashboard v-if="authUser.level === 'admin'"></AdminDashboard>
        <DealershipDashboard v-if="checkAuthAccess('dealership')"></DealershipDashboard>
        <SalesExecutiveDashboard v-if="checkAuthAccess('salesExecutive')"></SalesExecutiveDashboard>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AdminDashboard from './AdminDashboard'
    import DealershipDashboard from "./DealershipDashboard"
    import CONST from '@/utils/const'
    import SalesExecutiveDashboard from "./SalesExecutiveDashboard";

    export default {
        components: {
            AdminDashboard,
            DealershipDashboard,
            SalesExecutiveDashboard
        },

        data() {
            return {

            }
        },

        computed: ({
            ...mapGetters({
                languages: 'getLanguages',
                trans: 'getFields',
                themeOption: 'getThemeOption',
                authUser: 'getAuthUser'
            })
        }),

        methods: {
            checkAuthAccess(type){

                switch(type){
                    case 'dealership':
                        if(this.authUser.level === CONST.MANAGER){
                            return true
                        }
                        break
                    case 'salesExecutive':
                        if(this.authUser.level === CONST.SALE_EXECUTIVE){
                            return true
                        }
                }

                return false
            }
        }
    }
</script>
