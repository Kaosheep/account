<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import axios from 'axios';

const myChart = ref(null);

onMounted(() => {
    timeFormate();
    gettoday();

});

const pay = computed(() => {
    if(data.arr){
        return data.arr.filter((d) => d.t === "0");
    }else{
        return 0
    }
    
});
const earn = computed(() => {
    return data.arr.filter((d) => d.t === "1")
})
const payid = computed(() => {
    return data.arr.map(row => row.m_id)
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


const createChart = () => {

    new Chart(myChart.value.getContext('2d'), {
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
            plugins: {
                legend: {
                    position: 'right',
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
                        return `${context.chart.data.labels[context.dataIndex]} : ${pval}%`;
                    }
                }
            },
        },
        plugins: [ChartDataLabels]
    });
}

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

    today.full = String(`${today.year}-${today.month}-${today.date}`);
    const dayNames = ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六"];
    today.day = dayNames[new Date().getDay()];
};

const data = reactive({
    arr: []
})

const gettoday = () => {
    const url = `http://localhost/dashboard/public/php/fetchbyday.php`;
    axios
        .post(url, {
            full: today.full
        })
        .then((response) => {
            data.arr = response.data;
            getcolorarr();
            createChart();
        })
        .catch((error) => {
            console.log(error.message);
        });

}
const getbyweek = () => {
    const url = `http://localhost/dashboard/public/php/fetchbydayt.php`;
    axios
        .post(url, {
            type: "1",
            full: today.full
        })
        .then((response) => {
            data.arr = response.data;
            getcolorarr();
            createChart();
        })
        .catch((error) => {
            console.log(error.message);
        });

}
const getbyMon = () => {
    const url = `http://localhost/dashboard/public/php/fetchbydayt.php`;
    axios
        .post(url, {
            type: "2",
            full: today.full
        })
        .then((response) => {
            data.arr = response.data;
            getcolorarr();
            myChart.update();
        })
        .catch((error) => {
            console.log(error.message);
        });

}
const getbyYear = () => {
    const url = `http://localhost/dashboard/public/php/fetchbydayt.php`;
    axios
        .post(url, {
            type: "3",
            full: today.full
        })
        .then((response) => {
            data.arr = response.data;
            getcolorarr();
            myChart.update();
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



</script>
<template>
    <main>
        <div class="sum">
            <div class="container">

            </div>
            <div class="block">
                <div class="row"></div>
                <div class="row"></div>
            </div>
        </div>
        <div class="board">
            <div class="time">
                <span @click="getbyweek">本週</span>
                <span @click="getbyMon">本月</span>
                <span @click="getbyYear">今年</span>
                <span>自訂</span>
            </div>
            <div v-if="data.arr" class="dochart">
                <canvas  ref="myChart"></canvas>
            </div>
            <div v-else class="nochart">
                <p>尚無紀錄</p>
            </div>
            <table>
                <thead>
                    <th>消費類別</th>
                    <th>消費總額</th>
                </thead>
                <tr v-for="li in pay" :key="li.m_id" :style="{ backgroundColor: rowcolor(li.m_id) }">
                    <td><img :src="getImageUrl(li.m_id)" alt="">{{ li.m_name }}</td>
                    <td>{{ li.sum }}元</td>
                </tr>
            </table>
        </div>
    </main>
</template>
<style lang="scss" scoped>
main {
    .board {
        .dochart {
            width: 80%;
            margin: auto;
            height: 38vh;
        }
        .nochart{
            width: 80%;
            margin: auto;
            height: 38vh;
        }
        table {
            tr {
                td {
                    img {
                        height: 40px;
                    }
                }
            }
        }
    }
}
</style>