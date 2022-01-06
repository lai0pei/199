<template>
  <div class="relative bg-black rounded-lg">
    <myHeading :head-data="logo"></myHeading>
    <myWallpaper :wallpaper="logo"></myWallpaper>
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

export default {
  name: "page",
  components: {
    myHeading,
    myFoot,
    myWallpaper,
    applyList,
    announcement,
    eventList,
  },
  props: ["event", "footer", "announcement", "applyList", "logo"],

};
</script>
