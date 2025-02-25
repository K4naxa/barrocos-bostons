<script setup lang="ts">
import ManagementLayout from "../../Layouts/ManagementLayout.vue";

import TextInput from "../../Components/TextInput.vue";
import { ref, defineProps, onMounted, computed } from "vue";
import axios from "axios";
defineOptions({ layout: ManagementLayout });

// First, let's define interfaces for our dog type
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

// Initialize the form data
const newDog = ref<Dog>({
    name: "",
    nickname: "",
    birthday: "",
    gender: "male",
    dog_group: "not_own",
    pedigree_url: "",
    owners: [],
    medical_examinations: [],
});

// Add owner
const newOwner = ref<Partial<Owner>>({
    name: "",
});

const addOwner = () => {
    if (newOwner.value.name) {
        newDog.value.owners.push({
            id: Date.now(), // temporary ID
            name: newOwner.value.name,
        });
        newOwner.value.name = "";
    }
};

// Remove owner
const removeOwner = (index: number) => {
    newDog.value.owners.splice(index, 1);
};

// Add medical examination
const newExamination = ref<Partial<MedicalExamination>>({
    date: "",
    description: "",
});

const addExamination = () => {
    if (newExamination.value.date && newExamination.value.description) {
        newDog.value.medical_examinations.push({
            id: Date.now(), // temporary ID
            date: newExamination.value.date,
            description: newExamination.value.description,
        });
        newExamination.value.date = "";
        newExamination.value.description = "";
    }
};

// Remove medical examination
const removeExamination = (index: number) => {
    newDog.value.medical_examinations.splice(index, 1);
};

// Form validation state
const errors = ref<Partial<Record<keyof Dog, string>>>({});

// Form submission handler
const handleSubmit = async () => {
    try {
        // Validate form
        if (!validateForm()) return;

        await axios.post("/api/dogs/store", newDog.value);

        // Reset form after successful submission
        resetForm();

        // Show success message
        alert("Dog created successfully!");
    } catch (error) {
        console.error("Error creating dog:", error);
    }
};

// Form validation
const validateForm = (): boolean => {
    errors.value = {};
    let isValid = true;

    if (!newDog.value.name.trim()) {
        errors.value.name = "Name is required";
        isValid = false;
    }

    if (!newDog.value.birthday) {
        errors.value.birthday = "Birthday is required";
        isValid = false;
    }

    if (!newDog.value.gender) {
        errors.value.gender = "Gender is required";
        isValid = false;
    }

    return isValid;
};

// Reset form
const resetForm = () => {
    newDog.value = {
        name: "",
        nickname: "",
        birthday: "",
        gender: "male",
        dog_group: "not_own",
        pedigree_url: "",
        owners: [],
        medical_examinations: [],
    };
    errors.value = {};
};
</script>

<template>
    <div class="max-w-2xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Uuden koiran luonti</h1>

        <form
            @submit.prevent="handleSubmit"
            @keydown.enter.prevent
            class="space-y-4"
        >
            <!-- Nickname -->
            <div>
                <label
                    for="nickname"
                    class="block text-sm font-medium text-gray-700"
                    >Kutsumani nimi</label
                >
                <input
                    id="nickname"
                    v-model="newDog.nickname"
                    type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                />
            </div>
            <!-- Name -->
            <div>
                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                    >Virallinen nimi</label
                >
                <input
                    id="name"
                    v-model="newDog.name"
                    type="text"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    :class="{ 'border-red-500': errors.name }"
                />
                <span v-if="errors.name" class="text-red-500 text-sm">{{
                    errors.name
                }}</span>
            </div>

            <!-- Birthday -->
            <div>
                <label
                    for="birthday"
                    class="block text-sm font-medium text-gray-700"
                    >Syntymäpäivä</label
                >
                <input
                    id="birthday"
                    v-model="newDog.birthday"
                    type="date"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    :class="{ 'border-red-500': errors.birthday }"
                />
                <span v-if="errors.birthday" class="text-red-500 text-sm">{{
                    errors.birthday
                }}</span>
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700"
                    >Sukupuoli</label
                >
                <div class="mt-1 space-x-4">
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="newDog.gender"
                            value="male"
                            class="form-radio"
                        />
                        <span class="ml-2">Uros</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="newDog.gender"
                            value="female"
                            class="form-radio"
                        />
                        <span class="ml-2">Naaras</span>
                    </label>
                </div>
                <span v-if="errors.gender" class="text-red-500 text-sm">{{
                    errors.gender
                }}</span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700"
                    >Koiran ryhmä</label
                >
                <div class="mt-1 space-x-4">
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="newDog.dog_group"
                            value="females"
                            class="form-radio"
                        />
                        <span class="ml-2">Urokset</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="newDog.dog_group"
                            value="males"
                            class="form-radio"
                        />
                        <span class="ml-2">Naaraat</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="newDog.dog_group"
                            value="memoriam"
                            class="form-radio"
                        />
                        <span class="ml-2">Menehtyneet</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input
                            type="radio"
                            v-model="newDog.dog_group"
                            value="not_own"
                            class="form-radio"
                        />
                        <span class="ml-2">Ei oma</span>
                    </label>
                </div>
                <span v-if="errors.gender" class="text-red-500 text-sm">{{
                    errors.gender
                }}</span>
            </div>

            <!-- Pedigree URL -->
            <div>
                <label
                    for="pedigree_url"
                    class="block text-sm font-medium text-gray-700"
                    >Sukutaulu linkki</label
                >
                <input
                    placeholder="jalostus.kennelliito.fi/#######"
                    id="pedigree_url"
                    v-model="newDog.pedigree_url"
                    type="url"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                />
            </div>
            <!-- Owners -->
            <div>
                <h3 class="text-lg font-medium text-gray-700">Omistajat</h3>
                <div class="mt-2 space-y-2">
                    <div
                        v-for="(owner, index) in newDog.owners"
                        :key="owner.id"
                        class="flex items-center space-x-2"
                    >
                        <span>{{ owner.name }}</span>
                        <button
                            @click="removeOwner(index)"
                            class="text-red-500"
                        >
                            Poista
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <input
                            @keydown.enter="addOwner"
                            v-model="newOwner.name"
                            type="text"
                            class="form-input"
                        />
                        <button
                            @click="addOwner"
                            class="px-3 py-1 bg-green-500 text-white rounded"
                        >
                            Lisää
                        </button>
                    </div>
                </div>
            </div>

            <!-- Medical Examinations -->
            <div>
                <h3 class="text-lg font-medium text-gray-700">
                    Terveystulokset
                </h3>
                <div class="mt-2 space-y-2">
                    <div
                        v-for="(exam, index) in newDog.medical_examinations"
                        :key="exam.id"
                        class="flex items-center space-x-2"
                    >
                        <span>{{ exam.date }} - {{ exam.description }}</span>
                        <button
                            @click="removeExamination(index)"
                            class="text-red-500"
                        >
                            Poista
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <input
                            v-model="newExamination.date"
                            type="date"
                            class="form-input"
                        />
                        <input
                            v-model="newExamination.description"
                            type="text"
                            placeholder="Tulos"
                            class="form-input"
                        />
                        <button
                            @click="addExamination"
                            class="px-3 py-1 bg-green-500 text-white rounded"
                        >
                            Lisää
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <button
                    type="button"
                    @click="resetForm"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    Nollaa
                </button>
                <button
                    type="submit"
                    class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700"
                >
                    Luo koira
                </button>
            </div>
        </form>
    </div>
</template>
