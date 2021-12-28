<template>
  <div>
    <myHeading></myHeading>
    <myWallpaper></myWallpaper>
    <applyList></applyList>
    <announcement></announcement>
    <event-list></event-list>
    <myFoot></myFoot>
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
    eventList
  },
  data(){return{

  }},
};
</script>
