<template>
  <div class="relative">
    <myHeading></myHeading>
    <myWallpaper></myWallpaper>
    <applyList></applyList>
    <announcement></announcement>
    <event-list :passed-event-list="eventData"></event-list>
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
    eventList,
  },
  data() {
    return {
      eventData: [
        {
          type_id: 0,
          name: "综合优惠",
          event: [
            {
              id: 0,
              name: "捕鱼优惠",
              type_pic: "199/images/test.png",
              type_id: 0,
            },
            {
              id: 1,
              name: "捕鱼优惠",
              type_pic: "199/images/test2.png",
              type_id: 0,
            },
            {
              id: 2,
              name: "捕鱼优惠",
              type_pic: "199/images/test3.png",
              type_id: 0,
            },
            {
              id: 3,
              name: "捕鱼优惠",
              type_pic: "199/images/test4.png",
              type_id: 0,
            },
            {
              id: 4,
              name: "捕鱼优惠",
              type_pic: "199/images/test5.png",
              type_id: 0,
            },
            {
              id: 5,
              name: "捕鱼优惠",
              type_pic: "199/images/test6.png",
              type_id: 0,
            },
            {
              id: 6,
              name: "捕鱼优惠",
              type_pic: "199/images/test.png",
              type_id: 0,
            },
            {
              id: 7,
              name: "捕鱼优惠",
              type_pic: "199/images/test.png",
              type_id: 0,
            },
          ],
        },
        {
          type_id: 1,
          name: "棋牌优惠",
          event: [
            {
              id: 0,
              name: "综合1优惠",
              type_pic: "199/images/test2.png",
              type_id: 0,
            },
          ],
        },
        {
          type_id: 2,
          name: "捕鱼优惠",
          event: [
            {
              id: 0,
              name: "综合2优惠",
              type_pic: "199/images/test3.png",
              type_id: 0,
            },
          ],
        },
        {
          type_id: 3,
          name: "电子优惠",
          event: [
            {
              id: 0,
              name: "综合3优惠",
              type_pic: "199/images/test4.png",
              type_id: 0,
            },
          ],
        },
        {
          type_id: 4,
          name: "真人优惠",
          event: [
            {
              id: 0,
              name: "综合4优惠",
              type_pic: "199/images/test5.png",
              type_id: 0,
            },
          ],
        },
         {
          type_id: 5,
          name: "体育优惠",
          event: [
            {
              id: 0,
              name: "综合5优惠",
              type_pic: "199/images/test6.png",
              type_id: 0,
            },
          ],
        },
         {
          type_id: 6,
          name: "体育优惠",
          event: [
            {
              id: 0,
              name: "综合6优惠",
              type_pic: "199/images/test2.png",
              type_id: 0,
            },
          ],
        },{
          type_id: 7,
          name: "子弹优惠",
          event: [
            {
              id: 0,
              name: "综合7优惠",
              type_pic: "199/images/test.png",
              type_id: 0,
            },{
              
            }
          ],
        },
        
      ],
    };
  },
};
</script>
