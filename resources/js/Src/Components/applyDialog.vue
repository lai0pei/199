<template>
    <div v-if="show" class="top-0 fixed"><h1 class="text-white">hi</h1></div>
</template>

<script>
export default {
    props : [
        "applyShow",
    ],
  
    data() {
        return {
            show : false,
        }
    },
    methods : {
        
    },
      mounted() {
        console.log(this.applyShow);
        this.show = this.applyShow;
    },

}
</script>