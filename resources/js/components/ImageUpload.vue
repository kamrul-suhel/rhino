<template>
    <v-layout row wrap>
        <image-uploader
            :preview="true"
            :className="['fileinput', { 'fileinput--loaded': hasImage }]"
            capture="environment"
            :debug="0"
            accept="image/*"
            doNotResize="gif"
            :autoRotate="true"
            outputFormat="file"
            @input="setImage"
        >
            <label for="fileInput" slot="upload-label">
                <v-icon right dark>cloud_upload</v-icon>

                <span class="upload-caption">
                    {{hasImage ? "Replace" : "Click to upload" }}
                </span>
            </label>
        </image-uploader>
    </v-layout>
</template>

<script>

    import {mapGetters} from 'vuex'
    export default {
        data() {
            return {
                hasImage: false,
                image: null
            }
        },

        computed:({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption'
            })
        }),

        watch:{
            loader () {
                const l = this.loader
                this[l] = !this[l]

                setTimeout(() => (this[l] = false), 3000)

                this.loader = null
            }
        },

        created() {

        },

        methods: {
            setImage: function (output) {
                this.hasImage = true
                this.image = output
                console.log(this.image)
                console.log(typeof this.image)

                let formData = new FormData()
                formData.append('file', this.image)

                axios.post('/api/uploadfiles', formData).then((response)=>{
                    console.log(response);
                })
            },

            startImageResize() {
                console.log('image upload');
            },

            endImageResize() {
                console.log('image resize end');
            }
        }


    }
</script>

<style>
    #fileInput {
        display: none;
    }

    h1,
    h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }

    .my-8 {
        margin-top: 4rem;
        margin-bottom: 4rem;
    }
</style>

