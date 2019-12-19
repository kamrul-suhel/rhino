<template>
    <v-layout>
        <v-flex xs12 md4 justify-center >
            <v-card width="90%" height="auto">
                <v-img

                    :src="brand.logo|image(themeOption.brandDefaultImage)"
                    aspect-ratio="2.75"
                ></v-img>

                <v-card-title primary-title>
                    <div>
                        <h4 class="headline mb-0">{{brand.name}}</h4>
                    </div>
                </v-card-title>
            </v-card>
        </v-flex>

        <v-flex xs12 md8>
            <vehicle model="brand" subComponent></vehicle>
        </v-flex>

    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import EditVehicle from '../vehicles/Edit'

    export default {

        components: {
            'vehicle': EditVehicle
        },

        data(){
            return {

            }
        },
        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brand: 'getSelectedBrand',
                vehicle: 'getSelectedVehicle'
            })
        }),

        created() {
            this.initialize()
        },

        methods: {
            initialize() {
                this.$store.dispatch('fetchBrand', {id: this.$route.params.brandId})
            },
        }
    }
</script>
