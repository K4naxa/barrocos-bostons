<script setup lang="ts">
import AuthenticatedLayout from "../../Layouts/AuthenticatedLayout.vue";
import ManagementLayout from "../../Layouts/ManagementLayout.vue";
import { ref, defineProps, onMounted, computed } from "vue";
import TextInput from "../../Components/TextInput.vue";
import SecondaryButton from "../../Components/SecondaryButton.vue";
defineOptions({ layout: ManagementLayout });

interface Owner {
    id: number;
    name: string;
}

interface MedicalExamination {
    id: number;
    date: string;
    description: string;
}

interface Dog {
    name: string;
    nickname: string;
    birthday: string;
    gender: "male" | "female";
    pedigree_url: string;
    owners: Owner[];
    medical_examinations: MedicalExamination[];
}

const props = defineProps<{
    dogs: Dog[];
}>();

// dog table
const filterGroup = ref("all");

const filteredDogs = computed(() => {
    if (filterGroup.value === "all") return props.dogs;
    return props.dogs.filter((dog) => dog.dog_group === filterGroup.value);
});
</script>
<template>
    <div
        class="max-w-5xl mx-auto w-full relative overflow-x-auto shadow-md sm:rounded-lg lg:my-8"
    >
        <div class="flex gap-8">
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
                    />
                </div>
            </div>
            <div class="">
                <label
                    class="block text-sm font-medium text-gray-700"
                    for="dog_filtering"
                    >Näytä seuravat</label
                >
                <div class="mt-1 space-x-4">
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="filterGroup"
                            value="all"
                            class="form-radio"
                        />
                        <span class="ml-2">Kaikki</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="filterGroup"
                            value="male"
                            class="form-radio"
                        />
                        <span class="ml-2">Omat urokset</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="filterGroup"
                            value="female"
                            class="form-radio"
                        />
                        <span class="ml-2">Omat Naaraat</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="filterGroup"
                            value="memoriam"
                            class="form-radio"
                        />
                        <span class="ml-2">Menehtyneet</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="filterGroup"
                            value="not_own"
                            class="form-radio"
                        />
                        <span class="ml-2">Muut</span>
                    </label>
                </div>
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <th scope="col" class="px-6 py-3">Kutsumanimi</th>
                <th scope="col" class="px-6 py-3">Virallinen nimi</th>
                <th scope="col" class="px-6 py-3">Syntymäpäivä</th>
                <th scope="col" class="px-6 py-3">Sukupuoli</th>
                <th scope="col" class="px-6 py-3">Ryhmä</th>
                <th scope="col" class="px-6 py-3"></th>
            </thead>
            <tbody>
                <tr
                    v-for="dog in dogs"
                    class="bg-white border-b border-gray-200 hover:bg-gray-50"
                >
                    <td class="px-6 py-4">{{ dog.nickname }}</td>
                    <td class="px-6 py-4">{{ dog.name }}</td>
                    <td class="px-6 py-4">{{ dog.birthday }}</td>
                    <td class="px-6 py-4">{{ dog.gender }}</td>
                    <td class="px-6 py-4">{{ dog.dog_group }}</td>
                    <td class="px-6 py-4">
                        <SecondaryButton class="">Näytä</SecondaryButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
