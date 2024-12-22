<script setup>
import { reactive } from 'vue';

const props = defineProps({
    title: { type: String, required: true },
    fields: { type: Array, required: true },
});

const emit = defineEmits(['save', 'close']);

const formData = reactive(
    props.fields.reduce((acc, field) => {
        acc[field.model] = null;
        return acc;
    }, {})
);

const save = () => {
    const isValid = props.fields.every(field => formData[field.model]);
    if (isValid) {
        emit('save', { ...formData });
    } else {
        console.error('All fields are required');
    }
};

const close = () => {
    emit('close');
};
</script>

<template>
    <v-card>
        <v-card-title>{{ title }}</v-card-title>
        <v-card-text>
            <template v-for="field in fields" :key="field.model">
                <v-text-field
                    v-if="field.type === 'text'"
                    v-model="formData[field.model]"
                    :label="field.label"
                    outlined
                    required
                />
                <v-textarea
                    v-else-if="field.type === 'textarea'"
                    v-model="formData[field.model]"
                    :label="field.label"
                    clear-icon="mdi-close-circle"
                    clearable
                />
            </template>
        </v-card-text>
        <v-card-actions>
            <v-btn color="green" @click="save">Save</v-btn>
            <v-btn color="red" @click="close">Cancel</v-btn>
        </v-card-actions>
    </v-card>
</template>
