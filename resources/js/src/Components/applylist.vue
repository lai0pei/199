<template>
  <div class="mt-2 mx-2">
    <seamless
      :data="listData"
      class="
        seamless-warp
        bg-repeat-round
        center
        bg-applyImage
        h-24
        overflow-hidden
      "
      :class-option="classOption"
    >
      <ul>
        <li v-for="(item, key) in listData" :key="key" class="ml-8">
          <span class="text-yellow-600 text-xs">恭喜</span
          ><span class="text-zinc-500 text-xs pl-2">{{ item.username }}</span
          ><span class="text-red-500 text-xs pl-2">成功办理</span
          ><span class="text-white text-xs pl-2 ">{{ item.event }}</span>
        </li>
      </ul>
    </seamless>
  </div>
</template>

<script>
import seamless from 'vue-seamless-scroll';
export default {
  props: ['userApplyList'],
  components: {
    seamless,
  },
  mounted() {
    this.listData = this.userApplyList;
  },
  data() {
    return {
      listData: [],
      classOption: {
        step: 0.25,
        autoPlay: true,
        openTouch: true,
        limitMoveNum: 0,
      },
    };
  },
};
</script>
