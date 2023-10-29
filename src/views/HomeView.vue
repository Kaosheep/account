<script setup>
import { onMounted, ref, reactive } from "vue";

const count = ref(0);
let arr = reactive({
  data:{}
});
const obj = reactive({
  name: "sheep",
  age: 28
})
const incre = () => {
  count.value++;
}
onMounted(() => {

})
</script>

<template>
  
</template>

<style scoped>
</style>