<template>
  <div class="grid grid-cols-2 fixed w-full relative bg-black">
    <div>
    <a href="/">
      <img
        class="w-36 p-2 float-left"
        :src="!headData['logo'] ? logo : headData['logo']"
        alt="Head Logo"
      /></a>
    </div>
    <div v-on:click="getDialog">
      <img
        class="w-40 p-2 float-right"
        :src="!headData['searchBtn'] ? btn : headData['searchBtn']"
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

<style scoped>
img {
  cursor: pointer;
}
</style>
<script>
import search from "./searchDialog";
import axios from "axios";

export default {
  props: ["headData"],
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
      logo: "199/images/logo.png",
      btn: "199/images/search.png",
    };
  },

  methods: {
    getDialog: async function (data) {
      this.showModal = true;
      const that = this;
      await axios
        .post(route("event_list"), {})
        .then(function (response) {
          const list = response.data.data;
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
