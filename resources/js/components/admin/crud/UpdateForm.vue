<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
    entity: {
        type: Object,
        required: true,
    },
    fields: {
        type: Array,
        required: true,
    },
    title: {
        type: String,
        default: 'Update Entity',
    },
});

const emit = defineEmits(['save', 'close']);

const form = reactive({ ...props.entity });

watch(
    () => props.entity,
    (newVal) => {
        Object.assign(form, newVal);
    },
    { deep: true }
);

const save = () => {
    emit('save', { ...form });
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
                    v-model="form[field.model]"
                    :label="field.label"
                    outlined
                    required
                />
                <v-textarea
                    v-else-if="field.type === 'textarea'"
                    v-model="form[field.model]"
                    :label="field.label"
                    clearable
                    outlined
                />
                <v-select
                    v-else-if="field.type === 'select'"
                    v-model="form[field.model]"
                    :label="field.label"
                    :items="field.options"
                    outlined
                />
            </template>
        </v-card-text>
        <v-card-actions>
            <v-btn color="green" @click="save">Save</v-btn>
            <v-btn color="red" @click="close">Cancel</v-btn>
        </v-card-actions>
    </v-card>
</template>
