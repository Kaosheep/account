<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import axios from 'axios';
import { notification } from 'ant-design-vue';
import navp from '@/components/navp.vue'
import { useEnvironmentStore } from '@/stores/path.js'
const counterStore = useEnvironmentStore();
const openNotificationWithIcon = (type, w) => {
    notification[type]({
        message: w,
    });
};
const myChart = ref(null);

onMounted(() => {
    timeFormate();
    gettoday();
    clickbtn();
});

const pay = computed(() => {
    if (data.arr) {
        return data.arr.filter((d) => d.t === "0");
    } else {
        return 0
    }

});
const mon = computed(() => {
    if (data.arr) {
        return (data.arr.map((d) => d.sum)).reduce((acc, val) => acc + parseInt(val), 0);
    } else {
        return 0
    }

});

const colorarr = ref([]);

const getcolorarr = () => {
    const idarr = data.arr.map(row => row.m_id);
    idarr.forEach((id) => {
        if (id === "foo") {
            colorarr.value.push('#B6B6CF');
        } else if (id === "clo") {
            colorarr.value.push("#F5DAC2");
        } else if (id === "dal") {
            colorarr.value.push("#B5CAA0");
        } else if (id === "edu") {
            colorarr.value.push("#7DB9DE");
        } else if (id === "els") {
            colorarr.value.push("#ccc");
        } else if (id === "med") {
            colorarr.value.push("#D9CD90");
        } else if (id === "tra") {
            colorarr.value.push("#F8C3CD");
        } else if (id === "ent") {
            colorarr.value.push("#FAD689");
        } else if (id === "mon") {
            colorarr.value.push("#F9BF45");
        }
    })
}

let chart;
const createChart = () => {
    chart = new Chart(myChart.value.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: data.arr.map(row => row.m_name),
            datasets: [{
                data: data.arr.map(c => parseInt(c.sum)),
                backgroundColor: colorarr.value,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true }

                },
                datalabels: {
                    labels: {
                        title: {
                            color: 'black',
                        }
                    },
                    formatter: (value, context) => {
                        const p = data.arr.map(c => parseInt(c.sum));
                        const totalv = p.reduce((total, p) => total + p, 0);
                        const pval = (value / totalv * 100).toFixed(1);
                        const display = [`${context.chart.data.labels[context.dataIndex]}`, `${pval}%`]
                        return display;
                    }
                }
            },
        },
        plugins: [ChartDataLabels]
    });
}

const updateChart = (newData) => {
    chart.data.labels = newData.map(row => row.m_name);
    chart.data.datasets[0].data = newData.map(c => parseInt(c.sum));
    chart.data.datasets[0].backgroundColor = colorarr.value;
    chart.update();
}
const nodata = () => {
    chart.data.labels = ["沒有資料"];
    chart.data.datasets[0].data = [""];
    chart.update();
}
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
    arr: []
})

const gettoday = () => {
    const url = `${counterStore.publicPath}fetchbydayt.php`;
    axios
        .post(url, {
            type: "1",
            full: today.full
        })
        .then((response) => {
            if (response.data.length > 0) {
                data.arr = response.data;
                getcolorarr();
                createChart();
            } else {
                data.arr = response.data;
                nodata();
            }

        })
        .catch((error) => {
            console.log(error.message);
        });

}
const getbyweek = () => {
    const url = `${counterStore.publicPath}fetchbydayt.php`;
    axios
        .post(url, {
            type: "1",
            full: today.full
        })
        .then((response) => {
            if (response.data.length > 0) {
                data.arr = response.data;
                colorarr.value = [];
                getcolorarr();
                updateChart(response.data);
            } else {
                nodata();
                data.arr = response.data;
            }
        })
        .catch((error) => {
            console.log(error.message);
        });

}

const getbyMon = () => {
    const url = `${counterStore.publicPath}fetchbydayt.php`;
    axios
        .post(url, {
            type: "2",
            full: today.full
        })
        .then((response) => {
            if (response.data.length > 0) {
                data.arr = response.data;
                colorarr.value = [];
                getcolorarr();
                updateChart(response.data);
            } else {
                nodata();
                data.arr = response.data;
            }
        })
        .catch((error) => {
            console.log(error.message);
        });
};
const getbyYear = () => {
    const url = `${counterStore.publicPath}fetchbydayt.php`;
    axios
        .post(url, {
            type: "3",
            full: today.full
        })
        .then((response) => {
            if (response.data.length > 0) {
                data.arr = response.data;
                colorarr.value = [];
                getcolorarr();
                updateChart(response.data);
            } else {
                nodata();
                data.arr = response.data;
            }
        })
        .catch((error) => {
            console.log(error.message);
        });

}
const selectday = ref({
    start: "",
    end: ""
})
const selectopen = ref(false);
const openselect = () => {
    selectopen.value = true;
};
const closeselect = () => {
    selectopen.value = false;
    selectday.value.start = "",
    selectday.value.end = ""
};


