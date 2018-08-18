<template>
    <div>
        <slot/>
    </div>
</template>

<script>
    let Siema, timmer;
    // ssr / nuxt only in browser import
    if (process.browser) {
        Siema = require('siema')
    }
    export default {
        props: {
            options: {
                type: Object,
                default() {
                    return {}
                }
            },
            autoPlay: {
                type: Boolean,
                default: false
            },
            playDuration: {
                type: Number,
                default: 6000
            },
            current: {
                type: Number,
                default: 0
            }
        },
        data() {
            return {
                playing: this.autoPlay,
                time: this.playDuration
            }
        },
        mounted() {
            this.init()
        },
        beforeDestroy() {
            if (this.playing) clearInterval(timmer);
            this.siema.destroy()
        },
        methods: {
            init() {
                // get the current selector
                this.options.selector = this.$el;
                // fix timmer if drag or next/prev/goto TODO improve
                this.options.onChange = () => {
                    // reset timmer
                    if (this.playing) this.reset();
                    // update parent "current" slide with .sync
                    // https://vuejs.org/v2/guide/components.html#sync-Modifier
                    this.$emit('update:current', this.siema.currentSlide)
                };
                // let's start
                this.siema = new Siema(this.options)
                // check for autoplay
                if (this.playing) this.playInit(this.playDuration)
            },
            // Basic wrap...
            prev(slide, callback) {
                this.siema.prev(slide, callback)
            },
            next(slide, callback) {
                this.siema.next(slide, callback)
            },
            goTo(index, callback) {
                this.siema.goTo(index, callback)
            },
            remove(index, callback) {
                this.siema.remove(index, callback)
            },
            insert(item, index, callback) {
                this.siema.insert(item, index, callback)
            },
            prepend(item, callback) {
                this.siema.prepend(item, callback)
            },
            append(item, callback) {
                this.siema.append(item, callback)
            },
            resizeHandler() {
                this.siema.resizeHandler()
            },
            // start autoplay width and without props
            playInit(time = 6000) {
                this.playing = true;
                this.time = time;
                timmer = setInterval(() => {
                    this.siema.next()
                }, time)
            },
            stop() {
                this.playing = false;
                clearInterval(timmer)
            },
            play() {
                this.playing = true;
                this.reset()
            },
            reset() {
                if (this.playing) {
                    clearInterval(timmer);
                    timmer = setInterval(() => {
                        this.siema.next()
                    }, this.time)
                }
            }
        }
    }
</script>