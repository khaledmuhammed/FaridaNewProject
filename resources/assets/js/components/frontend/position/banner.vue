<template>
    <div>
        <div :class="`banner col-sm-${banner.size} no-padding ${banner.size === 12 ? 'no-padding':''}`" ref="banner"
             :style="{height:bannerH+'px'}">
            <transition name="fade">
                <div v-if="images.length>0" v-for="number in [currentImage]" :key="Math.random()*100">
                    <a :href="images[Math.abs(currentImage) % images.length].custom_properties.link" target="_blank"
                       :key="images[Math.abs(currentImage) % images.length].id * 6" v-if="bannerH">

                        <!-- <img :key="number*3"
                             :src="`/storage/${images[Math.abs(currentImage) % images.length].id}/${images[Math.abs(currentImage) % images.length].file_name}`"
                             class=""> -->

                        <img :key="number*3"
                             :src="`${images[Math.abs(currentImage) % images.length].url}`"
                             class="">
                    </a>
                </div>
            </transition>
        </div>
        <div class="clearfix"></div>
    </div>
</template>

<script>
    export default {
        props  : ['positionable'],
        data() {
            return {
                images      : [],
                currentImage: 0,
                timer       : null,
                banner      : [],
                bannerH     : false
            }
        },
        ready() {
        },
        mounted() {
            axios.get('/positionables/banner/' + this.positionable.positionable_id).then(res => {
                this.banner = res.data
                if (res.data.media) {
                    res.data.media.forEach(image => {
                        this.images.push(image)
                    })
                }
                // console.log(res.data);
                if (this.images.length) {
                    this.startRotation();
                }
            })
            // console.log('Component mounted.')
        },
        methods: {
            startRotation: function () {
                // console.log(this.images.length);
                if (this.images.length === 1) {
                    this.next()
                } else {
                    this.timer = setInterval(this.next, 3000);
                }
            },

            stopRotation: function () {
                clearTimeout(this.timer);
                this.timer = null;
            },

            next: function () {
                this.currentImage++
                let imgWidth  = this.images[Math.abs(this.currentImage) % this.images.length].custom_properties.width
                let imgHeight = this.images[Math.abs(this.currentImage) % this.images.length].custom_properties.height

                let bannerW  = this.$refs.banner.clientWidth
                this.bannerH = imgHeight
                if (imgWidth > bannerW) {
                    let percent  = bannerW / imgWidth
                    this.bannerH = imgHeight * percent
                    // console.log(this.bannerH);
                }

            },
            prev: function () {
                this.currentImage -= 1
            }

        }
    }
</script>
<style scoped lang="sass">
    .banner
        margin : 0 0 10px 0
        position : relative
        
        a
            position : absolute
            height : 100%
            z-index : 1
            width : 100%
            text-align : center
            img
                max-width : 100%
                object-fit : contain


</style>