const getbyuser = () => {
    if (selectday.value.start == "") {
        openNotificationWithIcon('warning', "未輸入起始日期");

    } else if (selectday.value.end == "") {
        openNotificationWithIcon('warning', "未輸入結束日期");

    } else {
        const url = `${counterStore.publicPath}fetchbydayt.php`;
        axios
            .post(url, {
                type: "4",
                full: today.full,
                start: selectday.value.start,
                end: selectday.value.end,
            })
            .then((response) => {
                if (response.data.length > 0) {
                    data.arr = response.data;
                    colorarr.value = [];
                    getcolorarr();
                    updateChart(response.data);
                    selectopen.value = false;
                } else {
                    nodata();
                    data.arr = response.data;
                    selectopen.value = false;
                }
            })
            .catch((error) => {
                console.log(error.message);
            });

    }


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
const clickbtn = () => {
    const btns = [...document.querySelectorAll('.board .time span')];

    btns.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            btns.forEach((btn) => {
                if (btn === e.target) {
                    btn.style.backgroundColor = `#D1AACB`
                } else {
                    btn.style.backgroundColor = `#B6B6CF`
                }
            })
        })
    })
}


</script>
<template>
    <navp></navp>
    <main>
        <h1>消費分析</h1>
        <div class="sum">
            <div class="container">

            </div>
            <div class="block">
                <div class="row"></div>
                <div class="row"></div>
            </div>
        </div>
        <div class="board">
            <div class="frame">
                <span>
                    支出總額 : <br>
                    {{ mon }}
                </span>
                <div class="dochart">
                    <canvas ref="myChart"></canvas>
                </div>
            </div>

            <div class="time">
                <span style="background-color: #D1AACB;" @click="getbyweek">本週</span>
                <span @click="getbyMon">本月</span>
                <span @click="getbyYear">今年</span>
                <span @click="openselect">自訂</span>
            </div>
            <table>
                <thead>
                    <th>消費類別</th>
                    <th>消費總額</th>
                </thead>
                <tr v-if="pay" v-for="li in pay" :key="li.m_id" :style="{ backgroundColor: rowcolor(li.m_id) }">
                    <td><img :src="getImageUrl(li.m_id)" alt="">{{ li.m_name }}</td>
                    <td>{{ li.sum }}元</td>
                </tr>
                <tr v-else>
                    <td colspan="2">查無資料</td>
                </tr>
            </table>

        </div>
        <div class="settime" v-if="selectopen">
            <h2>輸入日期</h2>
            <div>
                <label for="start">起始日期</label>
                <input type="date" id="start" v-model="selectday.start">
            </div>
            <div>
                <label for="end">結束日期</label>
                <input type="date" id="end" v-model="selectday.end">
            </div>
            <button @click="getbyuser">確定</button>
            <button @click="closeselect">取消</button>
        </div>
    </main>
</template>
<style lang="scss" scoped>
main {
    min-height: 92vh;

    h1 {
        margin: 0 0 0.5rem;
        text-align: center;
        font-size: 20px;
        background-color: $mcolor;
        border-radius: 15px;
        padding: 0.5rem;
    }

    .board {
        .frame {
            border: 2px solid $pur;
            border-radius: 10px;
            position: relative;

            .dochart {
                width: 98%;
                margin: auto;
                height: 47vh;
                canvas{
                    margin: auto;
                }
            }

            span {
                position: absolute;
                @include tc;
                text-align: center;
                line-height: 1.5;
                font-weight: 700;
            }
        }

        .time {
            display: flex;
            gap: 5px;
            margin: 0.5rem 0;

            span {
                width: 25%;
                line-height: 1.5;
                background-color: $mcolor;
                text-align: center;
                border-radius: 5px;
            }
        }

        table {
            width: 100%;

            th {
                padding: 5px;
            }

            tr {
                border: 3px solid #fff;
                ;

                td {
                    width: 50%;
                    text-align: center;
                    padding: 2px;

                    img {
                        height: 40px;
                        margin-right: 5px;
                    }
                }
            }
        }

    }

    .settime {
        position: fixed;
        @include tc;
        background-color: #fff;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 0 5px $mcolor;
        width: 80vw;

        h2 {
            font-size: 20px;
            text-align: center;
        }

        div {
            margin-top: 1rem;
        }

        label {
            display: block;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        input {
            line-height: 2;
            display: block;
            width: 100%;
        }

        button {
            display: block;
            width: 80%;
            margin: 1rem auto 0;
            border: none;
            padding: 10px 5px;
            border-radius: 5px;

            &:nth-child(4) {
                background-color: $subcolor;
                transition: .2s;

                &:active {
                    background-color: $pig;
                }
            }
        }
    }
}</style>