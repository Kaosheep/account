<script setup>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';

const getImageUrl = (id) => {
    return new URL(`../assets/image/icon/${id}.png`, import.meta.url).href;
}

const today = reactive({
    full: {},
    year: {},
    month: {},
    date: {},
    day: {}
});

const timeFormate = () => {
    let newdate = new Date();

    today.year = String(newdate.getFullYear());
    today.month = String(
        newdate.getMonth() + 1 < 10
            ? "0" + (newdate.getMonth() + 1)
            : newdate.getMonth() + 1
    );
    today.date = String(
        newdate.getDate() < 10 ? "0" + newdate.getDate() : newdate.getDate()
    );

    today.full = String(`${today.year}-${today.month}-${today.date}`);

    const dayNames = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
    today.day = dayNames[new Date().getDay()];
};



const data = reactive({
    obj: {},
    sum: {},
    maintype:[],
    subtype:[]
})



const gettoday = () => {
    const url = `http://localhost/dashboard/public/php/fetchdata.php`;
    axios
        .post(url, {
            full: today.full
        })
        .then((response) => {
            const res = response.data;
            if (res["result"]["sum(con_sum)"]) {
                data.sum = res["result"]["sum(con_sum)"];
            } else {
                data.sum = 0;
            };

            data.obj = res["data"];

        })
        .catch((error) => {
            console.log(error.message);
        });
}
const gettype = () => {
    const url = `http://localhost/dashboard/public/php/fetchtype.php`;
    axios
        .get(url)
        .then((response) => {
            const res = response.data;

            data.maintype = res["typs"];
            data.subtype = res["styps"];

        })
        .catch((error) => {
            console.log(error.message);
        });
}
const rowcolor = (id) => {
    if (id === "foo") {
        return "#B6B6CF";
    } else if (id === "clo") {
        return "#F5DAC2"
    } else if (id === "dal") {
        return "#B5CAA0"
    } else if (id === "edu") {
        return "#7DB9DE"
    } else if (id === "els") {
        return "#ccc"
    } else if (id === "med") {
        return "#D9CD90"
    } else if (id === "tra") {
        return "#F8C3CD"
    } else if (id === "ent") {
        return "#FAD689"
    }
};
const isOpen = ref(true);
const open = () => {
    isOpen.value = !isOpen.value;
    console.log(isOpen.value)
}

onMounted(() => {
    gettype();
    timeFormate();
    gettoday();
})
</script>
<template >
    {{ data.maintype }}
    <main>
        <div class="top">
            <div class="b today">
                <router-link to="/daydetail">
                    <font-awesome-icon :icon="['far', 'calendar-days']" />
                    <p>
                        <span>{{ today.year }}</span> -
                        <span>{{ today.month }}</span> -
                        <span>{{ today.date }}</span>
                        <span>{{ today.day }}</span>
                    </p>
                </router-link>
            </div>
            <div class="b">
                <p>今日支出 <b>{{ data.sum }}</b></p>
            </div>
        </div>
        <div class="board">
            <div class="title">
                <h2>
                    今日支出明細
                </h2>
            </div>
            <div class="container">
                <div v-if="!data.obj">今日尚未紀錄</div>
                <div v-else class="row" v-for="item in data.obj" :style="{ backgroundColor: rowcolor(item.m_id) }">
                    <span>
                        <img :src="getImageUrl(item.m_id)" alt="">
                        <span>{{ item.m_name }}</span></span>
                    <span>{{ item.sub_name }}</span>
                    <span>{{ item.con_sum }} 元</span>
                    <span><font-awesome-icon :icon="['fas', 'pen']" /></span>
                </div>
            </div>
            <div class="btn">
                <button @click="open">
                    <span><font-awesome-icon :icon="['fas', 'plus']" id="plus" /></span>
                    新增明細
                </button>
            </div>
        </div>
        <div class="anz">

        </div>
        <div class="add" v-show="isOpen">
            <h3>新增明細</h3>
            <div class="opt">
                <button>支出</button>
                <button>收入</button>
            </div>
            <div class="type">

            </div>
            <div class="subtype">

            </div>
            <div class="money">

            </div>
            <div class="cal">

            </div>
        </div>
    </main>
</template>
<style scoped lang="scss">
main {


    .top {
        display: flex;
        gap: 1rem;

        .b {
            width: 50%;
            background-color: $mcolor;
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
        }

        .today {

            a {
                p {
                    display: inline-block;
                    margin-left: 0.5rem;

                    span {
                        &:last-child {
                            margin-left: 0.5rem;
                        }
                    }
                }
            }
        }

    }

    .board {
        height: 60vh;
        display: flex;
        flex-direction: column;
        margin: 1rem 0;
        border: 3px solid $pur;
        border-radius: 15px;

        .title {
            text-align: center;
            border-bottom: 3px solid $pur;
            height: 10%;
            @include fc;
        }

        .container {
            height: 80%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem;
            gap: 0.5rem;

            overflow-y: scroll;

            &::-webkit-scrollbar {
                width: 7px;
                height: 7px;
                background-color: #fff;
                border-radius: 4px;
            }

            &::-webkit-scrollbar-track {
                background: #fff;
                border-radius: 4px;
            }

            &::-webkit-scrollbar-thumb {
                background: $subcolor;
                border-radius: 4px;
            }

            .row {
                width: 100%;
                height: 60px;
                background-color: $mcolor;
                border-radius: 15px;
                display: flex;
                align-items: center;
                padding: 0.5rem;
                justify-content: space-between;

                span {
                    background-color: #fff;
                    height: 45px;
                    border-radius: 15px;
                    text-align: center;
                    line-height: 45px;

                    &:nth-child(1) {
                        width: 25%;
                        @include fc;
                        span{
                            white-space: nowrap;
                        }
                        img {
                            width: 30%;
                            object-fit: contain;
                            margin-right: 0.5rem;
                            max-height: 40px;
                        }
                    }

                    &:nth-child(2) {
                        width: 25%;
                    }

                    &:nth-child(3) {
                        width: 25%;
                    }

                    &:nth-child(4) {
                        width: 45px;
                        border-radius: 50%;
                        cursor: pointer;
                    }
                }
            }
        }

        .btn {
            text-align: center;
            border-top: 3px solid $pur;
            height: 10%;
            @include fc;

            button {
                display: block;
                width: 100%;
                background: none;
                border: none;
                cursor: pointer;
                height: 100%;
                font-size: 1.25rem;

                span {
                    margin-right: 0.5rem;

                    #plus {
                        font-size: 1.5rem;
                    }

                }
            }
        }
    }

    .add {
        position: fixed;
        top: 10vh;
        left: 10vw;
        width: 80vw;
        height: 80vh;
        background-color: #fff;
        box-shadow: 0 0 10px $mcolor;
        border-radius: 15px;

        h3 {
            text-align: center;
        }

    }



}
</style>