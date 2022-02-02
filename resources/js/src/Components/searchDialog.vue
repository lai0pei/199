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
                  class="float-left ml-8 mt-2.5 w-5"
                /><span class="text-amber-400 text-xl ml-8">{{
                  head_text
                }}</span
                ><img
                  src="199/images/img02.png"
                  alt="右边图标"
                  class="float-right w-5 mr-14 mt-2.5 mr-8"
                />
              </div>
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              <ul v-if="is_search">
                <li>
                  <div>
                    <input
                      placeholder="会员账号"
                      class="allForms rounded-md"
                      v-model="username"
                    />
                  </div>
                </li>
                <div>
                  <select class="allForms mt-1 rounded-md" v-model="eventId">
                    <option disabled>
                      {{ selectGame }}
                    </option>
                    <option
                      v-for="(data, index) in eventList"
                      :key="index"
                      :value="data.id"
                    >
                      {{ data.name }}
                    </option>
                  </select>
                </div>
              </ul>
              <div v-if="is_result">
                <table>
                  <thead>
                    <tr>
                      <th>会员账号</th>
                      <th>申请时间</th>
                      <th>申请状态</th>
                      <th>查看回复</th>
                    </tr>
                    <tr v-for="(data, index) in tableData" :key="index">
                      <td>{{ data.username }}</td>
                      <td class="apply_time">{{ data.apply_time }}</td>
                      <td v-if="data.status == '拒绝'" class="deny">{{ data.status}}</td>
                      <td v-else-if="data.status == '通过'" class="pass">{{ data.status}}</td>
                      <td v-else>{{ data.status}}</td>
                      <td v-if="data.status == '拒绝'" class="deny" @click="showMsg(data)">点击查看</td>
                      <td v-else-if="data.status == '通过'" class="pass" @click="showMsg(data)">点击查看</td>
                      <td v-else @click="showMsg(data)">点击查看</td>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="text-center mt-4">
                <span class="float-left"
                  ><button
                    v-on:click="closeDialog"
                    class="btnSubmit bg-eventBtn block m-auto font-bold"
                  >
                    {{ btnText }}
                  </button></span
                >
                <span class="float-right"
                  ><button
                    v-on:click="submit"
                    class="btnSubmit bg-eventBtn block m-auto font-bold"
                    v-if="showButton"
                  >
                    点击查询
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
import axios from 'axios';
export default {
  props: {childProp: Object},
  data() {
    return {
      username: '',
      eventId: 1,
      eventList: [],
      selectGame: '请选择活动',
      is_result: false,
      is_search: true,
      head_text: '查看进度',
      tableData: [],
      showButton: true,
      btnText: '取消',
    };
  },
  watch: {
    'deep': true,
    'childProp.game_list': function(list) {
      localStorage.setItem('eventList', JSON.stringify(list));
      this.eventList = list;
    },
    'immediate': true,
  },
  mounted() {
    this.clearForm();
    this.eventList = localStorage.getItem('eventList');
    this.eventId = 1;
  },
  methods: {
    clearForm: function() {
      this.username = '';
    },
   
    submit: async function() {
      if (this.username == '') {
        this.$toast('请填写会员账号');
        return true;
      }

      const that = this;
      await axios
          .post(route('check_form'), {
            eventId: this.eventId,
            username: this.username,
          })
          .then(function(response) {
            if (response.data.code == 1) {
              that.clearForm();
              if (response.data.data.length == 0) {
                that.$toast('无数据');
              } else {
                that.is_result = true;
                that.is_search = false;
                that.head_text = '进度列表';
                that.showButton = false;
                that.btnText = '关闭';
                that.tableData = response.data.data;
                that.$toast(response.data.msg);
              }
            }
          })
          .catch(function(error) {
            that.$toast('申请有误,请刷新页面');
          });
    },
    closeDialog: function() {
      this.$emit('fromApplyDialog');
    },
    showMsg: function(data) {
      this.$toast(data.description);
    },
  },
};
</script>


<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
  color: white;
  font-size: 0.8em;
  border-radius:  1rem;
}

td,th {
  border: 1px solid #333;
  text-align: center;
  padding: 8px;
}
.description {
  color: red;
}
.pass {
  color: green;
}
.deny {
  color: red;
}
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

.apply_time{
  font-size : 0.8em;
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
