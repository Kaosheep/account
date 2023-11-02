<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import axios from 'axios';
import { notification } from 'ant-design-vue';
import pattern from 'patternomaly';
import navp from '@/components/navp.vue'

const openNotificationWithIcon = (type, w) => {
    notification[type]({
        message: w,
    });
};
const myChart = ref(null);

onMounted(() => {
    timeFormate();
    getbyMon();
    clickbtn();
    eachm();
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
    const idarr = data.arr.map(row => row.s_id);
    idarr.forEach((id) => {
        if (id === "mon_s") {
            colorarr.value.push('#B6B6CF');
        } else if (id === "mon_o") {
            colorarr.value.push("#F5DAC2");
        } else if (id === "mon_p") {
            colorarr.value.push("#B5CAA0");
        } else if (id === "mon_r") {
            colorarr.value.push("#7DB9DE");
        }
    })
}
let chart;
const createChart = () => {

    chart = new Chart(myChart.value.getContext('2d'), {
        type: 'pie',
        data: {
            labels: data.arr.map(row => row.sub_name),
            datasets: [{
                data: data.arr.map(c => parseInt(c.sum)),
                backgroundColor: pattern.generate(Object.values(colorarr.value))
            },
            ]
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
                        if (pval > 5) {
                            const display = [`${context.chart.data.labels[context.dataIndex]}`, `${pval}%`]
                            return display;
                        } else {
                            return ""
                        }

                    },
                }
            },
        },
        plugins: [ChartDataLabels]
    });
}

