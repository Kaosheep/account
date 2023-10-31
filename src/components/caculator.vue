<script setup>
import { ref, reactive, computed, onMounted, watch } from 'vue';
const btn = ref([
    { order: 15, name: '0', value: '0', type: 'operation', class: 'ze' },
    { order: 1, name: '1', value: '1', type: 'operation', class: '' },
    { order: 2, name: '2', value: '2', type: 'operation', class: '' },
    { order: 3, name: '3', value: '3', type: 'operation', class: '' },
    { order: 5, name: '4', value: '4', type: 'operation', class: '' },
    { order: 6, name: '5', value: '5', type: 'operation', class: '' },
    { order: 7, name: '6', value: '6', type: 'operation', class: '' },
    { order: 9, name: '7', value: '7', type: 'operation', class: '' },
    { order: 10, name: '8', value: '8', type: 'operation', class: '' },
    { order: 11, name: '9', value: '9', type: 'operation', class: '' },
    { order: 4, name: '+', value: '+', type: 'operation', class: 'operation' },
    { order: 8, name: '—', value: '-', type: 'operation', class: 'operation' },
    { order: 12, name: '×', value: '*', type: 'operation', class: 'operation' },
    { order: 16, name: '/', value: '/', type: 'operation', class: 'operation' },
    { order: 13, name: '=', value: '=', type: 'calculate', class: 'result' },
    { order: 14, name: 'c', value: 'c', type: 'reset', class: 'result' },
]);
const inputnum = ref("");
const mem = ref("");
const va = ref("");

const pusht = (v, type) => {
    mem.value += v;
    if (type == "operation") {
       inputnum.value += v;

       return inputnum.value;
    } else if (type == "calculate") {
        let res = eval((inputnum.value).replace(/\b0+(\d)/g, '$1'));
        console.log(res);
        inputnum.value=res;
        return va.value = res;
    }else if (type == "reset") {
        let res = 0;
        inputnum.value="";
        mem.value ="";
        console.log(res);
    }

}



const emit = defineEmits(["cal"]);
const cal = () => {
    emit("cal", inputnum)
}
</script>
<template>
    <!-- <div class="inputnum">
        <input type="text" v-model="mem" readonly>
    </div> -->
    <div class="block">
        <div v-for="b in btn" :class="b.class" :style="`order:${b.order}`" @click="[cal(b.value), pusht(b.value, b.type)]">{{
            b.value
        }}</div>
    </div>
</template>
<style lang="scss" scoped>
.inputnum {
    width: 80%;
    margin: auto;

    input {
        margin-left: auto;
        display: block;
        border: none;
        line-height: 1.2;
        background-color: #cccccc8c;
        padding: 3px;
    }

    pointer-events: none;
}

.block {
    height: 100%;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    flex-wrap: wrap;
    padding: 1rem;
    margin: auto;
    gap: 0.5rem;

    div {
        width: 100%;
        @include fc;
        box-shadow: 0 0 3px $mcolor;
        border-radius: 15px;
        transition: .2s;
        font-size: 22px;

        &:active {
            background-color: $subcolor;
        }
    }

    .result {
        background-color: $pur;
        font-weight: 700;
    }
}
</style>