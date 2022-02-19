<template>
  <transition name="modal">
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
                /><span class="text-amber-400 text-xl ml-4">优惠申请</span
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
                      type="text"
                      v-bind:placeholder="form.name"
                      alt="时间"
                      class="allForms mt-1 rounded-md"
                      onfocus="(this.type='date')"
                      onblur="(this.type='text')"
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
                      :data="{
                        form_id: form.id,
                      }"
                      url="/uploadImage"
                      class="allForms mt-1 rounded-md"
                    >
                    </vue-core-image-upload>
                    <span v-if="imageReady" :id="form.id"
                      ><img
                        :src="imagePreview"
                        alt="用户申请图片"
                        class="rounded-md mt-1"
                    /></span>
                  </div>
                  <div v-if="form.type == 5">
                    <select
                      class="allForms mt-1 rounded-md"
                      v-model="formName.selectForm[form.id]"
                    >
                      <option disabled>
                        {{ form.name }}
                      </option>
                      <option
                        v-for="(data, index2) in form.option"
                        :key="index2"
                        :value="data"
                      >
                        {{ data }}
                      </option>
                    </select>
                  </div>
                </li>
                <li>
                  <div>
                    <p class="rounded-md mt-1 w-64 description">
                      {{ description }}
                    </p>
                  </div>
                </li>
                <div>
                  <div v-if="isSms == 1">
                    <select
                      class="allForms mt-1 rounded-md"
                      v-model="myGameList"
                    >
                      <option disabled>
                        {{ selectGame }}
                      </option>
                      <option
                        v-for="(game, index) in gameList"
                        :key="index"
                        :value="game.id"
                      >
                        {{ game.name }}
                      </option>
                    </select>
                  </div>
                  <div class="">
                    <van-loading
                      type="spinner"
                      size="26"
                      class="absolute float-right mt-1 mr-12"
                      v-show="showLoading"
                    >
                    </van-loading>
                    <input
                      placeholder="填写验证码"
                      class="captcha rounded-md mt-1 w-36"
                      v-model="userCaptcha"
                    />

                    <img
                      :src="captcha"
                      alt="验证码"
                      v-on:click="getCaptcha"
                      class="float-right rounded-md mt-1"
                      v-show="!showLoading"
                    />
                  </div>
                </div>
                <div v-if="needSms == 1">
                  <div>
                    <input
                      type="number"
                      placeholder="填写手机号"
                      class="allForms rounded-md mt-1 w-40"
                      pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}"
                      v-model="mobileNumber"
                    />
                  </div>
                  <div class="text-white">
                    <input
                      type="number"
                      placeholder="填写短信验证码"
                      class="captcha rounded-md mt-1 w-40"
                      v-model="smsNumber"
                    />
                    <button
                      v-on:click="getMessage()"
                      :disabled="counting"
                      class="getMessage mt-1 rounded-md float-right bg-black"
                    >
                      <van-count-down
                        v-if="counting"
                        :time="timeOut"
                        :auto-start="counting"
                        class="text-white"
                        format="ss 秒"
                        @finish="countFinish"
                      ></van-count-down>
                      <span v-else class="text-xs">{{ messageText }}</span>
                    </button>
                  </div>
                </div>
              </ul>
              <div class="text-center mt-4">
                <span class="float-left"
                  ><button
                    v-on:click="closeDialog"
                    class="btnSubmit bg-eventBtn block m-auto font-bold"
                  >
                    取消
                  </button></span
                >
                <span class="float-right"
                  ><button
                    v-on:click="submit"
                    class="btnSubmit bg-eventBtn block m-auto font-bold"
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
</template>

<script>
import axios from "axios";
import VueCoreImageUpload from "vue-core-image-upload";