const updateChart = (newData) => {
    chart.data.labels = newData.map(row => row.sub_name);
    chart.data.datasets[0].data = newData.map(c => parseInt(c.sum));
    chart.data.datasets[0].backgroundColor = pattern.generate(Object.values(colorarr.value));
    chart.update();
}
const nodata = () => {
    chart.data.labels = ["沒有資料"];
    chart.data.datasets[0].data = ["0"];
    chart.update();
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
    arr: [],
    monarr0: [],
    monarr1: [],
    dltarr: []
})
const merarr = data.monarr0.concat(data.monarr1);
const getbyMon = () => {
    const url = `http://localhost/dashboard/public/php/bank.php`;
    axios
        .post(url, {
            type: "1",
            full: today.full
        })
        .then((response) => {
            if (response.data) {
                if (chart) {
                    data.arr = response.data[1];
                    data.dltarr = response.data[2];
                    colorarr.value = [];
                    getcolorarr();
                    updateChart(response.data[1]);
                } else {
                    data.arr = response.data[1];
                    data.dltarr = response.data[2];
                    getcolorarr();
                    createChart();
                }

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
    const url = `http://localhost/dashboard/public/php/bank.php`;
    axios
        .post(url, {
            type: "2",
            full: today.full
        })
        .then((response) => {
            if (response.data) {
                data.arr = response.data[1];
                data.dltarr = response.data[2];
                colorarr.value = [];
                getcolorarr();
                updateChart(response.data[1]);
            } else {
                nodata();
                data.arr = response.data[1];
                data.dltarr = response.data[2];
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
        const url = `http://localhost/dashboard/public/php/bank.php`;
        axios
            .post(url, {
                type: "3",
                full: today.full,
                start: selectday.value.start,
                end: selectday.value.end,
            })
            .then((response) => {
                if (response.data) {
                    data.arr = response.data[1];
                    data.dltarr = response.data[2];
                    colorarr.value = [];
                    getcolorarr();
                    updateChart(response.data[1]);
                    selectopen.value = false;
                } else {
                    nodata();
                    data.arr = response.data[1];
                    data.dltarr = response.data[2];
                    selectopen.value = false;
                }
            })
            .catch((error) => {
                console.log(error.message);
            });

    }


}
const clickbtn = () => {
    const btns = [...document.querySelectorAll('.board .time span')];
    let abtn = null;
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
const limit = ref("6")

const eachm = () => {
    const url = `http://localhost/dashboard/public/php/bankmon.php`;
    axios
        .post(url, {
            limit: limit.value
        })
        .then((response) => {
            if (response.data) {
                data.monarr0 = response.data[1];
                data.monarr1 = response.data[2];
                if (lchart) {
                    updatelChart(response.data[1], response.data[2]);
                } else {
                    createlChart();
                }

            } else {
                data.monarr0 = response.data[1];
                data.monarr1 = response.data[2];
                noldata();
            }

        })
        .catch((error) => {
            console.log(error.message);
        });

}
const updatelChart = (newData1, newData2) => {
    lchart.data.labels = newData1.map(row => row.month);
    lchart.data.datasets[0].data = newData1.map(c => parseInt(c.sum));
    lchart.data.datasets[1].data = newData2.map(c => parseInt(c.sum));
    lchart.update();
}
const noldata = () => {
    lchart.data.labels = ["沒有資料"];
    lchart.data.datasets[0].data = ["0"];
    lchart.update();
}

const mylChart = ref(null)
let lchart;
const createlChart = () => {

    lchart = new Chart(mylChart.value.getContext('2d'), {
        type: 'line',
        data: {
            labels: data.monarr0.map(row => row.month),
            datasets: [{
                label: '當月收入',
                data: data.monarr0.map(c => parseInt(c.sum)),
            },
            {
                label: '當月支出',
                data: data.monarr1.map(c => parseInt(c.sum)),
            }]
        },
        options: {
            layout: {
                padding: 15,
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true },
                },
            },
            scales: {

                x: {
                    reverse: true,
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        },
    });
}
</script>
<template>
    <navp></navp>
    <main>
        <h1>收入總覽</h1>

        <div class="lchartb">
            <div class="sele">
                <h2>近{{ limit }}個月收入</h2>
                <select v-model="limit" @change="eachm">
                    <option value="6" selected>6筆</option>
                    <option value="12">12筆</option>
                </select>
            </div>

            <div class="lchart">
                <canvas ref="mylChart"></canvas>
            </div>
            <div class="block">
                <div class="thead">
                    <span>月份</span>
                    <span>收入總額</span>
                    <span>支出總額</span>
                </div>
                <div class="tbody">
                    <div class="col">
                        <div class="row" v-for="m in data.monarr0">
                            <span>{{ m.month }}</span>
                            <span>{{ m.sum }} 元</span>
                        </div>
                    </div>
                    <div class="col2">

                        <div class="row" v-for="p in data.monarr1">
                            <span>{{ p.sum }} 元</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="pchartb">
            <h2>收入來源</h2>
            <div class="pchart">
                <canvas ref="myChart"></canvas>
            </div>
            <div class="time">
                <span style="background-color: #D1AACB;" @click="getbyMon">本月</span>
                <span @click="getbyYear">今年</span>
                <span @click="openselect">自訂</span>
            </div>
            <table>
                <thead>
                    <th>收入來源</th>
                    <th>總額</th>
                </thead>
                <tr v-for="s in data.arr">
                    <td>{{ s.sub_name }}</td>
                    <td>{{ s.sum }} 元</td>
                </tr>
            </table>
        </div>

        <div class="mondlt">
            <h2>收入明細</h2>
            <table>
                <thead>
                    <th>收入日期</th>
                    <th>收入類別</th>
                    <th>收入金額</th>
                </thead>
                <tbody>
                    <tr v-for="d in data.dltarr">
                        <td>{{ d.con_day }}</td>
                        <td>{{ d.sub_name }}</td>
                        <td>{{ d.con_sum }} 元</td>
                    </tr>
                </tbody>

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
<style scoped lang="scss">
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

    .sele {
        h2 {
            width: 80%;
            display: inline-block;
            font-size: 16px;
            text-align: center;
            line-height: 2;
        }

        select {
            width: 20%;
            text-align: center;
            line-height: 2;
        }
    }

    .lchartb {
        .lchart {
            height: 35vh;
        }

        .block {
            width: 100%;

            .thead {
                width: 100%;
                border-bottom: 1px solid $pur;
                line-height: 2;
                span {
                    display: inline-block;
                    width: 32.3%;
                    text-align: center;

                }

            }

            .tbody {
                display: flex;
                height: 30vh;
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

                .col {
                    width: 66%;

                    .row {
                        width: 100%;
                        line-height: 2;

                        &:nth-child(2n) {
                            background-color: $mcolor;
                        }

                        span {
                            display: inline-block;
                            width: 50%;
                            text-align: center;
                        }
                    }
                }

                .col2 {
                    width: 33%;

                    .row {
                        line-height: 2;
                        text-align: center;
                        &:nth-child(2n) {
                            background-color: $mcolor;

                        }
                    }
                }
            }
        }

    
    }

    .pchartb {
        h2 {
            font-size: 16px;
            text-align: center;
            line-height: 2;
        }



        table {
            width: 100%;

            thead {
                border-bottom: 1px solid $mcolor;
                line-height: 2;
            }

            tr {
                border-bottom: 1px solid $mcolor;

                td {
                    text-align: center;
                    line-height: 2;
                }
            }
        }
    }

    .pchartb,
    .mondlt {
        h2 {
            background-color: $pur;
            border-radius: 15px;
            margin: 0.5rem 0;
        }
    }
    .pchartb{
        .pchart{
            canvas{
                margin: auto;
            }
        }
    }
    .mondlt {
        h2 {
            font-size: 16px;
            text-align: center;
            line-height: 2;
        }

        table {
            width: 100%;

            thead {
                width: 100%;
                display: block;
                border-bottom: 1px solid $mcolor;
                line-height: 2;

                th {
                    width: 500px;

                }
            }

            tbody {
                display: block;
                height: 30vh;
                overflow-y: scroll;
                width: 100%;

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

                tr {
                    border-bottom: 1px solid $mcolor;
                    width: 100%;
                    td {
                        width: 500px;
                        text-align: center;
                        line-height: 2;
                    }
                }
            }

        }

    }

    .time {
        display: flex;
        gap: 5px;
        margin: 0.5rem 0;

        span {
            width: 33.33%;
            line-height: 1.5;
            background-color: $mcolor;
            text-align: center;
            border-radius: 5px;
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
}
</style>