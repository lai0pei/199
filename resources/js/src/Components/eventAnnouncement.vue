<template>
  <div
    class="
      mt-2
      mx-2
      h-7
      border-solid border-slate-700 border-y
      rounded-lg
      border-r
      overflow-hidden
    "
  >
    <span class=""
      ><img
        src="199/images/icon01.png"
        class="float-left w-9 h-auto"
        alt="公告"
      />
    </span>
    <van-notice-bar
      :text="listData"
      background="black"
      color="#e7ce83"
      scrollable
      :autoplay="3000"
    />
  </div>
</template>

<script>
export default {
  props: ['announce'],
  mounted() {
    this.listData = this.announce.announcement;
  },
  data() {
    return {
      listData: '',
    };
  },
};
</script>

<style scoped>
.van-notice-bar {
  height: 1.8rem;
  padding: 0;
}
</style>
