<template>
  <q-dropdown v-model="isDropdownVisible">
    <q-btn
      type="button"
      color="primary"
      label="Notifications"
      icon="notifications"
      @click="toggleDropdown"
    />
    <q-list>
      <q-item v-for="notification in notifications" :key="notification.id">
        <q-item-section>{{ notification.message }}</q-item-section>
        <q-item-section side>
          <q-btn icon="close" @click="removeNotification(notification.id)" />
        </q-item-section>
      </q-item>
    </q-list>
  </q-dropdown>
</template>

<script>
export default {
  data() {
    return {
      isDropdownVisible: false,
      notifications: [
        { id: 1, message: "New announcement 1" },
        { id: 2, message: "New announcement 2" },
        // Add your notifications here
      ],
    };
  },
  methods: {
    toggleDropdown() {
      this.isDropdownVisible = !this.isDropdownVisible;
    },
    removeNotification(id) {
      this.notifications = this.notifications.filter((notification) => notification.id !== id);
    },
  },
};
</script>

<style scoped>
/* Add your styles here */
</style>
