<template>
    <v-carousel hide-controls
                class="brand-carousel"
                v-if="brands.length > 0"
                height="120">
        <v-carousel-item
            v-for="brand in brands"
            :key="brand.id"
            :src="brand.logo"
        ></v-carousel-item>
    </v-carousel>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrands'
            })
        },

        created() {

        }
    }
</script>
