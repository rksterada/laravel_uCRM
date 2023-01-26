<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { reactive, onMounted } from "vue";
import { getToday } from "@/common";
import Chart from "@/Components/Chart.vue";
import ResultTable from "@/Components/ResultTable.vue";

onMounted(() => {
    form.startDate = getToday();
    form.endDate = getToday();
});

const form = reactive({
    startDate: null,
    endDate: null,
    type: "perDay",
    rfmPrms: [14, 28, 60, 90, 6, 4, 3, 2, 300000, 200000, 100000, 30000],
});

const data = reactive({});

const getData = async () => {
    try {
        await axios
            .get("/api/analysis/", {
                params: {
                    startDate: form.startDate,
                    endDate: form.endDate,
                    type: form.type,
                    rfmPrms: form.rfmPrms,
                },
            })
            .then((res) => {
                data.data = res.data.data;
                if (res.data.labels) {
                    data.labels = res.data.labels;
                }
                if (res.data.eachCount) {
                    data.eachCount = res.data.eachCount;
                }
                data.totals = res.data.totals;
                data.type = res.data.type;
            });
    } catch (e) {
        console.log(e.message);
    }
};
</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                データ分析
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getData">
                            <div
                                class="flex lg:w-2/3 w-full sm:flex-row flex-col mx-auto px-8 sm:space-x-4 sm:space-y-0 space-y-4 sm:px-0 items-end"
                            >
                                <div class="relative flex-grow w-full">
                                    <label
                                        for="per"
                                        class="leading-7 text-sm text-gray-600"
                                        >分析方法
                                    </label>
                                    <select
                                        id="per"
                                        name="per"
                                        v-model="form.type"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-5 leading-8 transition-colors duration-200 ease-in-out"
                                    >
                                        <option value="perDay" selected>
                                            日別
                                        </option>
                                        <option value="perMonth">月別</option>
                                        <option value="perYear">年別</option>
                                        <option value="decile">
                                            デシル分析
                                        </option>
                                        <option value="rfm">RFM分析</option>
                                    </select>
                                </div>

                                <div class="relative flex-grow w-full">
                                    <label
                                        for="startDate"
                                        class="leading-7 text-sm text-gray-600"
                                        >From:
                                    </label>
                                    <input
                                        type="date"
                                        id="startDate"
                                        name="startDate"
                                        v-model="form.startDate"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    />
                                </div>

                                <div class="relative flex-grow w-full">
                                    <label
                                        for="endDate"
                                        class="leading-7 text-sm text-gray-600"
                                        >To:
                                    </label>
                                    <input
                                        type="date"
                                        id="endDate"
                                        name="endDate"
                                        v-model="form.endDate"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                    />
                                </div>
                            </div>

                            <div v-if="form.type === 'rfm'" class="my-8">
                                <table
                                    class="table-auto mx-auto text-left whitespace-no-wrap"
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                            >
                                                ランク
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                            >
                                                R: 最新購入日 (○日以内)
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                            >
                                                F: 累計購入回数 (○回以上)
                                            </th>
                                            <th
                                                class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                            >
                                                M: 累計購入金額 (○円以上)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                5
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[0]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[4]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[8]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                4
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[1]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[5]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[9]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                3
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[2]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[6]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[10]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                2
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[3]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[7]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                            <td
                                                class="border-b-2 border-gray-200 px-4 py-3"
                                            >
                                                <input
                                                    type="number"
                                                    v-model="form.rfmPrms[11]"
                                                    class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                <button
                                    class="mt-5 mb-5 flex mx-auto text-white bg-blue-500 border-0 py-2 px-6 focus:outline-none hover:bg-blue-600 rounded text-lg"
                                >
                                    分析
                                </button>
                            </div>
                        </form>

                        <div v-show="data.data">
                            <div v-if="data.type != 'rfm'">
                                <Chart :data="data" />
                            </div>
                            <ResultTable :data="data" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
