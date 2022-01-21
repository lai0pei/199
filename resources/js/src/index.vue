<template>
  <div class="relative rounded-lg whole">
    <myHeading :head-data="logo"></myHeading>
    <myWallpaper :wallpaper="logo"></myWallpaper>
    <applyList :user-apply-list="applyList"></applyList>
    <announcement :announce="announcement"></announcement>
    <event-list :passed-event-list="event"></event-list>
    <myFoot :footer="footer"></myFoot>
  </div>
</template>

<style>
.whole {
  background: rgba(0, 0, 0, 0.3);
}
</style>
<script>
import myHeading from "./Components/myHeading";
import myFoot from "./Components/myFooting";
import myWallpaper from "./Components/eventWallpaper";
import applyList from "./Components/applyList";
import announcement from "./Components/eventAnnouncement";
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
