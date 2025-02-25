<script setup lang="ts">
import { ref, computed } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div
            v-if="$page.props.auth.user"
            class="flex justify-between fixed top-0 w-full bg-gray-900 z-50 px-4 h-8"
        >
            <nav class="flex gap-8 my-auto text-white">
                <Link :href="route('Home')"> Kotisivu</Link>
                <Link :href="route('admin.dashboard')"> Hallinta</Link>
            </nav>
            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <!-- Settings Dropdown -->
                <div class="relative ms-3">
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-2 py-1 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                >
                                    {{ $page.props.auth.user.name }}

                                    <svg
                                        class="-me-0.5 ms-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <template #content>
                            <DropdownLink :href="route('profile.edit')">
                                Profile
                            </DropdownLink>
                            <DropdownLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            <div class="mt-8">
                <slot />
            </div>
        </main>
    </div>
</template>
