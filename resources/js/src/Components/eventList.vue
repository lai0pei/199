<template>
  <div class="relative pb-16">
    <div class="rounded-lg bg-zinc-800 mt-2 mx-2">
      <div class="overflow-auto whitespace-nowrap">
        <a
          class="text-gray-400 text-center p-2 inline-block rounded-md"
          v-for="(item, index) in eventType"
          :key="index"
          :class="{
            'bg-eventBg': eventTypeId == index,
            'text-black': eventTypeId == index,
          }"
          ><span v-on:click="selectEvent(index)">{{ item.name }}</span></a
        >
      </div>
    </div>
    <div>
      <ul>
        <li v-for="(list, index) in cEventList" :key="index">
          <div class="mx-2 mt-2 mb-10">
            <div v-if="'' == list.external_url">
              <img :src="list.type_pic" alt="图片" class="rounded-md w-full" />
            </div>
            <div v-else>
              <a :href="list.external_url"
                ><img :src="list.type_pic" alt="图片" class="rounded-md w-full"
              /></a>
            </div>
            <a class="float-left w-20 mt-2 ml-2" v-on:click="getDialog(list)"
              ><img src="/199/images/btn01.png" alt="点击按钮"
            /></a>
            <span class="float-right mt-2 mr-2"
              ><img
                src="/199/images/icon02.png"
                alt="申请详情"
                class="w-4 float-left mr-1"
              /><span class="text-neutral-400 text-xs float-right" @click="detail(list)"
                >活动规则</span
              ></span
            >
          </div>
        </li>
      </ul>
    </div>
       <applyDialog
            v-if="showModal"
            :childProp="formList"
            v-on:fromApplyDialog="showModal = false"
          ></applyDialog>
  </div>
</template>



<script>
import axios from "axios";
import applyDialog from "./applyDialog";

export default {
  components: {
    applyDialog,
  },
  props: { passedEventList: Array },
  data() {
    return {
      showModal: false,
      eventType: [],
      eventTypeId: 0, //init index
      cEventList: [],
      eventId: "",
      gameList : [],
      formList : {
        'event_id' : [],
        'formData' : [],
        'need_sms' : [],
        'game_list' : [],
        'is_sms' : [],
      },
    };
  },
  mounted() {
    this.makeEventList();
    let eventId = localStorage.getItem("eventId");
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
    assignEventList: function (index) {
      this.cEventList = [];
      let eventData = this.passedEventList[index];

      if (
        undefined !== eventData &&
        Object.keys(eventData["event"]).length !== 0
      ) {
        this.cEventList = Object.values(eventData["event"]);
      }
    },
    makeEventList: function () {
      this.passedEventList.forEach((data) => {
        this.eventType.push({ id: data.type_id, name: data.name });
      });
    },
    getDialog: async function (data) {
      this.showModal = true;
      let form = [];
      await axios
        .post(route("get_index_form"), {
          event_id: data.id,
        })
        .then(function (response) {
          form = response.data.data;
        })
        .catch(function (error) {
          console.error(error);
        });
      this.formList.formData = form;
      this.formList.event_id = data.id;
      this.formList.need_sms = data.need_sms;
      this.formList.game_list = this.eventType;
      this.formList.is_sms = data.is_sms;
   
    },
    fromApplyDialog: function () {
      this.showModal = false;
    },
    detail : function(data){
     this.$inertia.get(route('detail'), {'event_id' : data.id});
    }
  },
};
</script>
