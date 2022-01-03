<template>
  <div class="grid grid-cols-2 fixed w-full relative">
    <div>
      <img
        class="w-36 p-2 float-left"
        src="199/images/logo.png"
        alt="Head Logo"
      />
    </div>
    <div v-on:click="getDialog">
      <img
        class="w-40 p-2 float-right"
        src="199/images/search.png"
        alt="SearchIcon"
      />
    </div>
    <search
      v-if="showModal"
      :childProp="eventList"
      v-on:fromApplyDialog="showModal = false"
    ></search>
  </div>
</template>

<script>
import search from "./searchDialog";
import axios from "axios";

export default {
  components: {
    search,
  },
  name: "myHeading",
  data() {
    return {
      showModal: false,
      eventList: {
        game_list: [],
      },
    };
  },
  methods: {
    getDialog: async function (data) {
      this.showModal = true;
      let that = this;
      await axios
        .post(route("event_list"), {})
        .then(function (response) {
          let list = response.data.data;
          that.eventList.game_list = list;
        })
        .catch(function (error) {
          console.error(error);
        });
    },
    fromApplyDialog: function () {
      this.showModal = false;
    },
  },
};
</script>
