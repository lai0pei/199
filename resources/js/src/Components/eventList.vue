<template>
  <div class="relative eventList">
    <van-skeleton :loading="loading" :row="7">
      <div class="rounded-lg mt-2 mx-2 eventTypeBlock">
        <div class="whitespace-nowrap verital" v-dragscroll="true">
          <span
            class="
              text-gray-400 text-center
              p-2
              inline-block
              rounded-md
              hover:bg-eventBg hover:text-black
            "
            v-for="(item, index) in eventType"
            :key="index"
            :class="{
              'bg-eventBg': eventTypeId == index,
              'text-black': eventTypeId == index,
            }"
            v-on:click="selectEvent(index)"
            ><span>{{ item.name }}</span></span
          >
        </div>
      </div>
      <div>
        <ul>
          <li v-for="(list, index) in cEventList" :key="index">
            <div class="mx-2 mt-2">
              <div v-if="'' == list.external_url">
                <img
                  :src="list.type_pic"
                  alt="图片"
                  class="rounded-t-md rounded-x-md w-full"
                />
              </div>
              <div v-else>
                <a :href="list.external_url"
                  ><img
                    :src="list.type_pic"
                    alt="图片"
                    class="rounded-t-md rounded-x-md w-full"
                /></a>
              </div>
              <div class="eventBlock rounded-b-md rounded-x-md pb-2">
                <a
                  class="float-left w-20 mt-2 ml-2"
                  v-on:click="getDialog(list)"
                  ><img src="/199/images/btn01.png" alt="点击按钮"
                /></a>
                <span class="float-right mt-2 mr-2" @click="detail(list)"
                  ><img
                    src="/199/images/icon02.png"
                    alt="申请详情"
                    class="w-5 float-left mr-1"
                  /><span class="text-neutral-400 text-sm float-right"
                    >活动规则</span
                  ></span
                >
              </div>
            </div>
          </li>
        </ul>
      </div>

      <applyDialog
        v-if="showModal"
        :childProp="formList"
        v-on:fromApplyDialog="showModal = false"
      ></applyDialog>
    </van-skeleton>
  </div>
</template>


<script>
import axios from 'axios';
import applyDialog from './applyDialog';
import {dragscroll} from 'vue-dragscroll';

export default {
  directives: {
    dragscroll,
  },
  components: {
    applyDialog,
  },
  props: {passedEventList: Array},
  data() {
    return {
      selectedIndex: 3,
      loading: true,
      showModal: false,
      eventType: [],
      eventTypeId: 0, // init index
      cEventList: [],
      eventId: '',
      gameList: [],
      formList: {
        event_id: [],
        formData: [],
        need_sms: [],
        game_list: [],
        is_sms: [],
        description: [],
      },
    };
  },
  mounted() {
    this.makeEventList();
    const eventId = localStorage.getItem('eventId');
    if (eventId !== null && typeof eventId == Number) {
      this.eventTypeId = eventId;
    }
    this.selectEvent(this.eventTypeId);
    this.selectedIndex = 3;
    this.loading = false;
  },
  methods: {
    selectEvent: function(eventId) {
      localStorage.removeItem('eventId');
      localStorage.eventId = eventId;
      this.eventTypeId = eventId;
      this.assignEventList(eventId);
    },
    assignEventList: function(index) {
      this.cEventList = [];
      const eventData = this.passedEventList[index];

      if (
        undefined !== eventData &&
        Object.keys(eventData['event']).length !== 0
      ) {
        this.cEventList = Object.values(eventData['event']);
      }
    },
    makeEventList: function() {
      this.passedEventList.forEach((data) => {
        this.eventType.push({id: data.type_id, name: data.name});
      });
    },
    getDialog: async function(data) {
      this.showModal = true;
      let form = [];
      let eventType = [];
      let needSms = '';
      let isSms = '';
      let description = '';
      await axios
          .post(route('get_index_form'), {
            event_id: data.id,
          })
          .then(function(response) {
            form = response.data.data.form;
            eventType = response.data.data.type;
            needSms = response.data.data.need_sms;
            isSms = response.data.data.is_sms;
            description = response.data.data.description;
          })
          .catch(function(error) {
            console.error(error);
          });

      this.formList.formData = form;
      this.formList.game_list = eventType;
      this.formList.event_id = data.id;
      this.formList.need_sms = needSms;
      this.formList.is_sms = isSms;
      this.formList.description = description;
    },
    fromApplyDialog: function() {
      this.showModal = false;
    },
    detail: function(data) {
      this.$inertia.get(route('detail'), {event_id: data.id});
    },
  },
};
</script>

<style scoped>
.eventBlock {
  background: rgb(37, 37, 37);
  display: flex;
  justify-content: space-between;
}

.eventTypeBlock {
  background: rgb(37, 37, 37);
}

.verital {
  scrollbar-width: none;
  overflow: auto;
  cursor: pointer;
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Old versions of Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently*/
}

.verital::-webkit-scrollbar {
  display: none;
}
a,
span {
  cursor: pointer;
}
.eventList {
  padding-bottom: 11%;
}
</style>
