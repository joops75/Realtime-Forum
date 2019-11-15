<template>
    <div v-if="unreadNotifications.length" class="text-xs-center">
        <v-menu offset-y>
            <template v-slot:activator="{ on }">
                <v-btn icon v-on="on">
                    <v-icon color="red">add_alert</v-icon>
                    {{ unreadNotifications.length }}
                </v-btn>
            </template>
            <v-list>
                <v-list-tile v-for="(unreadNotification, index) in unreadNotifications" :key="unreadNotification.id">
                    <router-link :to="unreadNotification.data.question_path">
                        <v-list-tile-title @click="markAsRead(unreadNotification, index)">{{ unreadNotification.data.question_title }}</v-list-tile-title>
                    </router-link>
                </v-list-tile>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
export default {
    data() {
        return {
            readNotifications: [],
            unreadNotifications: []
        }
    },
    created() {
        if (User.loggedIn()) {
            this.getNotifications();
        }
    },
    methods: {
        getNotifications() {
            axios.get('/api/notification')
                .then(res => {
                    this.readNotifications = res.data.readNotifications;
                    this.unreadNotifications = res.data.unreadNotifications;
                })
                .catch(err => console.log(err.response.data));
        },
        markAsRead(notification, index) {
            axios.post('/api/notification', { id: notification.id })
                .then(res => {
                    this.unreadNotifications.splice(index, 1);
                    this.readNotifications.unshift(notification);
                })
                .catch(err => console.log(err.response.data));
        }
    }
}
</script>