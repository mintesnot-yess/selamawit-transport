<template>
    <div class="register-container">
        <h2>Create Account</h2>
        <form @submit.prevent="handleSubmit">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    required
                    placeholder="Enter your full name"
                />
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    placeholder="Enter your email"
                />
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="form.password"
                    type="password"
                    required
                    placeholder="Create a password"
                    minlength="8"
                />
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    required
                    placeholder="Confirm your password"
                    minlength="8"
                />
            </div>

            <button type="submit" :disabled="loading">
                {{ loading ? "Creating account..." : "Register" }}
            </button>

            <div v-if="error" class="error-message">
                <p v-if="typeof error === 'string'">{{ error }}</p>
                <ul v-else>
                    <li v-for="(err, field) in error" :key="field">
                        {{ field }}: {{ err[0] }}
                    </li>
                </ul>
            </div>

            <p class="login-link">
                Already have an account?
                <router-link to="/login">Login here</router-link>
            </p>
        </form>
    </div>
</template>

<script>
import authService from "@/services/auth";

export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
            loading: false,
            error: null,
        };
    },
    methods: {
        async handleSubmit() {
            this.loading = true;
            this.error = null;

            // Basic client-side validation
            if (this.form.password !== this.form.password_confirmation) {
                this.error = "Passwords don't match";
                this.loading = false;
                return;
            }

            try {
                const { access_token } = await authService.register(this.form);

                // Automatically log in the user after registration
                authService.setAuthToken(access_token);
                await authService.fetchUser();

                // Redirect to dashboard
                this.$router.push("/");
            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.register-container {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

button {
    background-color: #42b983;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    margin-top: 1rem;
    width: 100%;
}

button:disabled {
    background-color: #cccccc;
    cursor: not-allowed;
}

.error-message {
    color: #f44336;
    margin: 1rem 0;
    padding: 0.5rem;
    background-color: #ffebee;
    border-radius: 4px;
}

.error-message ul {
    margin: 0;
    padding-left: 1rem;
}

.login-link {
    margin-top: 1rem;
    text-align: center;
}

.login-link a {
    color: #42b983;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}
</style>
