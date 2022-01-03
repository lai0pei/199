<template>
  <div class="relative bg-black rounded-lg">
   <pullRefresh :on-refresh="onRefresh"></pullRefresh>
    <myHeading></myHeading>
    <myWallpaper></myWallpaper>
    <applyList :user-apply-list="applyList"></applyList>
    <announcement :announce="announcement"></announcement>
    <event-list :passed-event-list="event"></event-list>
    <myFoot :footer="footer"></myFoot>
  </div>
</template>

<style>
</style>
<script>
import myHeading from "./Components/myHeading";
import myFoot from "./Components/myFooting";
import myWallpaper from "./Components/wallpaper";
import applyList from "./Components/applylist";
import announcement from "./Components/announcement";
import eventList from "./Components/eventList";
import pullRefresh from "vue-pull-refresh";

export default {
  name: "page",
  components: {
    pullRefresh,
    myHeading,
    myFoot,
    myWallpaper,
    applyList,
    announcement,
    eventList,
  },
  props : ['event','footer', 'announcement', 'applyList'],
   methods: {
        onRefresh: function() {
          console.log('refreshing');
            return new Promise(function (resolve, reject) {
                setTimeout(function () {
                    resolve();
                }, 1000);
            });
        }
    },
}
</script>
