<template>
    <div class="dealership-brands">
        <v-layout row wrap pt-4>
            <v-flex xs12 sm8 pa-2>
                <v-card>
                    <v-card-title>
                        Brand list
                    </v-card-title>

                    <v-card-text>
                        brand content
                    </v-card-text>
                </v-card>
            </v-flex>

            <v-flex xs12 sm4 pa-2>
               <Create></Create>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    import Create from '../../components/Dealership/CreateForm'

    export default {
        components:{
            Create
        },

        props: {
            dealershipId:{
                type: Number,
                required: true
            }
        },

        created(){

        }
    };
</script>
