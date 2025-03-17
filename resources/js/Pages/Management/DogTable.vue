<script setup lang="ts">
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import ManagementLayout from "../../Layouts/ManagementLayout.vue";
import { ref, defineProps, onMounted, computed } from "vue";
import TextInput from "../../Components/TextInput.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
defineOptions({ layout: ManagementLayout });

interface Dog {
    name: string;
    nickname: string;
    birthday: string;
    gender: "male" | "female";
    pedigree_url: string;
    owners: { id: number; name: string }[];
    medical_examinations: { id: number; date: string; description: string }[];
    dog_group: string;
    thumbnail: string | undefined;
    medium: string | undefined;
    original: string | undefined;
    group: {
        id: number;
        name: string;
    };
}

const props = defineProps<{
    dogs: Dog[];
}>();

// dog table
const filterGroup = ref<"all" | "males" | "females" | "memoriam" | "not_own">(
    "all"
);
const tableSearchValue = ref("");

const filteredDogs = computed(() => {
    if (filterGroup.value === "all") return props.dogs;
    return props.dogs.filter((dog) => dog.group.name === filterGroup.value);
});

const filteredBySearch = computed(() => {
    if (!tableSearchValue.value) return filteredDogs.value;
    return filteredDogs.value.filter(
        (dog) =>
            dog.name
                .toLowerCase()
                .includes(tableSearchValue.value.toLowerCase()) ||
            dog.nickname
                .toLowerCase()
                .includes(tableSearchValue.value.toLowerCase())
    );
});

onMounted(() => {
    console.log(props.dogs);
});
</script>
<template>
    <div
        class="max-w-5xl mx-auto w-full relative sm:rounded-lg lg:my-8 max-h-full"
    >
        <!-- Header -->
        <div class="flex gap-8 px-4 py-2">
            <div class="">
                <label for="table-search" class="sr-only">Hae</label>
                <div class="relative m-1">
                    <div
                        class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
                    >
                        <svg
                            class="w-4 h-4 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>
                    <TextInput
                        type="text"
                        id="table-search"
                        class="block pt-2 ps-10 text-sm"
                        placeholder="Etsi koiria"
                        v-model="tableSearchValue"
                    />
                </div>
            </div>
            <div>
                <select
                    name="groupFilter"
                    id="groupFilter"
                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    :class="{ 'text-gray-500': filterGroup === 'all' }"
                    v-model="filterGroup"
                >
                    <option selected value="all" class="text-gray-500">
                        Valitse Ryhmä
                    </option>
                    <option
                        value="males"
                        :class="{
                            ' bg-gray-200': filterGroup === 'males',
                            'text-gray-900': filterGroup !== 'males',
                        }"
                    >
                        Omat urokset
                    </option>
                    <option
                        value="females"
                        :class="{
                            ' bg-gray-200': filterGroup === 'females',
                            'text-gray-900': filterGroup !== 'females',
                        }"
                    >
                        Omat nartut
                    </option>
                    <option
                        value="memoriam"
                        :class="{
                            ' bg-gray-200': filterGroup === 'memoriam',
                            'text-gray-900': filterGroup !== 'memoriam',
                        }"
                    >
                        Menehtyneet
                    </option>
                    <option
                        value="not_own"
                        :class="{
                            ' bg-gray-200': filterGroup === 'not_own',
                            'text-gray-900': filterGroup !== 'not_own',
                        }"
                    >
                        Muut
                    </option>
                </select>
            </div>
            <PrimaryButton class="ml-auto">Luo Koira</PrimaryButton>
        </div>

        <!-- Main section -->
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 overflow-auto"
        >
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <th scope="col" class="px-4 py-2">Kuva</th>
                <th scope="col" class="px-4 py-2">Kutsumanimi</th>
                <th scope="col" class="px-4 py-2">Virallinen nimi</th>
                <th scope="col" class="px-4 py-2">Syntymäpäivä</th>
                <th scope="col" class="px-4 py-2">Sukupuoli</th>
                <th scope="col" class="px-4 py-2">Ryhmä</th>
                <th scope="col" class="px-4 py-2"></th>
            </thead>
            <tbody>
                <tr
                    v-for="dog in filteredBySearch"
                    class="bg-white border-b border-gray-200 hover:bg-gray-50"
                >
                    <td class="max-h-20">
                        <img
                            v-if="dog.thumbnail"
                            :src="dog.thumbnail"
                            alt="kuvat koirasta"
                            class="max-h-16"
                        />
                    </td>
                    <td class="px-4 py-2">{{ dog.nickname }}</td>
                    <td class="px-4 py-2">{{ dog.name }}</td>
                    <td class="px-4 py-2">{{ dog.birthday }}</td>
                    <td class="px-4 py-2">{{ dog.gender }}</td>
                    <td class="px-4 py-2">
                        {{ dog.group?.name }}
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        <SecondaryButton class="">Näytä</SecondaryButton>
                        <SecondaryButton class="bg-gray-300"
                            >Muokkaa</SecondaryButton
                        >
                    </td>
                </tr>
                <tr v-if="filteredBySearch.length === 0">
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Ei koiria löytynyt
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
