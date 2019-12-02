<template>
    <v-form ref="brandDealershipForm">
        <v-card>
            <v-card-title>
                Makake relation between bran
            </v-card-title>

            <v-card-text>

                <v-select :label="trans.select_a_brand"
                          :color="themeOption.inputColor"
                          item-text="name"
                          item-value="id"
                          @change="onBrandChange"
                          :items="brands"
                >
                </v-select>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn small
                       :color="themeOption.buttonSecondaryColor"
                >
                    {{ trans.cancel }}
                </v-btn>

                <v-btn small
                       :color="themeOption.buttonPrimaryColor"
                >{{ trans.add_brand }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {}
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown'
            })
        },

        watch: {},

        created() {
        },

        methods: {
            onBrandChange(value) {
                console.log(value)
            }
        }
    }
</script>
