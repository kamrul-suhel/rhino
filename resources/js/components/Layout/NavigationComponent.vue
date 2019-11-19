<template>

    <v-navigation-drawer
            fixed
            clipped
            v-model="drawer"
            app
            width="250"
    >
        <v-list>
            <v-list-tile class="header-section">
                <v-list-tile-title>
                    <div class="store-logo">
                        <img src="/images/sh-tel.gif"/>
                    </div>
                </v-list-tile-title>
            </v-list-tile>

            <v-list-tile>
                <v-list-tile-action>
                    <v-icon>home</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>Home</v-list-tile-title>
            </v-list-tile>

            <v-list-group
                    dark
                    color="dark"
                    v-for="(navs, index) in items"
                    :key="index"
                    :prepend-icon="navs.icon"
                    v-if="Object.prototype.hasOwnProperty.call(navs, 'access') || role === 'admin'"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title v-text="navs.text"></v-list-tile-title>
                </v-list-tile>

                <v-list-tile
                        v-for="(nav, i) in navs.navs"
                        :key="i"
                        @click="onPageChange(nav)"
                        v-if="Object.prototype.hasOwnProperty.call(nav, 'access') || role === 'admin'"
                >
                    <v-list-tile-title v-text="nav.text"></v-list-tile-title>
                    <v-list-tile-action>
                        <v-icon v-text="nav.icon"></v-icon>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list-group>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {

        computed: {
            ...mapGetters({
                role: 'getUserRole',
                isLogin: 'getIsLogin'
            })
        },

        data() {
            return {
                drawer: true,
                items: [
                    {
                        icon: 'add_shopping_cart',
                        text: 'Products',
                        navs: [
                            {
                                icon: 'history',
                                text: 'All Products',
                                link: 'products',
                                access: 'staff'
                            },

                            {
                                icon: 'history',
                                text: 'Add Product',
                                link: 'productsAdd',
                                access: 'staff'
                            },


                            {
                                icon: 'subscriptions',
                                text: 'Categories',
                                link: 'categories',
                                access: 'staff'
                            }
                        ],
                    },

                    {
                        icon: 'compare_arrows',
                        text: 'Transitions',
                        access: 'staff',
                        navs: [
                            {
                                icon: 'compare_arrows',
                                text: 'Transitions',
                                link: 'transaction',
                                access: 'staff'
                            },

                            {
                                icon: 'compare_arrows',
                                text: 'Sale product',
                                link: 'create_transaction',
                                access: 'staff'
                            },

                            {
                                icon: 'compare_arrows',
                                text: 'Sale Return',
                                link: 'saleReturn',
                                access: 'staff'
                            }
                        ]
                    },

                    {
                        icon: 'compare_arrows',
                        text: 'Sale Assistance',
                        access: 'staff',
                        navs: [
                            {
                                icon: 'compare_arrows',
                                text: 'Create Record',
                                link: 'sale_assistance_create',
                                access: 'staff'
                            },

                            {
                                icon: 'compare_arrows',
                                text: 'Update record',
                                link: 'sale_assistance_update',
                                access: 'staff'
                            }
                        ]
                    },

                    {
                        icon: 'people',
                        text: 'Customers',
                        access: 'staff',
                        navs: [
                            {
                                icon: 'people',
                                text: 'Customers',
                                link: 'customers',
                                access: 'staff'
                            },

                            {
                                icon: 'people',
                                text: 'Customer Ledger',
                                link: 'customer_ledger',
                                access: 'admin'
                            }

                        ]
                    },

                    {
                        icon: 'assignment',
                        text: 'Expenses',
                        navs: [
                            {
                                icon: 'assignment',
                                text: 'Expenses',
                                link: 'expense',
                                access: 'staff'
                            },

                            {
                                icon: 'category',
                                text: 'Ex Categories',
                                link: 'expense_categories',
                                access: 'staff'
                            }

                        ]
                    },

                    {
                        icon: 'store',
                        text: 'Company',
                        navs: [
                            {
                                icon: 'store',
                                text: 'Companies',
                                link: 'company',
                                access: 'staff'
                            },

                            {
                                icon: 'compare_arrows',
                                text: 'C. Transaction',
                                link: 'ctransaction',
                            }

                        ]
                    },

                    {
                        icon: 'timeline',
                        text: 'Accounting',
                        navs: [
                            {
                                icon: 'transform',
                                text: 'A Transaction',
                                link: 'accounting_product_transaction',
                            },
                            {
                                icon: 'timeline',
                                text: 'A Expense',
                                link: 'account_expense',
                            },

                            {
                                icon: 'timeline',
                                text: 'Balance',
                                link: 'account_balance',
                            },

                            {
                                icon: 'timeline',
                                text: 'A Product',
                                link: 'expenses',
                            }
                        ]
                    },

                    {
                        icon: 'account_balance',
                        text: 'Bank',
                        navs: [
                            {
                                icon: 'account_balance',
                                text: 'All Bank',
                                link: 'banks'
                            }
                        ]
                    },

                    {
                        icon: 'settings',
                        text: 'Settings',
                        navs: [
                            {
                                icon: 'settings',
                                text: 'Shops',
                                link: 'shops',
                            },

                            {
                                icon: 'security',
                                text: 'Security',
                                link: 'user',
                            }
                        ]
                    },

                    {
                        icon: 'settings_power',
                        text: 'Log out',
                        access: 'staff',
                        navs: [
                            {
                                icon: 'settings_power',
                                text: 'Log out',
                                link: 'logout',
                                access: 'staff',
                            }
                        ]
                    }
                ],
            }
        },

        methods: {
            async onPageChange(item) {
                if (item.link === 'logout') {
                   await axios.get('/logout').then(() => {
                        LoginEventBus.logoutStateChange();
                        this.$store.commit('setIsLogin', false)
                        this.$router.push({name: 'login'});
                    });
                    return;
                }
                this.$router.push({name: item.link});
            },

            onCloseWindow() {
                window.close();
            }
        }
    }
</script>
