<template>
  <div class="w-full bottom-0  mt-2 fixed">
  <nav class="content-center max-w-screen-sm">
    <ul class="grid grid-cols-4 h-16 text-center bg-black">
      <li>
        <a :href="list.home" class="text-white text-xs block pt-2 rounded-md"><span><img src="199/images/f_img01.png" alt="首页图标" class="w-8 h-8 mx-auto"></span>首页</a>
      </li>
      <li>
        <a :href="list.app" class="text-white text-xs block pt-2 rounded-md"><span><img src="199/images/f_img02.png" alt="app图标" class="w-8 h-8 mx-auto"></span>下载新版APP</a>
      </li>
      <li>
        <a :href="list.speed" class="text-white text-xs block pt-2 rounded-md"><span><img src="199/images/f_img03.png" alt="路由图标" class="w-8 h-8 mx-auto"></span>线路检查</a>
      </li>
      <li>
        <a :href="list.chat" class="text-white text-xs block pt-2 rounded-md"><span><img src="199/images/f_img04.png" alt="在线图标" class="w-8 h-8 mx-auto"></span>在线客服</a>
      </li>
    </ul>
  </nav>
  </div>
</template>

<script>
export default {
  name: "myFooding",
  props : ['footer'],
  data() {
    return {
      list: [],
    };
  },
  mounted(){
    this.list = this.footer;
  },
};
</script>