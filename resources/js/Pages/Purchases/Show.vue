<script setup>
import { Inertia } from "@inertiajs/inertia";
import { onMounted, computed, reactive, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import dayjs from "dayjs";

const props = defineProps({
    items: Array,
    order: Array,
});

onMounted(() => {
    console.log(props.items);
    console.log(props.order);
});
</script>

<template>
    <Head title="購買履歴(詳細)" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購買履歴(詳細)
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storePurchase">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="date"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >日付
                                                    </label>
                                                    <div
                                                        id="date"
                                                        name="date"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        {{
                                                            dayjs(
                                                                props.order[0]
                                                                    .created_at
                                                            ).format(
                                                                "YYYY/MM/DD"
                                                            )
                                                        }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        for="customer"
                                                        class="leading-7 text-sm text-gray-600"
                                                        >会員名
                                                    </label>
                                                    <div
                                                        id="date"
                                                        name="date"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        {{
                                                            props.order[0]
                                                                .customer_name
                                                        }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        class="leading-7 text-sm text-gray-600"
                                                        >商品・サービス
                                                    </label>

                                                    <table
                                                        class="table-auto w-full text-left whitespace-no-wrap"
                                                    >
                                                        <thead>
                                                            <tr>
                                                                <th
                                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl"
                                                                >
                                                                    ID
                                                                </th>
                                                                <th
                                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                                >
                                                                    商品名
                                                                </th>
                                                                <th
                                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                                >
                                                                    価格
                                                                </th>
                                                                <th
                                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                                >
                                                                    数量
                                                                </th>
                                                                <th
                                                                    class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                                                                >
                                                                    小計
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr
                                                                v-for="item in props.items"
                                                            >
                                                                <td
                                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                                >
                                                                    {{
                                                                        item.item_id
                                                                    }}
                                                                </td>
                                                                <td
                                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                                >
                                                                    {{
                                                                        item.item_name
                                                                    }}
                                                                </td>
                                                                <td
                                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                                >
                                                                    {{
                                                                        item.item_price.toLocaleString()
                                                                    }}
                                                                    円
                                                                </td>
                                                                <td
                                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                                >
                                                                    {{
                                                                        item.quantity
                                                                    }}
                                                                </td>
                                                                <td
                                                                    class="border-b-2 border-gray-200 px-4 py-3"
                                                                >
                                                                    {{
                                                                        item.subtotal.toLocaleString()
                                                                    }}
                                                                    円
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        class="leading-7 text-sm text-gray-600"
                                                        >合計
                                                    </label>
                                                    <div
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        {{
                                                            Number(
                                                                props.order[0]
                                                                    .total
                                                            ).toLocaleString()
                                                        }}
                                                        円
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label
                                                        class="leading-7 text-sm text-gray-600"
                                                        >ステータス
                                                    </label>
                                                    <div
                                                        v-if="
                                                            props.order[0]
                                                                .status == true
                                                        "
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        未キャンセル
                                                    </div>
                                                    <div
                                                        v-if="
                                                            props.order[0]
                                                                .status == false
                                                        "
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        キャンセル済
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                v-if="
                                                    props.order[0].status ==
                                                    false
                                                "
                                                class="p-2 w-full"
                                            >
                                                <div class="relative">
                                                    <label
                                                        class="leading-7 text-sm text-gray-600"
                                                        >キャンセル日
                                                    </label>
                                                    <div
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        {{
                                                            dayjs(
                                                                props.order[0]
                                                                    .updated_at
                                                            ).format(
                                                                "YYYY/MM/DD"
                                                            )
                                                        }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                v-if="
                                                    props.order[0].status ==
                                                    true
                                                "
                                                class="p-2 w-full"
                                            >
                                                <Link
                                                    as="button"
                                                    :href="
                                                        route(
                                                            'purchases.edit',
                                                            {
                                                                purchase:
                                                                    props
                                                                        .order[0]
                                                                        .id,
                                                            }
                                                        )
                                                    "
                                                    class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                                >
                                                    編集
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
