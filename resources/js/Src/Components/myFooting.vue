<template>
  <div class="fixed w-full bottom-0">
  <nav class="content-center">
    <ul class="grid grid-cols-4 h-16 text-center bg-black">
      <li v-for="nav in list" :key="nav.id">
        <a :href="nav.href" class="text-white text-xs block pt-2"><span><img :src="nav.icon" alt="底部图标" class="w-8 h-8 mx-auto"></span>{{ nav.name }}</a>
      </li>
    </ul>
  </nav>
  </div>
</template>

<script>
export default {
  name: "myFooding",
  data() {
    return {
      list: [
        {
          id: 0,
          name: "首页",
          icon: "199/images/f_img01.png",
          href: "/",
        },{
          id: 1,
          name: "下载新版APP",
          icon: "199/images/f_img02.png",
          href: "/",
        },{
          id: 2,
          name: "线路检查",
          icon: "199/images/f_img03.png",
          href: "/",
        },{
          id: 3,
          name: "在线客服",
          icon: "199/images/f_img04.png",
          href: "https://chatlink-new.meiqia.cn/widget/standalone.html?eid=3afd4a2a5cb3911ad15498b01d38c014",
        },
      ],
    };
  },
  mounted(){
      console.log(route('index_nav'));
    //   this.getLink();
  },
  methods:{
      getLink : function(){
            axios.post(route('index_nav')).then(response => (console.log(response)))
      }
  }
};
</script>