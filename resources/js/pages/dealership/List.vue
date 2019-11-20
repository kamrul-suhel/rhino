<template>
    <v-container>
        <v-card>
            <v-card-text>
                <v-breadcrumbs :items="items"
                               class="pa-0">
                    <template v-slot:item="props">
                        <a :href="props.item.href"
                           :class="[props.item.disabled && 'disabled', 'white--text']">
                            {{ props.item.text.toUpperCase() }}
                        </a>
                    </template>
                </v-breadcrumbs>
            </v-card-text>
        </v-card>
        <h2>Dealership List</h2>
    </v-container>
</template>

<script>
    export default {
        data: () => {
            return {
                items: [
                    {
                        text: 'Dashboard',
                        disabled: false,
                        href: 'breadcrumbs_dashboard'
                    },
                    {
                        text: 'Link 1',
                        disabled: false,
                        href: 'breadcrumbs_link_1'
                    },
                    {
                        text: 'Link 2',
                        disabled: true,
                        href: 'breadcrumbs_link_2'
                    }
                ]
            }
        },

        created(){

        },

        methods: {

        }
    }
</script>
