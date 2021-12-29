<template>
  <div class="relative">
    <div class="rounded-lg bg-slate-800 mt-2 mx-2">
      <div class="overflow-auto whitespace-nowrap">
        <a
          class="text-stone-600 text-center p-2 inline-block rounded-md"
          v-for="(item, index) in eventType"
          :key="index"
          :class="{ 'bg-eventBg': eventTypeId == index }"
          ><span v-on:click="selectEvent(index)">{{ item.name }}</span></a
        >
      </div>
    </div>
    <div class="relative">
      <ul>
        <li v-for="(list, index) in cEventList" :key="index">
          <div class="mx-2 mt-2 mb-10">
            <img :src="list.type_pic" alt="图片" class="rounded-md w-full" />
            <a class="float-left w-20 mt-2 ml-2" v-on:click="getDialog(list)"
              ><img src="/199/images/btn01.png" alt="点击按钮"
            /></a>
            <span class="float-right mt-2 mr-2"
              ><img
                src="/199/images/icon02.png"
                alt="申请详情"
                class="w-4 float-left mr-1"
              /><span class="text-neutral-400 text-xs float-right"
                >活动规则</span
              ></span
            >
          </div>
        </li>
      </ul>
    </div>
    <div>
      <transition v-if="showModel" class="showModel">
        <div class="container fixed top-0 rounded-lg bg-white ">
          <div class="bg-slate-900">
            <div>
              <img src="199/images/img01.png" alt="左边图标"  class="float-left w-8 ml-10 mt-2"/><span class="text-amber-400 text-xl ml-3">优惠申请</span><img src="199/images/img02.png" alt="右边图标"
                class="float-right w-8 mr-10 mt-2"
              />
            </div>
          </div>
          <div><label for="jack">Jack</label>
            <input type="checkbox" id="john" value="John"></div>
        </div>
      </transition>
    </div>
  </div>
</template>
<style scoped>
.container{
    width : 80%;
    left : 10%;
}
</style>
<script>
export default {
  props: { passedEventList: Array },
  data() {
    return {
      eventType: [],
      eventTypeId: 0, //init index
      cEventList: [],
      apply: [],
      showModel: false,
    };
  },
  mounted() {
    this.makeEventList();
    let eventId = localStorage.eventId;
    if (eventId !== null && typeof eventId == Number) {
      this.eventTypeId = eventId;
    }
    this.selectEvent(this.eventTypeId);
  },
  methods: {
    selectEvent: function (eventId) {
      localStorage.removeItem("eventId");
      localStorage.eventId = eventId;
      this.eventTypeId = eventId;
      this.assignEventList(eventId);
    },
    assignEventList: function (eventId) {
      this.cEventList = [];

      this.passedEventList.forEach((data) => {
        if (data.type_id == eventId) {
          data.event.forEach((subData) => {
            if (Object.keys(subData).length !== 0) {
              this.cEventList.push(subData);
            }
          });
        }
      });
    },
    makeEventList: function () {
      this.passedEventList.forEach((data) => {
        this.eventType.push({ id: data.type_id, name: data.name });
      });
    },
    getDialog: function (data) {
      this.showModel = true;
      this.apply = data;
    },
  },
  computed: {},
};
</script>
