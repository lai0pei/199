<template>
    <div w-full>
    <Swiper 
    :slides-per-view="4"
    :space-between="50">
    <Swiper-slide v-for="item in photo" :key="item">
    <img src="item.photo">
    </Swiper-slide>
    </Swiper>
    </div>
</template>

<script> 
import {Swiper, SwiperSlide} from 'swiper/vue';
export default{
    components : {
        Swiper,
        SwiperSlide,
    },
 data(){
     return {
         "photo" : [
             "link1",
             "link2",
             "link3",
             "link4",
         ]
     }
 }
}
</script>