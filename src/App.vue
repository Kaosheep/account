<script setup>

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
    height: 100vh;
    background: linear-gradient(45deg, $subcolor 10%, transparent 11%, transparent 89%, $subcolor 90%), linear-gradient(135deg, $subcolor 10%, transparent 11%, transparent 89%, $subcolor 90%), radial-gradient(circle, transparent 25%, #ffffff 26%), linear-gradient(0deg, transparent 44%, $subcolor 45%, $subcolor 55%, transparent 56%), linear-gradient(90deg, transparent 44%, $subcolor 45%, $subcolor 55%, transparent 56%);
    background-size: 2em 2em;
    background-color: #ffffff;
    opacity: 0.8;
    @include fc;

    .mainbroad {
        width: 92%;
        height: 92%;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 0 5px $mcolor;
        padding: 1rem;
    }
}
</style>
