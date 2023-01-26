<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0"
    >
        <div
            v-if="canLogin"
            class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
        >
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 dark:text-gray-500 underline"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                    >Login</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                    >Register</Link
                >
            </template>
        </div>

        <div class="lg:py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div
                                class="container mx-auto flex px-5 py-24 items-center justify-center flex-col"
                            >
                                <ApplicationLogo
                                    class="w-50 h-50 fill-current text-gray-500"
                                />
                                <div class="text-center lg:w-2/3 w-full mt-8">
                                    <h1
                                        class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900"
                                    >
                                        Welcome To Application
                                    </h1>
                                    <p class="mb-8 leading-relaxed">
                                        Meggings kinfolk echo park stumptown
                                        DIY, kale chips beard jianbing tousled.
                                        Chambray dreamcatcher trust fund, kitsch
                                        vice godard disrupt ramps hexagon
                                        mustache umami snackwave tilde chillwave
                                        ugh. Pour-over meditation PBR&amp;B
                                        pickled ennui celiac mlkshk freegan
                                        photo booth af fingerstache pitchfork.
                                    </p>

                                    <div v-if="canLogin">
                                        <Link
                                            as="button"
                                            v-if="$page.props.auth.user"
                                            :href="route('dashboard')"
                                            class="text-sm text-gray-700 dark:text-gray-500 underline"
                                            >Dashboard</Link
                                        >

                                        <template v-else>
                                            <div class="flex justify-center">
                                                <Link
                                                    as="button"
                                                    :href="route('login')"
                                                    class="inline-flex text-white bg-sky-500 border-0 py-2 px-6 focus:outline-none hover:bg-sky-600 rounded text-lg"
                                                    >Login</Link
                                                >

                                                <Link
                                                    as="button"
                                                    v-if="canRegister"
                                                    :href="route('register')"
                                                    class="ml-8 inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg"
                                                    >Register</Link
                                                >
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
