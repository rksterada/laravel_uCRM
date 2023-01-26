<script setup>
import dayjs from "dayjs";

const props = defineProps({
    data: Object,
});

const dateFormat = (e) => {
    if (e.length === 8) {
        return dayjs(e).format("YYYY/MM/DD");
    } else if (e.length === 6) {
        return dayjs(e).format("YYYY/MM");
    } else {
        return e;
    }
};
</script>

<template>
    <div
        v-if="
            data.type === 'perDay' ||
            data.type === 'perMonth' ||
            data.type === 'perYear'
        "
        class="lg:w-2/3 w-full mx-auto overflow-auto mt-20"
    >
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                    >
                        年月日
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        金額
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" :key="item.date">
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ dateFormat(item.date) }}
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ Number(item.total).toLocaleString() }} 円
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div
        v-if="data.type === 'decile'"
        class="lg:w-2/3 w-full mx-auto overflow-auto mt-20"
    >
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                    >
                        グループ
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        平均
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        合計金額
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        構成比
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in data.data" :key="item.date">
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ item.decile }}
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ Number(item.average).toLocaleString() }} 円
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ Number(item.totalPerGroup).toLocaleString() }} 円
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ item.totalRatio }} %
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div
        v-if="data.type === 'rfm'"
        class="lg:w-2/3 w-full mx-auto overflow-auto mt-20"
    >
        <h2 class="text-center text-2xl mb-8">RFM 分析結果</h2>

        <div class="reactive">
            <label class="leading-7 text-sm text-gray-600">合計人数</label>
            <div
                class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            >
                {{ data.totals }} 人
            </div>
        </div>

        <h2 class="text-center text-2xl mt-10 mb-3">RFMランク毎の人数</h2>
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                    >
                        Rank
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        R
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        F
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        M
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="rfm in data.eachCount" :key="rfm.rank">
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rfm.rank }}
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rfm.r }} 人
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rfm.f }} 人
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rfm.m }} 人
                    </td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-center text-2xl mt-10 mb-3">RとFの集計表</h2>
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                    >
                        rRank
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        f_5
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        f_4
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        f_3
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        f_2
                    </th>
                    <th
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                    >
                        f_1
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="rf in data.data" :key="rf.rRank">
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rf.rRank }}
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rf.f_5 }} 人
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rf.f_4 }} 人
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rf.f_3 }} 人
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rf.f_2 }} 人
                    </td>
                    <td class="border-b-2 border-gray-200 px-4 py-3">
                        {{ rf.f_1 }} 人
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
