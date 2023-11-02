<script setup>
import dayjs from'dayjs';
import 'dayjs/locale/zh-cn';
dayjs.locale('zh-cn');
</script>

<template>
    <main class="bg">
        <div class="mainbroad"><router-view></router-view></div>

    </main>
</template>

<style lang="scss">
@import "@/assets/css/style.scss";
.bg {
    width: 100vw;
    min-height: 100vh;
    background: linear-gradient(45deg, $subcolor 10%, transparent 11%, transparent 89%, $subcolor 90%), linear-gradient(135deg, $subcolor 10%, transparent 11%, transparent 89%, $subcolor 90%), radial-gradient(circle, transparent 25%, #ffffff 26%), linear-gradient(0deg, transparent 44%, $subcolor 45%, $subcolor 55%, transparent 56%), linear-gradient(90deg, transparent 44%, $subcolor 45%, $subcolor 55%, transparent 56%);
    background-size: 2em 2em;
    background-color: #ffffff;
    opacity: 0.8;
    @include fc;
    padding: 1vh 0;
    .mainbroad {
        width: 95%;
        max-width: 1280px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 0 5px $mcolor;
        padding: 1rem;
    }
}
</style>
