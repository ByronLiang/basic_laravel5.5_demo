<template>
    <div class="mt-8">
        <hr>
        <h1>截图删除</h1>
        <input type="file" name="image" accept="image/*"
               style="font-size: 1.2em; padding: 10px 0;"
               @change="setImage"/>
        <br/>
        <div style="width: 400px; height:300px; border: 1px solid gray; display: inline-block;">
            <vue-cropper
                    ref='cropper'
                    :guides="true"
                    :view-mode="2"
                    drag-mode="crop"
                    :auto-crop-area="0.5"
                    :min-container-width="250"
                    :min-container-height="180"
                    :background="true"
                    :rotatable="true"
                    :src="imgSrc"
                    alt="Source Image"
                    :img-style="{ 'width': '400px', 'height': '300px' }">
            </vue-cropper>
        </div>
        <img :src="cropImg" style="width: 200px; height: 150px; border: 1px solid gray" alt="Cropped Image"/>
        <br/>
        <br/>

        <button @click="cropImage" v-if="imgSrc != ''" style="margin-right: 40px;">Crop</button>
        <button @click="rotate" v-if="imgSrc != ''">Rotate</button>
        <button @click="upload" v-if="imgSrc != ''">upload</button>

    </div>
</template>

<script>
import VueCropper from 'common/components/cropper';
// import FileUpload from 'admin/api/fileUpload';

export default {
    components: {
        VueCropper,
    },
    data() {
        return {
            imgSrc: '',
            cropImg: '',
        };
    },
    methods: {
        setImage(e) {
            const file = e.target.files[0];
            if (!file.type.includes('image/')) {
                alert('Please select an image file');
                return;
            }
            if (typeof FileReader === 'function') {
                const reader = new FileReader();
                reader.onload = (event) => {
                    this.imgSrc = event.target.result;
                    // rebuild cropperjs with the updated source
                    this.$refs.cropper.replace(event.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                alert('Sorry, FileReader API not supported');
            }
        },
        cropImage() {
            // get image data for post processing, e.g. upload or setting image src
            this.cropImg = this.$refs.cropper.getCroppedCanvas().toDataURL();
        },
        upload() {
            // this.$refs.cropper.getCroppedCanvas().toBlob((blob) => {
            // console.log(blob);
            // (new FileUpload()).uploadFile(blob);
            // });
        },
        rotate() {
            // guess what this does :)
            this.$refs.cropper.rotate(90);
        },
    },
};
</script>
