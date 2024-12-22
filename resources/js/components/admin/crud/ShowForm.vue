<script setup>
import ImageAlert from "@/components/admin/common/ui/ImageAlert.vue";
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    entity: {
        type: Object,
        required: true,
    },
    titleKey: {
        type: String,
        default: 'title',
    },
    contentKey: {
        type: String,
        default: 'content',
    },
    imageKey: {
        type: String,
        default: 'main',
    },
});

const emit = defineEmits(['close']);
</script>

<template>
    <v-card class="mx-auto" min-width="400">
        <v-img
            v-if="entity?.[imageKey]"
            min-height="200"
            :src="entity[imageKey]"
            cover
        ></v-img>
        <ImageAlert v-else/>

        <v-divider></v-divider>

        <v-list class="mx-5">
            <v-list-item-title class="text-h4">{{ entity?.[titleKey] }}</v-list-item-title>
            <v-list-item-subtitle class="text-h6">{{ entity?.[contentKey] }}</v-list-item-subtitle>
        </v-list>

        <v-card-actions>
            <v-btn color="blue-grey" @click="$emit('close')">Close</v-btn>
        </v-card-actions>
    </v-card>
</template>
