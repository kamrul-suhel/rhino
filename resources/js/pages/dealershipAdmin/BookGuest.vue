<template>
    <v-container fluid px-5>
        <v-layout row wrap px-4>
            <v-flex xs6>
                <h2>{{ `${trans.book} ${trans.a} ${trans.guest}`}}</h2>
            </v-flex>

            <v-flex xs 6align-self-end>
                <v-layout row wrap justify-end>
                    <v-btn outline round
                           :color="themeOption.adminNavIconColor"
                           class="ma-0">
                        <v-icon left dark>reply</v-icon>
                        {{ `${trans.back}` }}
                    </v-btn>
                </v-layout>
            </v-flex>
        </v-layout>

        <v-layout mt-4>
            <v-flex xs12 sm4>
                <v-card class="r-border-round">
                    <v-list>
                        <v-list-tile
                            avatar
                            @click=""
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                        :color="themeOption.adminNavIconColor">more_horiz
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.with} ${trans.a} ${trans.uniqueCode}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>

                        <v-list-tile
                            avatar
                            @click=""
                        >
                            <v-list-tile-avatar>
                                <v-icon
                                        :color="themeOption.adminNavIconColor">close
                                </v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ `${trans.without} ${trans.a} ${trans.uniqueCode}` }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-card>
            </v-flex>
        </v-layout>

        <v-layout row wrap mt-5>
            <div class="r-tab">
                <div class="r-tab-title">
                    <div>
                        <v-icon
                                :color="themeOption.adminNavIconColor">more_horiz
                        </v-icon>
                    </div>

                    <div>
                        {{ `${trans.with} ${trans.a} ${trans.uniqueCode}` }}
                    </div>
                    <div>
                        <v-icon
                                :color="themeOption.adminNavIconColor">close
                        </v-icon>
                    </div>
                </div>

                <div class="r-tab-content">
                    <v-container fluid pa-0 grid-list-xl>
                        <v-layout row wrap>
                            <v-flex xs12 sm8>
                                <v-layout row wrap>
                                    <v-flex xs12 sm6>
                                        <v-autocomplete
                                            v-model="select"
                                            :color="themeOption.inputColor"
                                            :loading="loading"
                                            :items="items"
                                            :search-input.sync="search"
                                            flat
                                            box
                                            :label="`${trans.select} ${trans.source}`"
                                        ></v-autocomplete>
                                    </v-flex>

                                    <v-flex xs12 sm6>
                                        <v-text-field
                                            :color="themeOption.inputColor"
                                            box
                                        ></v-text-field>
                                    </v-flex>

                                </v-layout>
                            </v-flex>

                            <v-flex xs12 class="text-xs-center">
                                <v-btn round
                                       :color="themeOption.adminNavIconColor"
                                       class="ma-0">
                                    <span style="color:#fff;">{{ `${trans.submit}` }}</span>
                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </div>
            </div>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {

        components: {},

        data() {
            return {
                loading: false,
                items: [],
                search: null,
                select: null,
                states: []
            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                dealership: 'getSelectedDealership',
            })
        }),

        watch: {
            search (val) {
                val && val !== this.select && this.querySelections(val)
            }
        },

        created() {
        },

        methods: {
            querySelections (v) {
                this.loading = true
                // Simulated ajax query
                setTimeout(() => {
                    this.items = this.states.filter(e => {
                        return (e || '').toLowerCase().indexOf((v || '').toLowerCase()) > -1
                    })
                    this.loading = false
                }, 500)
            }
        }
    }
</script>