export default {
  props: { childProp: Object },
  components: {
    VueCoreImageUpload,
  },
  data() {
    return {
      formList: [],
      formName: {
        inputForm: [],
        numberForm: [],
        phoneForm: [],
        timeForm: [],
        selectForm: [],
      },
      username: "",
      showLoading: true,
      limit: 2,
      isPreview: false,
      type: 2,
      imageReady: false,
      imagePreview: [],
      imageUrl: [],
      uploadId: "",
      formId: [],
      isPhone: "",
      eventId: "",
      captcha: "",
      userCaptcha: "",
      mobileNumber: "",
      timeOut: 60 * 1000,
      counting: false,
      timeWrap: null,
      messageText: "获取验证码",
      disable: false,
      smsNumber: "",
      needSms: false,
      gameList: [],
      selectGame: "请选择游戏",
      myGameList: 1,
      isSms: false,
      description: "",
      formCount: 0,
      numberCount: 0,
      phoneCount: 0,
      timeCount: 0,
    };
  },
  watch: {
    deep: true,
    "childProp.event_id": function (eventId) {
      localStorage.setItem("event_id", eventId);
      this.eventId = eventId;
    },
    "childProp.formData": function (formData) {
      localStorage.setItem("formData", JSON.stringify(formData));
      this.formList = formData;
      this.getFormCount(formData);
    },
    "childProp.game_list": function (list) {
      localStorage.setItem("gameList", JSON.stringify(list));
      this.gameList = list;
    },
    "childProp.need_sms": function (sms) {
      localStorage.setItem("needSms", sms);
      this.needSms = sms;
    },
    "childProp.is_sms": function (sms) {
      localStorage.setItem("isSms", sms);
      this.isSms = sms;
    },
    "childProp.description": function (description) {
      localStorage.setItem("description", description);
      this.description = description;
    },

    immediate: true,
  },
  mounted() {
    this.clearForm();
    this.getCaptcha();
    this.eventId = localStorage.getItem("event_id");
    this.needSms = localStorage.getItem("needSms");
    this.isSms = localStorage.getItem("isSms");
    this.description = localStorage.getItem("description");
  },
  methods: {
    clearForm: function () {
      this.formList = [];
      this.imagePreview = [];
      this.isSms = false;
      this.needSms = false;
      this.gameList = [];
      this.imageReady = "";
      this.imageUrl = [];
      this.username = "";
      this.formName.inputForm = [];
      this.formName.numberForm = [];
      this.formName.phoneForm = [];
      this.formName.timeForm = [];
      this.formName.selectForm = [];
    },
    getFormCount: function (form) {
      if (form.length != 0) {
        form.forEach((element) => {
          if (element.type === 0) {
            ++this.formCount;
          }
          if (element.type === 1) {
            ++this.numberCount;
          }
          if (element.type === 2) {
            ++this.phoneCount;
          }
          if (element.type === 3) {
            ++this.timeCount;
          }
          if (element.type === 5) {
            this.formName.selectForm[element.id] = element["option"][0];
          }
        });
      }

      const game = JSON.parse(localStorage.getItem("gameList"));
      this.myGameList = game[0]["id"];
    },
    submit: async function () {
      if (this.username == "") {
        this.$toast("请填写会员账号");
        return true;
      }

      // if (this.validateUser()) {
      //   return true;
      // }

      if (this.validateForm() || this.validateUser()) {
        return true;
      }

      const that = this;
      await axios
        .post(route("apply_form"), {
          eventId: this.eventId,
          username: this.username,
          form: this.formName,
          imageUrl: this.imageUrl,
          captcha: this.userCaptcha,
          mobile: this.mobileNumber,
          smsNumber: this.smsNumber,
          needSms: this.needSms,
          gameName: this.myGameList,
          isSms: this.isSms,
        })
        .then(function (response) {
          that.$toast(response.data.msg);
          if (response.data.code == 1) {
            that.clearForm();
            that.closeDialog();
          }
          that.getCaptcha();
        })
        .catch(function (error) {
          that.$toast("申请有误,请刷新页面");
        });
    },
    getFormNameById: function (list, type, input) {
      let name = "";
      let res = false;
      const key = Object.keys(input);
      list.forEach((element) => {
        if (res) {
          return true;
        }

        if (element.type == type && !key.includes(element.id.toString())) {
          name = element.name;
          res = true;
        }
      });

      return name;
    },
    removeNull: function (form) {
      return form.filter((element) => {
        return element !== null;
      }).length;
    },
    validateForm_bak: function () {
      const form = this.formName;
      const list = this.formList;
      let res = false;
      console.log("form", form);
      console.log("list", list);
      list.forEach((element) => {
        if (res) {
          return true;
        }
        switch (true) {
          case element.type == 0:
            if (form.inputForm.length == 0) {
              this.$toast("请填写全部数据");
              res = true;
            }

            break;
          case element.type == 1:
            if (form.numberForm.length == 0) {
              this.$toast("请填写全部数据");
              res = true;
            }
            break;
          case element.type == 2:
            if (form.phoneForm.length == 0) {
              this.$toast("请填写全部数据");
              res = true;
            }

            break;
          case element.type == 3:
            if (form.timeForm.length == 0) {
              this.$toast("请填写全部数据");
              res = true;
            }
            break;
        }
      });
      // 0 文本框, 1数字类型, 2手机号码, 3时间框, 4图片框, 5下拉框

      return res;
    },
    validateForm: function () {
      const form = this.formName;
      const list = this.formList;
      let res = false;

      list.forEach((element) => {
        if (res) {
          return true;
        }

        switch (true) {
          case element.type == 0:
            if (this.removeNull(form["inputForm"]) !== this.formCount) {
              this.$toast(
                "请填写" +
                  this.getFormNameById(list, element.type, form["inputForm"])
              );
              res = true;
            }

            break;
          case element.type == 1:
            if (this.removeNull(form["numberForm"]) !== this.numberCount) {
              this.$toast(
                "请填写" +
                  this.getFormNameById(list, element.type, form["numberForm"])
              );
              res = true;
            }
            break;
          case element.type == 2:
            if (this.removeNull(form["phoneForm"]) !== this.phoneCount) {
              this.$toast(
                "请填写" +
                  this.getFormNameById(list, element.type, form["phoneForm"])
              );
              res = true;
            }

            break;
          case element.type == 3:
            if (this.removeNull(form["timeForm"]) !== this.timeCount) {
              this.$toast(
                "请填写" +
                  this.getFormNameById(list, element.type, form["timeForm"])
              );
              res = true;
            }
            break;
        }
      });
      // 0 文本框, 1数字类型, 2手机号码, 3时间框, 4图片框, 5下拉框

      return res;
    },
    validateUser: function () {
      if ("" == this.userCaptcha) {
        this.$toast("请填写验证码");
        return true;
      }

      if (1 == this.needSms && "" == this.mobileNumber) {
        this.$toast("请填写手机号码");
        return true;
      }
    },
    imageuploaded: function (response) {
      if (response.code == 1) {
        this.imageReady = true;
        this.imagePreview = response.data.src;
        this.imageUrl.push({
          id: response.data.form_id,
          value: this.imagePreview,
        });
        this.$toast("上传成功");
      } else {
        this.$toast("上传失败");
      }
    },
    closeDialog: function () {
      this.$emit("fromApplyDialog");
    },
    getCaptcha: async function () {
      const that = this;
      await axios.get(route("index_captcha")).then(function (response) {
        that.captcha = response.data;
        that.showLoading = false;
      });
    },
    getMessage: async function () {
      if ("" == this.userCaptcha) {
        this.$toast("请填写验证码");
        return true;
      }

      if ("" == this.mobileNumber) {
        this.$toast("请填写手机号码");
        return true;
      }

      const that = this;
      await axios
        .post(route("sms_message"), {
          mobile: this.mobileNumber,
          captcha: this.userCaptcha,
        })
        .then(function (response) {
          const res = response.data;
          if (res.code == 1) {
            that.counting = true;
            that.getCaptcha();
          }
          that.$toast(res.msg);
        });
    },
    countFinish: function () {
      this.messageText = "再次获取";
      this.counting = false;
    },
  },
};
</script>


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

.captcha {
  padding: 0 0.7rem;
  height: 2rem;
  color: #fff;
  font-size: 0.8rem;
  border: 1px solid #000;
  background: #000;
  box-sizing: border-box;
}

.description {
  color: white;
  font-size: 0.65rem;
  padding: 0 0.7rem;
}

.van-count-down {
  color: white;
}
.getMessage {
  width: 4.5rem;
  height: 2rem;
}
::placeholder {
  color: white;
}
.btnSubmit {
  width: 6.25rem;
  background-size: 6.25rem;
}
.g-core-image-upload-btn {
  padding-top: 0.3rem;
}
::-webkit-calendar-picker-indicator {
  filter: invert(1);
}

.modal-mask {
  position: fixed;
  z-index: 500;
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
  width: 20rem;
  max-height: 30rem;
  margin: 0px auto;
  padding: 20px 30px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
  background-color: #232323;
  overflow: auto;
}

.modal-container::-webkit-scrollbar {
  display: none;
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
