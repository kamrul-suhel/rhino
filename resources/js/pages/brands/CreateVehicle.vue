<template>
    <v-layout>
        <v-flex xs12 md4 justify-center >
            <v-card width="90%" height="auto">
                <v-img

                    :src="brand.logo"
                    aspect-ratio="2.75"
                ></v-img>
            </v-card>
        </v-flex>

        <v-flex xs12 md8>
            <h2>{{ trans.createVehicleFromBrand }}</h2>
            <vehicle model="brand" subComponent></vehicle>
        </v-flex>

    </v-layout>
</template>

<script>
    import {mapGetters} from 'vuex'
    import CreateVehicle from '../vehicles/Create'

    export default {

        components: {
            'vehicle': CreateVehicle
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
                this.$store.dispatch('fetchBrand', {id: this.$route.params.brandId});
            },
        }
    }
</script>
