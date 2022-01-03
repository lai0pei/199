<template>
  <div class="mx-2">
    <Swiper
      :slides-per-view="1"
      loop   :autoplay= 3000
      pagination-visible
      class="rounded-md"
    >
      <div v-for="item in photo" :key="item">
        <img :src="item" alt="轮播图" class="w-full " />
      </div>
    </Swiper>
  </div>
</template>

<script>
import {Swiper} from 'vue2-swiper';


export default {
  components: {
    Swiper,
  },
  data() {
    return {
      photo: [
        '199/images/banner01.jpg',
        '199/images/banner02.png',
        '199/images/banner03.png',
        '199/images/banner04.png',
        '199/images/banner05.png',
      ],
    };
  },
  setup() {
    const onSwiper = (swiper) => {
      console.log(swiper);
    };
    const onSlideChange = () => {
      console.log('slide change');
    };
    return {
      onSwiper,
      onSlideChange,
      modules: [Pagination, Autoplay],
    };
  },
};
</script>

<style scoped>
</style>
