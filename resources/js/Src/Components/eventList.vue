<template>
    <div class="rounded-lg bg-slate-800 mt-2 mx-2" >
    <div  class="overflow-auto whitespace-nowrap">
    <a class="text-stone-600 text-center p-2 inline-block " v-for="item in eventType" :key="item.name"><span v-on:click="1">{{item.name}}</span></a>
    </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            "eventType" : [
                { "name" : '综合优惠'},
                { "name" : '棋牌优惠'},
                { "name" : '捕鱼优惠'},
                { "name" : '电子优惠'},
                { "name" : '真人优惠'},
                { "name" : '体育优惠'},
                { "name" : '其他优惠'},
                { "name" : '子弹优惠'},
            ]
        }
    },
}
</script>