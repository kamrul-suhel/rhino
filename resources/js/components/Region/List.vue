<template>
    <v-flex xs12 sm4>
        <v-card class="ml-4">
            <v-card-title
                primary-title
            >
                <h3 :class="themeOption.textHeadingColor+'--text'">{{ trans.regions }}</h3>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text>
                <v-data-table
                    flat
                    hide-headers
                    hide-actions
                    :headers="headers"
                    :items="desserts"
                    class="elevation-1"
                >
                    <template slot="headerCell" slot-scope="props">
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
          <span v-on="on">
            {{ props.header.text }}
          </span>
                            </template>
                            <span>
          {{ props.header.text }}
        </span>
                        </v-tooltip>
                    </template>
                    <template v-slot:items="props">
                        <td>{{ props.item.name }}</td>
                        <td class="text-xs-right">{{ props.item.calories }}</td>
                        <td class="text-xs-right">{{ props.item.fat }}</td>
                        <td class="text-xs-right">{{ props.item.carbs }}</td>
                        <td class="text-xs-right">{{ props.item.protein }}</td>
                        <td class="text-xs-right">{{ props.item.iron }}</td>
                    </template>
                </v-data-table>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions class="pa-3">
                <v-spacer></v-spacer>
                <v-btn
                    small
                    @click="dialog = false"
                >
                    {{ trans.cancel }}
                </v-btn>

                <v-btn
                    class="success"
                    small
                    @click="updateCountry()"
                >
                    {{ trans.update }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-flex>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data () {
            return {
                headers: [
                    {
                        text: 'Dessert (100g serving)',
                        align: 'left',
                        sortable: false,
                        value: 'name'
                    },
                    { text: 'Calories', value: 'calories' },
                    { text: 'Fat (g)', value: 'fat' },
                    { text: 'Carbs (g)', value: 'carbs' },
                    { text: 'Protein (g)', value: 'protein' },
                    { text: 'Iron (%)', value: 'iron' }
                ],
                desserts: [

                ]
            }
        },

        computed:({
            ...mapGetters({
                trans: 'getFields',
                // headers: 'getCountriesListHeader',
                selectedCountry: 'getSelectedCountry',
                themeOption: 'getThemeOption'
            })
        })
    }
</script>
