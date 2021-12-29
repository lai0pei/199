<template>
  <div class="mt-2 mx-2">
    <seamless
      :data="listData"
      class="
        seamless-warp
        bg-repeat-round
        text-center
        bg-applyImage
        h-24
        overflow-hidden
      "
      :class-option="classOption"
    >
      <ul>
        <li v-for="(item, key) in listData" :key="key">
          <span class="text-yellow-600 text-xs">恭喜</span
          ><span class="text-zinc-500 text-xs pl-2">{{ item.name }}</span
          ><span class="text-red-500 text-xs pl-2">成功办理</span
          ><span class="text-white text-xs pl-2 ">{{ item.event }}</span>
        </li>
      </ul>
    </seamless>
  </div>
</template>

<script>
import seamless from "vue-seamless-scroll";
export default {
  components: {
    seamless,
  },
  data() {
    return {
      listData: [
        { name: "kan*** ", event: "电子注单" },
        { name: "kan***", event: "电子注单" },
        { name: "kan***  ", event: "电子注单" },
        { name: "kan***  ", event: "电子注单" },
        { name: "kan*** ", event: "电子注单" },
        { name: "kan*** ", event: "电子注单" },
      ],
      classOption: {
        step: 0.25,
        autoPlay: true,
        openTouch: true,
      },
    };
  },
};
</script>