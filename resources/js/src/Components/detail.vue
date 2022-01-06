<template>
<div>
<myHeading :head-data='logo'></myHeading>
<div class="relative top">
<div class="text-center myTitle">{{name}}</div>
<div v-html="content" style="overflow-y=auto">
</div>
</div>
<myFoot :footer="footer"></myFoot>
</div>
</template>
<style scoped>
.myTitle{
    margin-bottom: 0.27rem;
    padding-bottom: 0.22rem;
    color: #e7ce83;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    border-bottom: 1px solid #3E3E3E;
}
.top{
    padding: 0.24rem 0.4rem 1.3rem;
    min-height: 90vh;
    box-sizing: border-box;
}
</style>
<script>
import myHeading from './myHeading';
import myFoot from './myFooting';

export default {
  components: {
    myHeading,
    myFoot,
  },
  props: ['footer', 'content', 'name','logo'],

};
</script>
