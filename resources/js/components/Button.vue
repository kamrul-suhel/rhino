<template>
    <v-btn
        :loading="loadingBar && (identifier == buttonIdentifier)  ? loading : false"
        :small="small"
        :flat="flat"
        :color="color"
        @click="onClick"
    >
        {{ text }}
    </v-btn>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        date() {
            return {}
        },

        props: {
            identifier: {
                type: String,
                required: true
            },

            text: {
                type: String,
                required: true
            },
            color: {
                type: String,
                required: true
            },

            small: {
                type: Boolean
            },

            flat: {
                type: Boolean
            },

            loadingBar: {
                type: Boolean,
                default: true
            }
        },

        computed: ({
            ...mapGetters({
                loading: 'getButtonLoading',
                buttonIdentifier: 'getButtonIdentifier'
            }),
        }),

        methods: {
            onClick() {
                if (this.loadingBar) {
                    this.$store.commit('setButtonLoading', true)
                    this.$store.commit('setButtonIdentifier', this.identifier)
                }
                this.$emit('click', true)
            }
        }
    }
</script>
