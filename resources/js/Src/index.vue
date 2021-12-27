<template>
<div>
  <heading></heading>
 <myWallpaper></myWallpaper>
  <myFoot></myFoot>
</div>
</template>

<style>
</style>
<script>
import heading from "./Components/myHeading";
import myFoot from "./Components/footer";
import myWallpaper from "./Components/wallpaper";

export default {
  name: "page",
  components: {
    heading,
    myFoot,
    myWallpaper,
  },
};
</script>
