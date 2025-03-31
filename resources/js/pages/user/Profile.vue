<script setup>
import {computed, ref} from "vue"
import {useAuthStore} from "@/stores/auth.js"
import {useRouter} from "vue-router"
import ProfileEdit from "@/components/profile/ProfileEdit.vue"
import Profile from "@/components/profile/Profile.vue"
import Avatar from "@/components/profile/Avatar.vue"
import ImageUpload from "@/components/ui/ImageUpload.vue";
import Setting from "@/components/user/common/Setting.vue";

const authStore = useAuthStore()
const router = useRouter()

const isLoading = computed(() => authStore.isLoading);
const user = computed(() => authStore.userData)

const tab = ref('option-1')
const showEditModal = ref(false)

const openEditModal = () => {
    showEditModal.value = true;
};

const closeEditModal = () => {
    showEditModal.value = false;
};

const updateUser = (updatedData) => {
    if (authStore.userData) {
        Object.assign(authStore.userData, updatedData)
    }
};

const updateAvatar = (avatarUrl) => {
    if (authStore.userData) {
        authStore.userData.avatar = avatarUrl
    }
};
</script>

<template>
    <v-container class="mt-5">
        <v-card v-if="isLoading">
            <v-card-text class="text-center">
                <v-progress-circular indeterminate color="blue-darken-3" size="64"></v-progress-circular>
                <p>Loading data...</p>
            </v-card-text>
        </v-card>

        <v-card v-else>
            <v-card :title="user.name" color="blue-darken-1" variant="tonal"/>

            <div class="d-flex flex-row">
                <v-tabs
                    v-model="tab"
                    color="blue-darken-3"
                    direction="vertical"
                >
                    <v-tab prepend-icon="mdi-account" text="Personal" value="option-1"></v-tab>
                    <v-tab prepend-icon="mdi-image" text="Images" value="option-2"></v-tab>
                    <v-tab prepend-icon="mdi-lock" text="Settings" value="option-3"></v-tab>
                </v-tabs>

                <v-tabs-window v-model="tab">
                    <v-tabs-window-item value="option-1">
                        <v-container>
                            <v-row>
                                <Profile
                                    :user="user"
                                />
                            </v-row>
                            <v-row class="mt-6 mb-3">
                                <v-col>
                                    <v-btn
                                        class="text-none font-weight-regular"
                                        prepend-icon="mdi-pencil"
                                        text="Edit Profile"
                                        color="blue-darken-3"
                                        size="large"
                                        variant="tonal"
                                        @click="openEditModal"
                                    ></v-btn>

                                    <v-dialog v-model="showEditModal" max-width="600">
                                        <ProfileEdit
                                            :user="user"
                                            @update-user="updateUser"
                                            @close="closeEditModal"
                                        />
                                    </v-dialog>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-tabs-window-item>

                    <v-tabs-window-item value="option-2">
                        <v-container>
                            <v-row v-if="user.avatar">
                                <v-card-item>
                                    <Avatar
                                        :avatar="user.avatar"
                                        :size="120"
                                    />
                                </v-card-item>
                            </v-row>
                            <v-row>
                                <ImageUpload
                                    :entity="user"
                                    @image-updated="updateAvatar"
                                />
                            </v-row>
                        </v-container>
                    </v-tabs-window-item>

                    <v-tabs-window-item value="option-3">
                        <Setting></Setting>
                    </v-tabs-window-item>
                </v-tabs-window>
            </div>
        </v-card>
    </v-container>
</template>
