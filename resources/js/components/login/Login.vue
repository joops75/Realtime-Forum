<template>
    <v-container>
        <v-form @submit.prevent="login">
            <span class="red--text" v-if="error">{{ error }}</span>

            <v-text-field
                label="E-mail"
                v-model="form.email"
                type="email"
                required
            ></v-text-field>
            
            <v-text-field
                label="Password"
                v-model="form.password"
                type="password"
                required
            ></v-text-field>

            <v-btn
                color="green"
                type="submit"
            >Login</v-btn>
        </v-form>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: null,
                password: null
            },
            error: null
        }
    },
    created() {
        if (User.loggedIn()) {
            this.$router.push('/forum');
        }
    },
    methods: {
        async login() {
            const res = await User.login(this.form);
            if (res && res.hasOwnProperty('error')) {
                this.error = res.error;
            } else {
                this.error = null;
            }
        }
    }
}
</script>
