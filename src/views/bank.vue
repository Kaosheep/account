<script setup>
import { ref, reactive, computed, onMounted } from 'vue';
import Chart from 'chart.js/auto';
import ChartDataLabels from 'chartjs-plugin-datalabels';
import axios from 'axios';
import { notification } from 'ant-design-vue';
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
    chart.data.datasets[0].data = ["0"];
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
    const url = `http://localhost/dashboard/public/php/bank.php`;
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
    const url = `http://localhost/dashboard/public/php/bank.php`;
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
    const url = `http://localhost/dashboard/public/php/bank.php`;
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
    const url = `http://localhost/dashboard/public/php/bank.php`;
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
        const url = `http://localhost/dashboard/public/php/bank.php`;
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
</script>
<template >
    <div class="pchart">
        <canvas ref="myChart"></canvas>
    </div>
</template>
<style scoped lang="scss"></style>