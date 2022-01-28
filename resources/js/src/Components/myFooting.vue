<template>
<div>
  <van-tabbar v-model="active" class="bg-black" active-color="#D9C37F"
  inactive-color="#fff" @change="onChange" border>
    <van-tabbar-item class="bg-black" >
      <span>首页</span>
      <template #icon="props">
      <a >
        <img
          :src="props.active ? icon[0].active : icon[0].inactive"
          alt="图片"
        /></a>
      </template>
    </van-tabbar-item>
    <van-tabbar-item class="bg-black">
      <span>下载新版APP</span>
      <template #icon="props">
        <img
          :src="props.active ? icon[1].active : icon[1].inactive"
          alt="图片"
        />
      </template>
    </van-tabbar-item>
    <van-tabbar-item class="bg-black" ><span> 线路检查 </span>
      <template #icon="props">
        <img
          :src="props.active ? icon[2].active : icon[2].inactive"
          alt="图片"
        /> </template
    ></van-tabbar-item>
    <van-tabbar-item class="bg-black">
      <span>在线客服</span>
      <template #icon="props">
        <img
          :src="props.active ? icon[3].active : icon[3].inactive"
          alt="图片"
        /> </template
    ></van-tabbar-item>
  </van-tabbar>
</div>
</template>

<script>
export default {
  name: 'myFooding',
  props: ['footer', 'nActive'],
  data() {
    return {
      active: 0,
      icon: [
        {
          inactive: '199/images/f_img01.png',
          active: '199/images/f_img01_on.png',
        },
        {
          inactive: '199/images/f_img02.png',
          active: '199/images/f_img02_on.png',
        },
        {
          inactive: '199/images/f_img03.png',
          active: '199/images/f_img03_on.png',
        },
        {
          inactive: '199/images/f_img04.png',
          active: '199/images/f_img04_on.png',
        },
      ],
      list: [],

    };
  },
  mounted() {
    this.list = this.footer;
    this.active = this.nActive;
  },
  methods: {
    onChange: function(index) {
      let link = '';
      switch (true) {
        case index === 1: link = this.list.app;
          break;
        case index === 2: link = this.list.speed;
          break;
        case index === 3: link = this.list.chat;
          break;
        default: link = this.list.home;
      }
      console.log('current link', link);

      window.location.replace(link);
    },
  },
};
</script>

<style scoped>
.van-tabbar{
  max-width : 38rem;
}
.van-tabbar-item{
  background : black;
}
.van-tabbar--fixed{
  left : auto;
}
</style>
