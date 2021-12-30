<template>
  <div class="relative">
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
    <div class="relative">
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
              /><span class="text-neutral-400 text-xs float-right"
                >活动规则</span
              ></span
            >
          </div>
        </li>
      </ul>
    </div>
    <transition name="modal" v-if="showModal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-container bg-slate-700 rounded-lg">
            <div class="modal-header bg-slate-800 rounded-md">
              <slot name="header">
                <div>
                  <img
                    src="199/images/img01.png"
                    alt="左边图标"
                    class="float-left ml-14 mt-2.5 w-5"
                  /><span class="text-amber-400 text-xl ml-1">优惠申请</span
                  ><img
                    src="199/images/img02.png"
                    alt="右边图标"
                    class="float-right w-5 mr-14 mt-2.5"
                  />
                </div>
              </slot>
            </div>

            <div class="modal-body">
              <slot name="body">
                <div v-if="1">
                  <input v-model="message" placeholder="会员账号" id="in" class="userId rounded-md" />
                </div>
                <div v-if="1">
                  <select v-model="selected" id="sel" class="userSelect mt-1 rounded-md" aria-placeholder="选择申请金额">
                    <option selected value="">选择申请金额</option>
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                  </select>
                </div>
                <div v-if="1">
                  <input v-model="message" type="number" placeholder="输入框" class="numberSelect mt-1 rounded-md " />
                </div>
                <div v-if="1">
                   <input v-model="message" type="number" placeholder="输入框" class="numberSelect mt-1 rounded-md " />
                   <image src=""/>
                </div>
              </slot>
            </div>
            <div class="text-center"> 
                 <span><img class="w-28 text-center" src="199/images/btn_bg.png" alt="点击申请">点击申请</span>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
.userId, .userSelect, .numberSelect{
   padding: 0 0.2rem;
    width: 100%;
    height : 2rem;
    color: #fff;
    font-size: 0.8rem;
    font-weight: bold;
    border: 1px solid #000;
    background: #000;
    box-sizing: border-box;
} 
 ::placeholder{
   color: white;
 }  
</style>

<script>


export default {
  components: {
  
  },
  props: { passedEventList: Array },
  data() {
    return {
      showModal: false,
      eventType: [],
      eventTypeId: 0, //init index
      cEventList: [],
      apply: [],
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
    getDialog: function (data) {
      this.showModal = true;
    },
     handleCancel() {
      this.showDatePicker = false;
    },
    handleConfirm(item) {
      this.selectedDate = item;
      this.showDatePicker = false;
    },
    disableDate(item) {
      if (
        new Date(item) - new Date("2019-8-10") >= 0 &&
        new Date("2019-8-20") - new Date(item) >= 0
      ) {
        return true;
      }
      return false;
    },
  },
  computed: {},
};
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 30px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>