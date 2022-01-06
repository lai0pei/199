<template>
  <div class="mx-2">
    <Swipe
      :autoplay="3000" indicator-color="white" initial-swipe=0 loop:true
      class="rounded-md my-swipe"
    >
      <swipe-item v-if="wallpaper['1Wall']">

        <span v-if="wallpaper['1Url']"><a :href="wallpaper['1Url']"><img :src="wallpaper['1Wall']" alt="轮播图1" class="w-full" /></a></span>

        <span v-else><a><img :src="wallpaper['1Wall']" alt="轮播图1" class="w-full" /></a></span>

      </swipe-item>


      <swipe-item v-if="wallpaper['2Wall']">

        <span v-if="wallpaper['2Url']"><a :href="wallpaper['2Url']"><img :src="wallpaper['2Wall']" alt="轮播图2" class="w-full" /></a></span>

        <span v-else><a><img :src="wallpaper['2Wall']" alt="轮播图2" class="w-full" /></a></span>

      </swipe-item>

      <swipe-item v-if="wallpaper['3Wall']">

       <span v-if="wallpaper['3Url']"><a :href="wallpaper['3Url']"><img :src="wallpaper['3Wall']" alt="轮播图3" class="w-full" /></a></span>

        <span v-else><a><img :src="wallpaper['3Wall']" alt="轮播图3" class="w-full" /></a></span>

      </swipe-item>

      <swipe-item v-if="wallpaper['4Wall']">

       <span v-if="wallpaper['4Url']"><a :href="wallpaper['4Url']"><img :src="wallpaper['4Wall']" alt="轮播图4" class="w-full" /></a></span>

        <span v-else><a><img :src="wallpaper['4Wall']" alt="轮播图4" class="w-full" /></a></span>

      </swipe-item>

      <swipe-item v-if="wallpaper['5Wall']">

         <span v-if="wallpaper['5Url']"><a :href="wallpaper['5Url']"><img :src="wallpaper['5Wall']" alt="轮播图5" class="w-full" /></a></span>

        <span v-else><a><img :src="wallpaper['5Wall']" alt="轮播图5" class="w-full" /></a></span>

      </swipe-item>

      <swipe-item v-if="wallpaper['6Wall']">

          <span v-if="wallpaper['6Url']"><a :href="wallpaper['6Url']"><img :src="wallpaper['6Wall']" alt="轮播图6" class="w-full" /></a></span>

        <span v-else><a><img :src="wallpaper['6Wall']" alt="轮播图6" class="w-full" /></a></span>
        
      </swipe-item>
    </Swipe>
  </div>
</template>

<script>
import {Swipe, SwipeItem} from "vant";

export default {
  props: ["wallpaper"],
  components: {
    Swipe,
    SwipeItem,
  },
  setup() {
    return {
      modules: [Pagination, Autoplay],
    };
  },
};
</script>

<style scoped>
  .my-swipe .swipe-item {
    color: #fff;
    font-size: 20px;
    line-height: 150px;
    text-align: center;
    background-color: #39a9ed;
  }
</style>
