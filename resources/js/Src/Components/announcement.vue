<template>
  <div class="mt-2 mx-2 h-6 border-solid border-slate-700 border-y rounded-lg border-r">
    <span class=""
      ><img
        src="199/images/icon01.png"
        class="float-left w-9 h-6 mr-2"
        alt="公告"
      />
    </span>
    <seamless
      :data="listData"
      :class-option="classOption"
      class="overflow-hidden"
    >
      <ul>
        <li
          v-for="item in listData"
          :key="item.title"
          class="text-yellow-300 text-xs float-left text-center leading-6 h-6"
        >
          {{ item.title }}
        </li>
      </ul>
    </seamless>
  </div>
</template>


</style>
<script>
import seamless from "vue-seamless-scroll";
export default {
  components: {
    seamless,
  },
  data() {
    return {
      listData: [
        {
          title:
            "因申请人数较多，因申请人数较多因申请人数多 多，因申请人数较多因申请人数多，因申请人数较多因申请人数多，因申请人数较多因申请人数！",
        },
      ],
      classOption: {
        direction: 2,
        autoPlay: true,
        step: 0.5,
      },
    };
  },
};
</script>