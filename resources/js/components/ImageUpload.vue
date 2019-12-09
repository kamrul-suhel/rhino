<template>
    <v-layout row wrap>
        <image-uploader
            :preview="preview"
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
                <v-icon right>cloud_upload</v-icon>

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
        props: {
            preview: {
                type: Boolean,
                default: true
            },

            multiple: {
                type: Boolean,
                default: false
            },

            model: {
                type: String,
                required: true
            },
            identifier: {
                type: String,
                required: false
            },
        },
        data() {
            return {
                image: null
            }
        },

        computed: ({
            ...mapGetters({
                trans: 'getFields',
                themeOption: 'getThemeOption',
                hasImage: 'getHasImage'
            })
        }),

        watch: {
            loader() {
                const l = this.loader
                this[l] = !this[l]

                setTimeout(() => (this[l] = false), 3000)

                this.loader = null
            }
        },

        created() {

            console.log(this.identifier)

        },

        methods: {
            setImage: function (output) {

                console.log(this.identifier)
                return
                this.image = output
                console.log(this.image)
                console.log(typeof this.image)

                let formData = new FormData()
                formData.append('file', this.image)
                formData.append('model', this.model)

                axios.post('/api/uploadfiles', formData).then((response) => {
                    this.$store.commit('setHasImage', true)
                    
                    console.log(this.identifier);
                    if(this.identifier == 'leftImage'){
                        this.$store.commit('setIdentifier', this.identifier)
                        this.$store.commit('setImage', response.data)
                    }else{
                        this.$store.commit('setIdentifier2', this.identifier)
                        this.$store.commit('setImage2', response.data)
                    }
                })
            },

            startImageResize() {
                console.log('image upload');
            },

            endImageResize() {
                console.log('image resize end');
            }
        },

        destroyed() {
            this.$store.commit('resetImageUpload')
        }
    }
</script>

