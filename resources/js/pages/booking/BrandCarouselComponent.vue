<template>
    <v-carousel hide-controls
                class="brand-carousel"
                height="120">
        <v-carousel-item
            v-for="(item,i) in items"
            :key="i"
            :src="item.src"
        ></v-carousel-item>
    </v-carousel>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                items: [
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg'
                    },

                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg'
                    },

                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg'
                    },

                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg'
                    }
                ]
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        },

        created() {

        }
    }
</script>
