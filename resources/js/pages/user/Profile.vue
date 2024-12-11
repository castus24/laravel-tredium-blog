<script setup>
import {computed, reactive, ref} from "vue"
import ProfileEdit from "@/components/profile/ProfileEdit.vue"
import Profile from "@/components/profile/Profile.vue"
import AvatarUpload from "@/components/profile/AvatarUpload.vue"
import{useAuthStore} from "@/stores/auth.js"

const authStore = useAuthStore()
const user = computed(() => authStore.userData)

const tab = ref('option-1')
const showEditModal = ref(false)

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
        <v-card>
            <v-card :title="user.name" color="blue-darken-1" variant="tonal"></v-card>

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
                                        @click="showEditModal = true"
                                    ></v-btn>

                                    <v-dialog v-model="showEditModal" max-width="600">
                                        <ProfileEdit
                                            :user="user"
                                            @update-user="updateUser"
                                            @close="showEditModal = false"
                                        />
                                    </v-dialog>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-tabs-window-item>

                    <v-tabs-window-item value="option-2">
                        <AvatarUpload
                            :current-avatar="user.avatar"
                            @avatar-updated="updateAvatar"
                        />
                    </v-tabs-window-item>

                    <v-tabs-window-item value="option-3">
                        <v-card flat>
                            <v-card-text>
                                111
                            </v-card-text>
                        </v-card>
                    </v-tabs-window-item>
                </v-tabs-window>
            </div>
        </v-card>
    </v-container>
</template>
