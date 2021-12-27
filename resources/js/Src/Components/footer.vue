<template>
  <div class="fixed w-full bottom-0">
  <nav class="content-center">
    <ul class="grid grid-cols-4 text-center">
      <li v-for="nav in list" :key="nav.id">
        <a href="nav.href"><span><img src="nav.icon" alt="底部图标"></span>{{ nav.name }}</a>
      </li>
    </ul>
  </nav>
  </div>
</template>

<script>
export default {
  name: "footer",
  data() {
    return {
      list: [
        {
          id: 0,
          name: "nav1",
          icon: "i1",
          href: "link1",
        },{
          id: 1,
          name: "nav2",
          icon: "i2",
          href: "link2",
        },{
          id: 2,
          name: "nav3",
          icon: "i3",
          href: "link3",
        },{
          id: 3,
          name: "nav4",
          icon: "i4",
          href: "link4",
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