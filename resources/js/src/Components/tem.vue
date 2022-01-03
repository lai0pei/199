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
          <div class="modal-container rounded-lg">
            <div class="modal-header rounded-md">
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
                <ul>
                  <li>
                    <div>
                      <input
                        placeholder="会员账号"
                        class="allForms rounded-md"
                        v-model="username"
                      />
                    </div>
                  </li>
                  <li v-for="(form, index) in formList" :key="index">
                    <div v-if="form.type == 0">
                      <input
                        v-bind:placeholder="form.name"
                        alt="输入"
                        class="allForms mt-1 rounded-md"
                        v-model="formName.inputForm[form.id]"
                      />
                    </div>
                    <div v-if="form.type == 1">
                      <input
                        type="number"
                        v-bind:placeholder="form.name"
                        alt="数字"
                        class="allForms mt-1 rounded-md"
                        v-model="formName.numberForm[form.id]"
                      />
                    </div>
                    <div v-if="form.type == 2">
                      <input
                        type="number"
                        v-bind:placeholder="form.name"
                        alt="手机"
                        class="allForms mt-1 rounded-md"
                        v-model="formName.phoneForm[form.id]"
                      />
                    </div>
                    <div v-if="form.type == 3">
                      <input
                        type="number"
                        v-bind:placeholder="form.name"
                        alt="时间"
                        class="allForms mt-1 rounded-md"
                        v-model="formName.timeForm[form.id]"
                      />
                    </div>
                    <div v-if="form.type == 4">
                      <vue-core-image-upload
                        :class="['btn', 'btn-primary']"
                        :crop="false"
                        @imageuploaded="imageuploaded"
                        inputOfFile="applyUser"
                        :max-file-size="5242880"
                        inputAccept="image/*"
                        :text="form.name"
                        :data-uploadId="form.id"
                        v-model="formName.photoForm[form.id]"
                        url="uploadImage"
                        class="allForms mt-1 rounded-md"
                      >
                      </vue-core-image-upload>
                      <span v-if="imageReady "><img :src="imagePreview" alt="用户申请图片"  class="rounded-md mt-1"></span>
                    </div>
                    <div v-if="form.type == 5">
                      <select
                        class="allForms mt-1 rounded-md"
                        v-model="formName.selectForm[form.id]"
                      >
                        <option selected :value="form.name">
                          {{ form.name }}
                        </option>
                        <option
                          v-for="(data, index2) in form.option"
                          :key="index2"
                        >
                          {{ data }}
                        </option>
                      </select>
                    </div>
                  </li>
                </ul>
                <div class="text-center mt-4">
                  <span class="float-left"
                    ><button
                      v-on:click="showModal = false"
                      class="btnSubmit bg-eventBtn block m-auto"
                    >
                      取消
                    </button></span
                  >
                  <span class="float-right"
                    ><button
                      v-on:click="submit"
                      class="btnSubmit bg-eventBtn block m-auto"
                    >
                      点击申请
                    </button></span
                  >
                </div>
              </slot>
            </div>
            <div class="modal-footer">
              <slot name="footer">
                <br />
              </slot>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<style scoped>
.allForms {
  padding: 0 0.7rem;
  width: 100%;
  height: 2rem;
  color: #fff;
  font-size: 0.8rem;
  border: 1px solid #000;
  background: #000;
  box-sizing: border-box;
}
::placeholder {
  color: white;
}
.btnSubmit {
  width: 6.2rem;
  background-size: 6.2rem;
}
.g-core-image-upload-btn{
  padding-top : 0.3rem;
}
</style>

<script>
import axios from 'axios';
import VueCoreImageUpload from 'vue-core-image-upload';

export default {
  components: {
    VueCoreImageUpload,
  },
  props: {passedEventList: Array, imageID: Number},
  data() {
    return {
      showModal: false,
      eventType: [],
      eventTypeId: 0, // init index
      cEventList: [],
      eventId: '',
      apply: [],
      formList: [],
      formName: {
        inputForm: [],
        numberForm: [],
        phoneForm: [],
        timeForm: [],
        photoForm: [],
        selectForm: [],
      },
      username: '',
      limit: 2,
      isPreview: false,
      type: 2,
      imageReady: false,
      imagePreview: '',
      imageUrl: '',
      uploadId: '',

    };
  },
  mounted() {
    this.makeEventList();
    const eventId = localStorage.getItem('eventId');
    if (eventId !== null && typeof eventId == Number) {
      this.eventTypeId = eventId;
    }

    this.selectEvent(this.eventTypeId);
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
      this.clearForm();
      this.eventId = data.id;
      let form = [];
      await axios
          .post(route('get_index_form'), {
            event_id: data.id,
          })
          .then(function(response) {
            form = response.data.data;
          })
          .catch(function(error) {
            console.error(error);
          });

      if (form.length != 0) {
        this.formList = form;
      }
    },
    clearForm: function() {
      this.formList = [];
      this.imagePreview = false;
      this.imageReady = '';
    },
    submit: async function() {
      this.showModal = false;
      console.log(this.formName);
      if (this.username == '') {
        this.$toast('请填写会员账号');
      }
      const that = this;
      await axios.post(route('apply_form'), {
        eventId: this.eventId,
        username: this.username,
        form: this.formName,
        imageUrl: this.imageUrl,

      }).then(function(response) {
        that.$toast(response.data.msg);
      }).catch(function(error) {
        that.$toast('申请有误');
      });
    },
    imageuploaded: function(response) {
      console.log('upload', this.$el );

      if (response.code == 1) {
        this.imageReady = true;
        this.imagePreview = response.data.src;
        this.$toast('上传成功');
      } else {
        this.$toast('上传失败');
      }
    },

  },
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
  transition: opacity 0.5s ease;
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
  background-color: #232323;
  overflow: auto;
}

.modal-header {
  background-color: #191919;
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
  opacity: 0.5s;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(2.1);
  transform: scale(2.1);
}
</style>
