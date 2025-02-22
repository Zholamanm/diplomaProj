<template>
    <carousel :items-to-show="1" :autoplay="5000" :wrap-around="true">
        <slide v-for="image in data" :key="image.id">
            <a :href="image.href">
                <img alt="" style="max-width: 204px;border-radius: 10px" :src="image.src">
            </a>
        </slide>

        <template #addons>
            <!--            <navigation/>-->
            <pagination/>
        </template>
    </carousel>
</template>

<script>
import {Carousel, Slide, Pagination, Navigation} from 'vue3-carousel';

export default {
    name: "UiCarousel",
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    props: {
        data: Array
    }
};
</script>

<style>
.carousel__pagination-button::after {
    width: 5px !important;
    height: 5px !important;
    border-radius: 50%;
}
</style>
