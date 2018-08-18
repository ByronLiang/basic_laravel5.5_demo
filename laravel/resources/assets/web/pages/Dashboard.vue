<template>
    <div class="dashboard">
        <div style="margin-top: 10px;">
            <el-carousel :interval="4000" type="card"
                height="200px" :autoplay="false">
                <el-carousel-item v-for="(item, index) in banner" :key="index">
                    <img :src="item.url" height="200px" v-if="item.type == 1">
                    <video :src="item.url" controls="controls" height="200px"
                        v-if="item.type == 3"></video>
                </el-carousel-item>
            </el-carousel>
            <router-link to="/chat_list">
                <el-button type="text">聊天室列表</el-button>
            </router-link>
        </div>
    </div>
</template>

<script>
import {Button, Carousel, CarouselItem,} from 'element-ui';

export default {
    components: {
        ElButton: Button,
        ElCarousel: Carousel,
        ElCarouselItem: CarouselItem,
    },
    data() {
        return {
            banner: [],
            authors: [],
        };
    },
    created() {
        this.fetchData();
    },
    mounted() {
    },
    methods: {
        fetchData() {
            API.get('home').then((r) => {
                this.banner = r.banner;
            })
        },
    },
};
</script>

<style lang="scss">
    .dashboard {
        width: 80%;
        margin: 0 auto;
    }
    .el-carousel__item img {
        margin: 0;
        width: 100%;
    }
    .el-carousel__item video {
        margin: 0;
        width: 100%;
    }

    .el-carousel__item:nth-child(2n) {
        background-color: #99a9bf;
    }

    .el-carousel__item:nth-child(2n+1) {
        background-color: #d3dce6;
    }
    .avatar {
        display: inline-block;
        width: 80px;
        height: 80px;
        padding: 2px;
        margin-right: 10px;
        border-radius: 50%;
        cursor: pointer;
        overflow: hidden;
        vertical-align: middle;
        border: 1px solid #ddd;
    }
    .time {
        font-size: 13px;
        color: #999;
    }
</style>
