
<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import axios from 'axios';
import dayjs from 'dayjs';
import zh_TW from 'ant-design-vue/lib/date-picker/locale/zh_TW';
dayjs.locale('zh-tw');
import caculator from '@/components/caculator.vue'
import navp from '@/components/navp.vue'
import { notification } from 'ant-design-vue';

const value = ref();
const day = ref("")
const onPanelChange = (value, mode) => {
    // console.log(value, mode);
};
const onSelect = (date) => {
    let dastr, mostr;
    if (date.$D < 10) {
        dastr = `0${date.$D}`
    } else {
        dastr = `${date.$D}`
    }
    if (date.$M < 9) {
        mostr = `0${date.$M + 1}`
    } else {
        mostr = `${date.$M + 1}`
    }
    select.con_day = `${date.$y}-${mostr}-${dastr}`;
    const url = `http://localhost/dashboard/public/php/fetchdata.php`;
    axios
        .post(url, {
            full: select.con_day
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
};
const getImageUrl = (id) => {
    return new URL(`../assets/image/icon/${id}.png`, import.meta.url).href;
}
const openNotificationWithIcon = (type, res) => {
    notification[type]({
        message: res,
    });
};
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

    select.con_day = String(`${today.year}-${today.month}-${today.date}`);
    const dayNames = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
    today.day = dayNames[new Date().getDay()];
};



const data = reactive({
    obj: {},
    sum: {},
    t: {},
    maintype: [],
    subtype: [],
    type: []
})



const gettoday = () => {
    const url = `http://localhost/dashboard/public/php/fetchdata.php`;
    axios
        .post(url, {
            full: select.con_day
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
    } else if (id === "mon") {
        return "#F9BF45"
    }
};

const select = reactive({
    con_id: "",
    s_id: "",
    m_id: "",
    con_sum: "",
    con_day: ``,
    sub_name: "",
    t: 0,
});

const isOpen = ref(false);
const isEdit = ref(false);


const open = () => {
    if (isEdit.value) {
        isEdit.value = false;
        isOpen.value = !isOpen.value;
    } else {
        isOpen.value = !isOpen.value;
    }
    select.con_id = "";
    select.m_id = "";
    select.s_id = "";
    select.con_sum = "";
    select.sub_name = "";
}


const edit = (id, day, mid, sid, sum, name) => {
    isOpen.value = !isOpen.value;
    isEdit.value = !isEdit.value;
    select.con_id = id;
    select.m_id = mid;
    select.s_id = sid;
    select.con_day = day;
    select.con_sum = sum;
    select.sub_name = name;
}
const settype = (id) => {
    select.m_id = id;
}
const setsubtype = (id, name, t) => {
    select.s_id = id;
    select.sub_name = name;
    select.t = t;
}

const subt = computed(() => {
    return data.subtype.filter((t) =>
        t.m_id == select.m_id
    );
});

const numin = (res) => {
    select.con_sum = res
}

const add = () => {
    if (select.s_id == "") {
        openNotificationWithIcon('warning', "未輸入類別");
    } else if (select.con_sum == "") {
        openNotificationWithIcon('warning', "未輸入金額");
    } else {
        let mod = 1;
        const url = `http://localhost/dashboard/public/php/insert.php`;
        axios
            .post(url, {
                mod: mod,
                con_day: select.con_day,
                m_id: select.m_id,
                con_sum: select.con_sum,
                s_id: select.s_id,
                con_id: ""
            })
            .then((response) => {
                let res = response.data;
                openNotificationWithIcon('success', res);
                open();
                gettoday();
            })
            .catch((error) => {
                console.log(error.message);
            });
    }
}
const update = () => {
    if (select.con_sum == "") {
        openNotificationWithIcon('warning', "未輸入金額");
    } else {
        let mod = 2;
        const url = `http://localhost/dashboard/public/php/insert.php`;
        axios
            .post(url, {
                mod: mod,
                con_day: select.con_day,
                m_id: select.m_id,
                con_sum: select.con_sum,
                s_id: select.s_id,
                con_id: select.con_id,

            })
            .then((response) => {
                let res = response.data;
                openNotificationWithIcon('success', res);
                open();
                gettoday();
            })
            .catch((error) => {
                console.log(error.message);
            });
    }
}
const del = () => {
    let mod = 3;
    const url = `http://localhost/dashboard/public/php/insert.php`;
    axios
        .post(url, {
            mod: mod,
            con_day: select.con_day,
            m_id: select.m_id,
            con_sum: select.con_sum,
            s_id: select.s_id,
            con_id: select.con_id,

        })
        .then((response) => {
            let res = response.data;
            openNotificationWithIcon('success', res);
            open();
            gettoday();
        })
        .catch((error) => {
            console.log(error.message);
        });
}
onMounted(() => {
    timeFormate();
    gettoday();
    gettype();
})
</script>
<template >
    <navp></navp>
    <h1>消費明細</h1>
    <div class="can">
        <a-calendar v-model:value="value" :fullscreen="false" @panelChange="onPanelChange" @select="onSelect"
            :locale="zh_TW" />
    </div>

    <div class="board">
        <div class="title">
            <p class="date">{{ select.con_day }}</p>
        </div>
        <div class="container">
            <div v-if="!data.obj">今日尚未紀錄</div>
            <div v-else class="row" v-for="item in data.obj" :key="item.con_id"
                :style="{ backgroundColor: rowcolor(item.m_id) }">
                <span>
                    <img :src="getImageUrl(item.m_id)" alt="">
                    <span>{{ item.m_name }}</span></span>
                <span>{{ item.sub_name }}</span>
                <span>{{ item.con_sum }} 元</span>
                <span
                    @click="edit(item.con_id, item.con_day, item.m_id, item.s_id, item.con_sum, item.sub_name)"><font-awesome-icon
                        :icon="['fas', 'pen']" /></span>
            </div>
        </div>
        <div :class="['add', { slide: isOpen }]">
            <div class="btn">
                <button>
                    <span @click="open"><font-awesome-icon :icon="['fas', 'plus']" id="plus" /></span>
                    <span @click="open" v-show="!isOpen">新增明細</span>
                    <span class="date" v-show="isOpen"><input type="date" v-model="select.con_day"></span>
                    <span @click="del" class="can" v-show="isEdit"><font-awesome-icon :icon="['far', 'trash-can']" /></span>
                    <span @click="open" class="back"></span>
                </button>
            </div>
            <div class="typeblock">
                <div class="type" v-for="icon in data.maintype" :key="icon.m_id" @click="settype(icon.m_id)">
                    <div :style="{ backgroundColor: rowcolor(icon.m_id) }">
                        <img :src="getImageUrl(icon.m_id)" alt="">
                        <span>{{ icon.m_name }}</span>
                    </div>

                </div>
            </div>
            <div class="subtype">
                <div class="st" v-for="st in subt" :key="st.s_id" @click="setsubtype(st.s_id, st.sub_name, st.t)">
                    <p>{{ st.sub_name }}</p>
                </div>
            </div>
            <div class="money">
                <input type="text" v-model="select.sub_name" readonly />
                <input type="text" v-model="select.con_sum" />
                <button v-show="!isEdit" @click="add">儲存</button>
                <button v-show="isEdit" @click="update">修改</button>
            </div>
            <div class="cal">
                <caculator @cal="numin"></caculator>
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
h1 {
    font-size: 20px;
    text-align: center;
    background-color: $mcolor;
    padding: 5px;
    border-radius: 50px;
    margin: 0;
}

.board {
    height: 75vh;
    display: flex;
    flex-direction: column;
    margin: 0.5rem 0;
    border: 3px solid $pur;
    border-radius: 15px;
    overflow: hidden;
    position: relative;

    .title {
        text-align: center;
        border-bottom: 3px solid $pur;
        height: 10%;
        @include fc;
        flex-shrink: 0;

        p {
            font-size: 20px;
            font-weight: 700;
        }
    }

    .container {
        height: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1rem 0.5rem;
        gap: 0.5rem;
        overflow-y: scroll;
        flex-shrink: 0;

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
                height: 45px;
                border-radius: 10px;
                text-align: center;
                line-height: 45px;

                &:nth-child(1) {
                    width: 28%;
                    @include fc;
                    background-color: #fff;

                    span {
                        width: 65%;
                        white-space: nowrap;
                    }

                    img {
                        width: 35%;
                        object-fit: contain;
                        max-height: 40px;
                        position: relative;
                    }
                }

                &:nth-child(2) {
                    width: 28%;
                }

                &:nth-child(3) {
                    width: 25%;
                }

                &:nth-child(4) {
                    height: 30px;
                    width: 30px;
                    border-radius: 50%;
                    cursor: pointer;
                    background-color: #fff;
                    @include fc;
                }
            }
        }
    }

    .add {
        width: 100%;
        height: 100%;
        background-color: #fff;
        padding: 0 0.5rem 0.5rem;
        border-top: 3px solid $pur;
        transition: .3s;
        position: absolute;
        top: 90%;

        .btn {
            text-align: center;
            height: 10%;
            margin-bottom: 2%;
            @include fc;

            button {
                width: 100%;
                background: none;
                border: none;
                cursor: pointer;
                height: 100%;
                font-size: 1.25rem;
                position: relative;

                span {
                    margin-right: 0.5rem;
                    position: relative;
                    z-index: 1;
                    #plus {
                        font-size: 1.25rem;
                        transition: .5s;

                    }

                }
                .back {
                    position: absolute;
                    width: 100%;
                    height: 100%;
                    top: 0;
                    left: 0;
                    z-index: 0;
                }

                .can {
                    margin-left: 1rem;
                    padding: 5px 10px;
                    background-color: #ccc;
                    border-radius: 5px;
                }

                .date {
                    margin-left: 0.5rem;

                    input {
                        border: none;
                        font-size: 1.25rem;
                        height: 100%;
                    }

                }
            }
        }


        .typeblock {
            display: flex;
            flex-wrap: wrap;
            justify-content: start;

            .type {
                width: 20%;
                height: 50px;
                @include fc;
                padding: 2px;
                margin-bottom: 1rem;
                cursor: pointer;

                div {
                    width: 100%;
                    border-radius: 5px;
                    padding: 3px;

                    img {
                        display: block;
                        width: 65%;
                        max-height: 40px;
                        object-fit: contain;
                        margin: 0 auto 4px;
                    }

                    span {
                        display: block;
                        text-align: center;
                    }
                }

            }


        }

        .subtype {
            display: flex;
            padding: 0 0 0.5rem;
            gap: 0.5rem;
            overflow-x: scroll;
            margin-bottom: 0.5rem;
            height: 50px;

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
                background: $mcolor;
                border-radius: 4px;
            }

            .st {
                background-color: #ccc;
                border-radius: 15px;
                padding: 0.5rem 1rem;
                flex-shrink: 0;
                cursor: pointer;
            }
        }

        .money {
            input {
                font-size: 16px;
                padding: 8px;
                border: none;


                &:nth-child(1) {
                    display: inline-block;
                    width: 30%;
                    pointer-events: none;
                    text-align: center;
                }

                &:nth-child(2) {
                    display: inline-block;
                    width: 50%;
                    border-bottom: 1px solid $mcolor ;
                    font-size: 20px;

                }

            }

            button {
                display: inline-block;
                width: 20%;
                padding: 8px;
                height: 100%;
                border: none;
                background-color: $pig;
                font-size: 16px;
                font-weight: 700;
                cursor: pointer;
            }
        }

        .cal {
            margin-top: 0.5rem;
            height: 40%;
        }
    }

    .add.slide {
        position: absolute;
        top: 0;
        border-top: none;

        #plus {
            transform: rotate(45deg);
        }
    }

}
</style>