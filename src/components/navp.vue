<template>
    <div class="menu">
        <div :class="['bar', { open: isOpen }]">
            <div class="console" @click="opennav">
                <span></span>
            </div>
            <router-link to="/">
                <span><font-awesome-icon :icon="['fas', 'house']" /></span>
            </router-link>
            <router-link to="/daydetail">
                <span><font-awesome-icon :icon="['far', 'calendar-days']" /></span>
            </router-link>
            <router-link to="/bank">
                <span><font-awesome-icon :icon="['fas', 'piggy-bank']" /></span>
            </router-link>
            <router-link to="/analysis">
                <span><font-awesome-icon :icon="['fas', 'chart-pie']" /></span>
            </router-link>

        </div>

    </div>
</template>
<script setup>
import { ref } from 'vue';
const isOpen = ref(false);
const opennav = () => {
    isOpen.value = !isOpen.value
}

</script>
<style lang="scss" scoped>
.menu {
    position: fixed;
    top: 0.5rem;
    left: 0.5rem;
    z-index: 100;

    .bar {
        width: 60px;
        height: 60px;
        background-color: $pur;
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow: hidden;
        transition: .3s;

        >* {
            flex-shrink: 0;
            width: 60px;
            height: 60px;
        }

        .console {
            cursor: pointer;
            @include fc;
            transition: .3s;

            span {
                display: inline-block;
                width: 20px;
                height: 5px;
                background-color: #fff;
                border-radius: 20px;
                position: relative;
                transition: .3s;

                &::after {
                    content: "";
                    position: absolute;
                    width: 20px;
                    height: 5px;
                    background-color: #fff;
                    border-radius: 20px;
                    bottom: 200%;
                    transition: .3s;

                }

                &::before {
                    content: "";
                    position: absolute;
                    width: 20px;
                    height: 5px;
                    background-color: #fff;
                    border-radius: 20px;
                    top: 200%;
                    transition: .3s;

                }
            }
        }

        a {
            @include fc;

            * {
                width: 30px;
                height: 30px;
                color: #fff;
            }
        }

    }

    .bar.open {
        height: 300px;

        .console {
            transform: rotate(90deg);

            span {
                width: 8px;
                height: 8px;

                &::after {
                    width: 8px;
                    height: 8px;
                    bottom: 180%;
                }

                &::before {
                    width: 8px;
                    height: 8px;
                    top: 180%;
                }
            }
        }
        
    }
}
</style>