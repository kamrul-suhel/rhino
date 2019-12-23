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
                    </div>
                </v-list-tile-title>
            </v-list-tile>

            <v-list-tile>
                <v-list-tile-action>
                    <v-icon>home</v-icon>
                </v-list-tile-action>
                <v-list-tile-title>{{ trans.dashboard }}</v-list-tile-title>
            </v-list-tile>

            <v-list-group
                    v-for="(navs, index) in items"
                    :key="index"
                    :prepend-icon="navs.icon"
            >
                <v-list-tile slot="activator">
                    <v-list-tile-title v-text="navs.text"></v-list-tile-title>
                </v-list-tile>

                <v-list-tile
                        v-for="(nav, i) in navs.navs"
                        :key="i"
                        @click="onPageChange(nav)"
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
                trans: 'getFields',
                openNavigation: 'getIsNavigationOpen',
                items: 'getNavigationBar'
            })
        },

        data() {
            return {
                drawer: true
            }
        },

        watch:{
            openNavigation(){
                this.drawer = this.openNavigation
            }
        },

        methods: {
            async onPageChange(item) {
                if(item.link === this.$route.name){
                    return
                }else{
                    this.$router.push({name: item.link});
                }
            },

            onCloseWindow() {
                window.close();
            }
        }
    }
</script>
