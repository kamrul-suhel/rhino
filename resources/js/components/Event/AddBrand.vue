<template>
    <v-form ref="brandEventForm"
            v-model="valid"
            lazy-validation
    >
        <v-card min-height="400"
                max-height="600">
            <v-card-title>
                <h3>{{ `${trans.brands}`}}</h3>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text class="pa-0">
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-list two-line subheader>
                            <v-list-tile
                                v-for="brand in brands"
                                :key="brand.id"
                                avatar
                                @click=""
                            >
                                <v-list-tile-avatar>
                                    <v-avatar
                                        :tile="false"
                                        :size="36"
                                        color="grey lighten-4"
                                    >
                                        <img :src="brand.logo | image(themeOption.brandDefaultImage)">
                                    </v-avatar>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title>{{ brand.name }}</v-list-tile-title>
                                    <v-list-tile-sub-title>{{ brand.subtitle }}</v-list-tile-sub-title>
                                </v-list-tile-content>

                                <v-list-tile-action>
                                    <v-btn icon ripple
                                           v-if="checkBrandExists(brand)"
                                           @click="onRemoveRelation(brand.id)">
                                        <v-icon color="red lighten-1">remove_circle_outline</v-icon>
                                    </v-btn>

                                    <v-btn icon ripple
                                           v-else
                                           @click="onCreateRelation(brand.id)">
                                        <v-icon color="lighten-1">add_circle_outline</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>
    </v-form>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                valid: true,
                brandIds: []
            }
        },

        computed: {
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                brands: 'getBrandsForDropDown',
                selectedBrands: 'getEventBrands',
                initializeBrands: 'getInitializeBrands',
                selectedEvent: 'getSelectedEvent'
            })
        },

        watch: {},

        created() {
        },

        methods: {
            checkBrandExists(Brand){
              const found = _.find(this.selectedBrands, (brand)=>{
                  return brand.id === Brand.id
              })

                if(found){
                    return true
                }
                return false
            },

            onCreateRelation(brandId) {
                const URL = `/api/events/${this.selectedEvent.id}/brands`

                let brandEventFrom = new FormData()
                brandEventFrom.append(`brand_id`, brandId)
                brandEventFrom.append('event_id', this.selectedEvent.id)
                axios.post(URL, brandEventFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setInitializeBrands')
                    }
                })
            },

            onRemoveRelation(brandId){
                const URL = `/api/events/${this.selectedEvent.id}/brands/${brandId}`
                let brandEventFrom = new FormData()
                brandEventFrom.append(`brand_id`, brandId)
                brandEventFrom.append(`_method`, 'DELETE')
                brandEventFrom.append('event_id', this.selectedEvent.id)
                axios.delete(URL, brandEventFrom).then((response) => {
                    if (response.data.success) {
                        this.$store.commit('setInitializeBrands')
                    }
                })
            },

            reset() {
                this.$refs.brandEventForm.reset()
            },

            resetValidation() {
                this.$refs.brandEventForm.resetValidation()
            },

            onFetchBrands() {
                this.reset()
                this.resetValidation()
                this.$store.commit('setInitializeBrands')
            }
        }
    }
</script>
