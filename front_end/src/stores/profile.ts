
import { defineStore } from "pinia";

interface ProfileState {
    user: null,
    permissions: string[],
    isLoading: boolean,
    token: string | null,
}

export const useProfileStore = defineStore('profile', {
    state: (): ProfileState => ({
        user: null,
        permissions: [],
        isLoading: false,
        token: localStorage.getItem('auth_token'),
    }),

    // actions: {
    //     async fetchProfile() {
    //         this.isLoading = true;
    //         try {
    //             const response = await apiClient.get(${ api.profile });
    //             this.user = response.data.user;
    //             this.permissions = response.data.permissions;
    //         } catch (error) {
    //             handleApiError(error);
    //         } finally {
    //             this.isLoading = false;
    //         }
    //     },
    //     async updateProfile(data: Partial<User>) {
    //         this.isLoading = true;
    //         try {

    //             const response = (await apiClient.put(${ api.updateProfile }, data)).data;

    //             if (this.user) {
    //                 this.user = response.data;
    //             }
    //             showSuccess("Profile", 'updated');
    //         } catch (error) {
    //             handleApiError(error);
    //         } finally {
    //             this.isLoading = false;
    //         }
    //     },

    //     async changePassword(values: { old_password: string, new_password: string, confirm_password: string }) {
    //         this.isLoading = true;
    //         try {
    //             const authStore = useAuthStore();
    //             await apiClient.put(${ api.updatePassword }, values);

    //             showSuccess("Password", "updated");

    //             setTimeout(() => {
    //                 authStore.logout();
    //             }, 2500);

    //         } catch (error: any) {
    //             handleApiError(error);
    //         } finally {
    //             this.isLoading = false;
    //         }
    //     },

    //     clearProfile() {
    //         this.user = null;
    //     },
    // },
    getters: {
        hasPermission: (state) => (permission: string) => {
            return state.permissions.includes(permission);
        },
    },
    persist: true,
});