<template>
  <div
    class="
      mt-2
      mx-2
      h-7
      border-solid border-slate-700 border-y
      rounded-lg
      border-r
      overflow-hidden
    "
  >
    <span class=""
      ><img
        src="199/images/icon01.png"
        class="float-left w-9 h-auto mr-2"
        alt="公告"
      />
    </span>
    <seamless
      :class-option="classOption"
      class="overflow-hidden m-0"
    >
      <ul>
        <li v-for="(list,key) in listData" :key="key"
          class="
            text-yellow-300 text-xs
            float-left
            leading-6
            h-6
      
          "
        >
          {{ list }}
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
  props: ['announce'],
  mounted() {
    this.listData = this.announce.announcement
  },
  data() {
    return {
      listData: [],
      classOption: {
        direction: 2,
        step: 0.5,
        autoPlay : true,
        limitMoveNum : 0,
      },
    };
  },
};
</script>